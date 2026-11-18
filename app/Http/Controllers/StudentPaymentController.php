<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentPayment;
use App\Models\Transaction;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentPaymentController extends Controller
{
    private const MONTHLY_FEE = 10000;

    // KATEGORI PEMASUKAN
    private const INCOME_CATEGORIES = [
        'Denda Piket Siswa',
        'Donasi & Sumbangan',
        'Iuran Kas Siswa',
        'Kas Awal / Saldo Awal',
        'Pemasukan Lainnya',
    ];

    // KATEGORI PENGELUARAN
    private const EXPENSE_CATEGORIES = [
        'Alat & Perlengkapan Belajar',
        'Fotokopi & Cetak Dokumen',
        'Kebersihan & Sanitasi Kelas',
        'Konsumsi & Acara Kelas',
        'Pengeluaran Lainnya',
        'Sosial & Santunan Siswa',
    ];

    // Samakan kategori tampilan dengan kategori lama di database.
    private function normalizeCategory(?string $category): string
    {
        if ($category === null || $category === '') {
            return '';
        }

        return match ($category) {
            'Iuran Kas Siswa' => 'Kas Siswa',
            'Pemasukan Lainnya' => 'Lainnya',
            default => $category,
        };
    }

    // ================================================================
    // INDEX
    // ================================================================

    public function index(Request $request)
    {
        $selectedYear = (int) $request->input('year', now()->year);

        if ($selectedYear < 2020 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        $search = trim((string) ($request->input('search') ?? ''));
        $type = (string) ($request->input('type') ?? '');
        $category = (string) ($request->input('category') ?? '');
        $fromDate = (string) ($request->input('from_date') ?? '');
        $toDate = (string) ($request->input('to_date') ?? '');

        // DATA SISWA
        $students = Student::orderBy('name')->get();

        // DATA PEMBAYARAN SISWA
        $payments = StudentPayment::whereIn(
            'student_id',
            $students->pluck('id')
        )
            ->whereYear('payment_month', $selectedYear)
            ->get()
            ->groupBy('student_id');

        $studentPayments = $students->map(
            function ($student) use ($payments, $selectedYear) {
                $paymentData = $payments->get(
                    $student->id,
                    collect()
                );

                $monthlyPayments = [];

                for ($i = 1; $i <= 12; $i++) {
                    $month = Carbon::create($selectedYear, $i, 1);

                    $amount = $paymentData
                        ->filter(function ($item) use ($month) {
                            return Carbon::parse($item->payment_month)
                                ->format('Y-m') === $month->format('Y-m');
                        })
                        ->sum('amount');

                    $amount = (float) $amount;

                    $monthlyPayments[] = [
                        'month' => $month->format('Y-m-d'),
                        'label' => $month->translatedFormat('M'),
                        'amount' => $amount,
                        'paid' => $amount >= self::MONTHLY_FEE,
                        'payment_id' => null,
                    ];
                }

                return [
                    'student' => $student,
                    'months' => $monthlyPayments,
                    'total' => collect($monthlyPayments)->sum('amount'),
                ];
            }
        );

        // QUERY TRANSAKSI
        $transactionQuery = Transaction::query();

        // FILTER JENIS TRANSAKSI
        if (in_array($type, ['in', 'out'], true)) {
            $transactionQuery->where('type', $type);
        }

        // FILTER KATEGORI
        if ($category !== '') {
            $storedCategory = $this->normalizeCategory($category);

            $transactionQuery->where(
                'category',
                $storedCategory
            );
        }

        // FILTER TANGGAL MULAI
        if ($fromDate !== '') {
            $transactionQuery->whereDate('created_at', '>=', $fromDate);
        }

        // FILTER TANGGAL AKHIR
        if ($toDate !== '') {
            $transactionQuery->whereDate('created_at', '<=', $toDate);
        }

        // PENCARIAN KATEGORI DAN KETERANGAN
        if ($search !== '') {
            $transactionQuery->where(function ($query) use ($search) {
                $query->where('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // PAGINATION
        $transactions = $transactionQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // TOTAL KESELURUHAN TRANSAKSI
        // Tidak terpengaruh filter, pencarian, atau pagination.
        $totalPemasukan = Transaction::where(
            'type',
            'in'
        )->sum('amount');

        $totalPengeluaran = Transaction::where(
            'type',
            'out'
        )->sum('amount');

        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        return view('transactions.index', [
            'students' => $students,
            'studentPayments' => $studentPayments,
            'transactions' => $transactions,
            'selectedYear' => $selectedYear,
            'monthlyFee' => self::MONTHLY_FEE,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalSaldo' => $totalSaldo,
            'search' => $search,
            'type' => $type,
            'category' => $category,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'incomeCategories' => self::INCOME_CATEGORIES,
            'expenseCategories' => self::EXPENSE_CATEGORIES,
        ]);
    }

    // ================================================================
    // STORE TRANSAKSI
    // ================================================================

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        // VALIDASI KATEGORI SESUAI JENIS TRANSAKSI
        if ($request->type === 'in') {
            $request->validate([
                'category' => 'required|in:' .
                    implode(',', self::INCOME_CATEGORIES),
            ]);
        } else {
            $request->validate([
                'category' => 'required|in:' .
                    implode(',', self::EXPENSE_CATEGORIES),
            ]);
        }

        $category = $this->normalizeCategory($request->category);

        // PEMBAYARAN KAS SISWA
        if (
            $request->type === 'in' &&
            $category === 'Kas Siswa'
        ) {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'payment_month' => 'required|date_format:Y-m',
            ]);

            return $this->storeStudentPayment($request);
        }

        // TRANSAKSI BIASA
        Transaction::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $category,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    // ================================================================
    // STORE PEMBAYARAN SISWA
    // ================================================================

    private function storeStudentPayment(Request $request)
    {
        $transactionMonth = Carbon::createFromFormat(
            'Y-m',
            $request->payment_month
        )->startOfMonth();

        $transactionYear = $transactionMonth->year;

        $student = Student::with('user')->findOrFail(
            (int) $request->student_id
        );

        $transaction = null;

        DB::transaction(
            function () use (
                $request,
                $transactionMonth,
                $student,
                &$transaction
            ) {
                $studentId = (int) $request->student_id;
                $remaining = (float) $request->amount;

                $transaction = Transaction::create([
                    'type' => 'in',
                    'amount' => $request->amount,
                    'category' => 'Kas Siswa',
                    'description' =>
                        'Pembayaran kas siswa - ' .
                        $student->name .
                        ' - ' .
                        $transactionMonth->translatedFormat('F Y') .
                        ' - Rp ' .
                        number_format(
                            $request->amount,
                            0,
                            ',',
                            '.'
                        ),
                ]);

                // ALOKASI KE BULAN PEMBAYARAN
                $allocationMonth = $transactionMonth
                    ->copy()
                    ->startOfYear();

                while ($remaining > 0) {
                    $payment = StudentPayment::where(
                        'student_id',
                        $studentId
                    )
                        ->whereDate(
                            'payment_month',
                            $allocationMonth->format('Y-m-d')
                        )
                        ->first();

                    if (!$payment) {
                        $payment = new StudentPayment();

                        $payment->student_id = $studentId;
                        $payment->transaction_id = $transaction->id;
                        $payment->payment_month =
                            $allocationMonth->format('Y-m-d');
                        $payment->amount = 0;
                    } else {
                        if (!$payment->transaction_id) {
                            $payment->transaction_id = $transaction->id;
                        }
                    }

                    $currentAmount = (float) $payment->amount;

                    if ($currentAmount >= self::MONTHLY_FEE) {
                        $allocationMonth->addMonth();
                        continue;
                    }

                    $remainingForMonth =
                        self::MONTHLY_FEE - $currentAmount;

                    $allocation = min(
                        $remaining,
                        $remainingForMonth
                    );

                    $payment->amount = $currentAmount + $allocation;
                    $payment->paid_at = now();
                    $payment->save();

                    $remaining -= $allocation;
                    $allocationMonth->addMonth();
                }
            }
        );

        // NOTIFIKASI SISWA
        if ($student->user_id && $transaction) {
            Notification::create([
                'user_id' => $student->user_id,
                'type' => 'pembayaran_berhasil',
                'title' => 'Pembayaran Berhasil Dicatat',
                'message' =>
                    'Pembayaran kas sebesar Rp ' .
                    number_format(
                        (float) $request->amount,
                        0,
                        ',',
                        '.'
                    ) .
                    ' untuk ' .
                    $transactionMonth->translatedFormat('F Y') .
                    ' telah berhasil dicatat oleh bendahara.',
            ]);
        }

        return redirect()
            ->route('transactions.index', [
                'year' => $transactionYear,
            ])
            ->with(
                'success',
                'Pembayaran kas siswa berhasil dicatat.'
            );
    }

    // ================================================================
    // UPDATE TRANSAKSI
    // ================================================================

    public function updateTransaction(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        // TRANSAKSI BIASA
        if ($transaction->category !== 'Kas Siswa') {

            if ($transaction->type === 'in') {
                $request->validate([
                    'category' => 'required|in:' .
                        implode(',', self::INCOME_CATEGORIES),
                ]);
            } else {
                $request->validate([
                    'category' => 'required|in:' .
                        implode(',', self::EXPENSE_CATEGORIES),
                ]);
            }

            $category = $this->normalizeCategory(
                $request->category
            );

            $transaction->update([
                'category' => $category,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);

            return redirect()
                ->route('transactions.index')
                ->with(
                    'success',
                    'Transaksi berhasil diperbarui.'
                );
        }

        // TRANSAKSI KAS SISWA
        $linkedPayments = StudentPayment::where(
            'transaction_id',
            $transaction->id
        )
            ->orderBy('payment_month')
            ->get();

        $oldAmount = (float) $transaction->amount;
        $newAmount = (float) $request->amount;

        $studentId = $linkedPayments->first()?->student_id;

        $student = $studentId
            ? Student::with('user')->find($studentId)
            : null;

        DB::transaction(
            function () use (
                $transaction,
                $linkedPayments,
                $oldAmount,
                $newAmount
            ) {
                // NOMINAL SAMA
                if ($oldAmount === $newAmount) {
                    $transaction->description =
                        $this->updateAmountInDescription(
                            $transaction->description,
                            $newAmount
                        );

                    $transaction->save();

                    return;
                }

                // NOMINAL DIKURANGI
                if ($newAmount < $oldAmount) {
                    $difference = $oldAmount - $newAmount;

                    foreach (
                        $linkedPayments->sortByDesc('payment_month')
                        as $payment
                    ) {
                        if ($difference <= 0) {
                            break;
                        }

                        $currentAmount = (float) $payment->amount;

                        $deduct = min(
                            $difference,
                            $currentAmount
                        );

                        $payment->amount = $currentAmount - $deduct;

                        if ($payment->amount <= 0) {
                            $payment->delete();
                        } else {
                            $payment->paid_at = now();
                            $payment->save();
                        }

                        $difference -= $deduct;
                    }
                }

                // NOMINAL DITAMBAH
                if ($newAmount > $oldAmount) {
                    $difference = $newAmount - $oldAmount;

                    $lastPaymentMonth = $linkedPayments->max(
                        'payment_month'
                    );

                    if ($lastPaymentMonth) {
                        $allocationMonth = Carbon::parse(
                            $lastPaymentMonth
                        )
                            ->startOfMonth()
                            ->addMonth();
                    } else {
                        $allocationMonth = now()->startOfYear();
                    }

                    $studentId = $linkedPayments->first()?->student_id;

                    if (!$studentId) {
                        throw new \RuntimeException(
                            'Data siswa untuk pembayaran ini tidak ditemukan.'
                        );
                    }

                    while ($difference > 0) {
                        $payment = StudentPayment::where(
                            'student_id',
                            $studentId
                        )
                            ->whereDate(
                                'payment_month',
                                $allocationMonth->format('Y-m-d')
                            )
                            ->first();

                        if (!$payment) {
                            $payment = new StudentPayment();

                            $payment->student_id = $studentId;
                            $payment->transaction_id = $transaction->id;
                            $payment->payment_month =
                                $allocationMonth->format('Y-m-d');
                            $payment->amount = 0;
                        } elseif (!$payment->transaction_id) {
                            $payment->transaction_id = $transaction->id;
                        }

                        $currentAmount = (float) $payment->amount;

                        $remainingForMonth = max(
                            0,
                            self::MONTHLY_FEE - $currentAmount
                        );

                        if ($remainingForMonth <= 0) {
                            $allocationMonth->addMonth();
                            continue;
                        }

                        $allocation = min(
                            $difference,
                            $remainingForMonth
                        );

                        $payment->amount =
                            $currentAmount + $allocation;

                        $payment->paid_at = now();
                        $payment->save();

                        $difference -= $allocation;
                        $allocationMonth->addMonth();
                    }
                }

                // UPDATE HISTORY TRANSAKSI
                $transaction->amount = $newAmount;

                $transaction->description =
                    $this->updateAmountInDescription(
                        $transaction->description,
                        $newAmount
                    );

                $transaction->save();
            }
        );

        // NOTIFIKASI PEMBAYARAN DIPERBARUI
        if (
            $student &&
            $student->user_id &&
            $oldAmount !== $newAmount
        ) {
            Notification::create([
                'user_id' => $student->user_id,
                'type' => 'pembayaran_diperbarui',
                'title' => 'Pembayaran Diperbarui',
                'message' =>
                    'Catatan pembayaran kas kamu telah diperbarui oleh bendahara. ' .
                    'Nominal sebelumnya Rp ' .
                    number_format($oldAmount, 0, ',', '.') .
                    ' menjadi Rp ' .
                    number_format($newAmount, 0, ',', '.') .
                    '.',
            ]);
        }

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaksi berhasil diperbarui.'
            );
    }

    // ================================================================
    // UPDATE NOMINAL DI DESCRIPTION
    // ================================================================

    private function updateAmountInDescription(
        ?string $description,
        float $amount
    ): string {
        $formattedAmount = 'Rp ' .
            number_format($amount, 0, ',', '.');

        if (!$description) {
            return $formattedAmount;
        }

        $updatedDescription = preg_replace(
            '/Rp\s*[0-9\.\,]+$/i',
            $formattedAmount,
            $description
        );

        if (
            $updatedDescription === null ||
            $updatedDescription === $description
        ) {
            return rtrim($description) .
                ' - ' .
                $formattedAmount;
        }

        return $updatedDescription;
    }

    // ================================================================
    // DELETE TRANSAKSI
    // ================================================================

    public function destroyTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        $linkedPayment = StudentPayment::where(
            'transaction_id',
            $transaction->id
        )
            ->with('student.user')
            ->first();

        $student = $linkedPayment?->student;

        DB::transaction(
            function () use ($transaction) {
                if ($transaction->category === 'Kas Siswa') {
                    StudentPayment::where(
                        'transaction_id',
                        $transaction->id
                    )->delete();
                }

                $transaction->delete();
            }
        );

        // NOTIFIKASI PEMBAYARAN DIHAPUS
        if ($student && $student->user_id) {
            Notification::create([
                'user_id' => $student->user_id,
                'type' => 'pembayaran_dihapus',
                'title' => 'Catatan Pembayaran Dihapus',
                'message' =>
                    'Catatan pembayaran kas sebesar Rp ' .
                    number_format(
                        (float) $transaction->amount,
                        0,
                        ',',
                        '.'
                    ) .
                    ' telah dihapus oleh bendahara.',
            ]);
        }

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaksi berhasil dihapus.'
            );
    }

    // ================================================================
    // UPDATE PAYMENT BULANAN
    // ================================================================

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' =>
                'required|numeric|min:0|max:' .
                self::MONTHLY_FEE,
        ]);

        $payment = StudentPayment::with('student.user')
            ->findOrFail($id);

        $year = Carbon::parse(
            $payment->payment_month
        )->year;

        $amount = (float) $request->amount;
        $student = $payment->student;
        $oldAmount = (float) $payment->amount;

        if ($amount <= 0) {
            $payment->delete();

            if ($student && $student->user_id) {
                Notification::create([
                    'user_id' => $student->user_id,
                    'type' => 'pembayaran_dihapus',
                    'title' => 'Pembayaran Dihapus',
                    'message' =>
                        'Catatan pembayaran kas bulan ' .
                        Carbon::parse(
                            $payment->payment_month
                        )->translatedFormat('F Y') .
                        ' telah dihapus.',
                ]);
            }

            return redirect()
                ->route('transactions.index', [
                    'year' => $year,
                ])
                ->with(
                    'success',
                    'Pembayaran bulan tersebut berhasil dikosongkan.'
                );
        }

        $payment->amount = $amount;
        $payment->paid_at = now();
        $payment->save();

        if (
            $student &&
            $student->user_id &&
            $oldAmount !== $amount
        ) {
            Notification::create([
                'user_id' => $student->user_id,
                'type' => 'pembayaran_diperbarui',
                'title' => 'Pembayaran Diperbarui',
                'message' =>
                    'Pembayaran kas bulan ' .
                    Carbon::parse(
                        $payment->payment_month
                    )->translatedFormat('F Y') .
                    ' telah diperbarui dari Rp ' .
                    number_format($oldAmount, 0, ',', '.') .
                    ' menjadi Rp ' .
                    number_format($amount, 0, ',', '.') .
                    '.',
            ]);
        }

        return redirect()
            ->route('transactions.index', [
                'year' => $year,
            ])
            ->with(
                'success',
                'Nominal pembayaran berhasil diperbarui.'
            );
    }

    // ================================================================
    // DELETE PAYMENT BULANAN
    // ================================================================

    public function destroy($id)
    {
        $payment = StudentPayment::with('student.user')
            ->findOrFail($id);

        $year = Carbon::parse(
            $payment->payment_month
        )->year;

        $student = $payment->student;
        $amount = (float) $payment->amount;

        $month = Carbon::parse(
            $payment->payment_month
        )->translatedFormat('F Y');

        $payment->delete();

        if ($student && $student->user_id) {
            Notification::create([
                'user_id' => $student->user_id,
                'type' => 'pembayaran_dihapus',
                'title' => 'Catatan Pembayaran Dihapus',
                'message' =>
                    'Catatan pembayaran kas bulan ' .
                    $month .
                    ' sebesar Rp ' .
                    number_format($amount, 0, ',', '.') .
                    ' telah dihapus oleh bendahara.',
            ]);
        }

        return redirect()
            ->route('transactions.index', [
                'year' => $year,
            ])
            ->with(
                'success',
                'Catatan pembayaran berhasil dihapus.'
            );
    }
}
