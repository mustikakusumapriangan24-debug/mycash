<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentPayment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentPaymentController extends Controller
{
    private const MONTHLY_FEE = 10000;

    // ================================================================
    // INDEX
    // ================================================================

    public function index(Request $request)
    {
        $selectedYear = (int) $request->get(
            'year',
            now()->year
        );

        if (
            $selectedYear < 2020 ||
            $selectedYear > 2100
        ) {
            $selectedYear = now()->year;
        }

        // ------------------------------------------------------------
        // DATA SISWA
        // ------------------------------------------------------------

        $students = Student::orderBy('name')->get();

        // ------------------------------------------------------------
        // DATA PEMBAYARAN SISWA
        // ------------------------------------------------------------

        $payments = StudentPayment::whereIn(
            'student_id',
            $students->pluck('id')
        )
            ->whereYear(
                'payment_month',
                $selectedYear
            )
            ->get()
            ->groupBy('student_id');

        $studentPayments = $students->map(
            function ($student) use (
                $payments,
                $selectedYear
            ) {
                $paymentData = $payments->get(
                    $student->id,
                    collect()
                );

                $monthlyPayments = [];

                for ($i = 1; $i <= 12; $i++) {
                    $month = Carbon::create(
                        $selectedYear,
                        $i,
                        1
                    );

                    $payment = $paymentData->first(
                        function ($item) use ($month) {
                            return Carbon::parse(
                                $item->payment_month
                            )->format('Y-m') ===
                            $month->format('Y-m');
                        }
                    );

                    $amount = $payment
                        ? (float) $payment->amount
                        : 0;

                    $monthlyPayments[] = [
                        'month' => $month->format('Y-m-d'),
                        'label' => $month->translatedFormat('M'),
                        'amount' => $amount,
                        'paid' => $amount >= self::MONTHLY_FEE,
                        'payment_id' => $payment?->id,
                    ];
                }

                return [
                    'student' => $student,
                    'months' => $monthlyPayments,
                    'total' => collect(
                        $monthlyPayments
                    )->sum('amount'),
                ];
            }
        );

        // ------------------------------------------------------------
        // TRANSAKSI
        // ------------------------------------------------------------

        $transactions = Transaction::latest()->get();

        $totalPemasukan = Transaction::where(
            'type',
            'in'
        )->sum('amount');

        $totalPengeluaran = Transaction::where(
            'type',
            'out'
        )->sum('amount');

        $totalSaldo =
            $totalPemasukan -
            $totalPengeluaran;

        return view(
            'transactions.index',
            [
                'students' => $students,
                'studentPayments' => $studentPayments,
                'transactions' => $transactions,
                'selectedYear' => $selectedYear,
                'monthlyFee' => self::MONTHLY_FEE,
                'totalPemasukan' => $totalPemasukan,
                'totalPengeluaran' => $totalPengeluaran,
                'totalSaldo' => $totalSaldo,
            ]
        );
    }

    // ================================================================
    // STORE
    // ================================================================

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
        ]);

        // ------------------------------------------------------------
        // KAS SISWA
        // ------------------------------------------------------------

        if (
            $request->type === 'in' &&
            $request->category === 'Kas Siswa'
        ) {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'payment_month' => 'required|date_format:Y-m',
            ]);

            return $this->storeStudentPayment($request);
        }

        // ------------------------------------------------------------
        // TRANSAKSI BIASA
        // ------------------------------------------------------------

        $request->validate([
            'description' => 'nullable|string',
        ]);

        Transaction::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaksi berhasil dicatat.'
            );
    }

    // ================================================================
    // STORE PEMBAYARAN SISWA
    // ================================================================

    private function storeStudentPayment(
        Request $request
    ) {
        $transactionMonth = Carbon::createFromFormat(
            'Y-m',
            $request->payment_month
        )->startOfMonth();

        $transactionYear = $transactionMonth->year;

        DB::transaction(
            function () use (
                $request,
                $transactionMonth
            ) {
                $studentId = (int) $request->student_id;

                $remaining = (float) $request->amount;

                $student = Student::findOrFail(
                    $studentId
                );

                // ----------------------------------------------------
                // BUAT TRANSAKSI HISTORY
                // ----------------------------------------------------

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

                // ----------------------------------------------------
                // ALOKASI KE BULAN PEMBAYARAN
                // ----------------------------------------------------

                $allocationMonth =
                    $transactionMonth
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

                    // ------------------------------------------------
                    // BELUM ADA DATA BULAN
                    // ------------------------------------------------

                    if (!$payment) {
                        $payment = new StudentPayment();

                        $payment->student_id =
                            $studentId;

                        $payment->transaction_id =
                            $transaction->id;

                        $payment->payment_month =
                            $allocationMonth->format('Y-m-d');

                        $payment->amount = 0;
                    } else {
                        // --------------------------------------------
                        // DATA SUDAH ADA
                        // --------------------------------------------

                        if (!$payment->transaction_id) {
                            $payment->transaction_id =
                                $transaction->id;
                        }
                    }

                    $currentAmount =
                        (float) $payment->amount;

                    // ------------------------------------------------
                    // BULAN SUDAH LUNAS
                    // ------------------------------------------------

                    if (
                        $currentAmount >=
                        self::MONTHLY_FEE
                    ) {
                        $allocationMonth->addMonth();

                        continue;
                    }

                    // ------------------------------------------------
                    // HITUNG SISA BULAN
                    // ------------------------------------------------

                    $remainingForMonth =
                        self::MONTHLY_FEE -
                        $currentAmount;

                    $allocation = min(
                        $remaining,
                        $remainingForMonth
                    );

                    $payment->amount =
                        $currentAmount +
                        $allocation;

                    $payment->paid_at = now();

                    $payment->save();

                    $remaining -= $allocation;

                    $allocationMonth->addMonth();
                }
            }
        );

        return redirect()
            ->route(
                'transactions.index',
                [
                    'year' => $transactionYear,
                ]
            )
            ->with(
                'success',
                'Pembayaran kas siswa berhasil dicatat.'
            );
    }

    // ================================================================
    // UPDATE TRANSAKSI
    // ================================================================

    public function updateTransaction(
        Request $request,
        $id
    ) {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);

        // ============================================================
        // TRANSAKSI BIASA
        // ============================================================

        if (
            $transaction->category !==
            'Kas Siswa'
        ) {
            $transaction->update([
                'category' => $request->category,
                'amount' => $request->amount,
                'description' =>
                    $request->description,
            ]);

            return redirect()
                ->route('transactions.index')
                ->with(
                    'success',
                    'Transaksi berhasil diperbarui.'
                );
        }

        // ============================================================
        // TRANSAKSI KAS SISWA
        // ============================================================

        $linkedPayments =
            StudentPayment::where(
                'transaction_id',
                $transaction->id
            )
                ->orderBy('payment_month')
                ->get();

        $oldAmount =
            (float) $transaction->amount;

        $newAmount =
            (float) $request->amount;

        DB::transaction(
            function () use (
                $transaction,
                $linkedPayments,
                $oldAmount,
                $newAmount
            ) {
                // ----------------------------------------------------
                // NOMINAL SAMA
                // ----------------------------------------------------

                if ($oldAmount === $newAmount) {

                    // Tetap sinkronkan angka di keterangan.
                    $transaction->description =
                        $this->updateAmountInDescription(
                            $transaction->description,
                            $newAmount
                        );

                    $transaction->save();

                    return;
                }

                // ----------------------------------------------------
                // NOMINAL DIKURANGI
                // ----------------------------------------------------

                if ($newAmount < $oldAmount) {
                    $difference =
                        $oldAmount -
                        $newAmount;

                    foreach (
                        $linkedPayments
                            ->sortByDesc('payment_month')
                        as $payment
                    ) {
                        if ($difference <= 0) {
                            break;
                        }

                        $currentAmount =
                            (float) $payment->amount;

                        $deduct = min(
                            $difference,
                            $currentAmount
                        );

                        $payment->amount =
                            $currentAmount -
                            $deduct;

                        if (
                            $payment->amount <= 0
                        ) {
                            $payment->delete();
                        } else {
                            $payment->paid_at =
                                now();

                            $payment->save();
                        }

                        $difference -= $deduct;
                    }
                }

                // ----------------------------------------------------
                // NOMINAL DITAMBAH
                // ----------------------------------------------------

                if ($newAmount > $oldAmount) {
                    $difference =
                        $newAmount -
                        $oldAmount;

                    $lastPaymentMonth =
                        $linkedPayments->max(
                            'payment_month'
                        );

                    if ($lastPaymentMonth) {
                        $allocationMonth =
                            Carbon::parse(
                                $lastPaymentMonth
                            )
                                ->startOfMonth()
                                ->addMonth();
                    } else {
                        $allocationMonth =
                            now()
                                ->startOfYear();
                    }

                    $studentId =
                        $linkedPayments
                            ->first()?->student_id;

                    if (!$studentId) {
                        return;
                    }

                    while ($difference > 0) {
                        $payment =
                            StudentPayment::where(
                                'student_id',
                                $studentId
                            )
                                ->whereDate(
                                    'payment_month',
                                    $allocationMonth
                                        ->format('Y-m-d')
                                )
                                ->first();

                        if (!$payment) {
                            $payment =
                                new StudentPayment();

                            $payment->student_id =
                                $studentId;

                            $payment->transaction_id =
                                $transaction->id;

                            $payment->payment_month =
                                $allocationMonth
                                    ->format('Y-m-d');

                            $payment->amount = 0;
                        } elseif (
                            !$payment->transaction_id
                        ) {
                            $payment->transaction_id =
                                $transaction->id;
                        }

                        $currentAmount =
                            (float) $payment->amount;

                        $remainingForMonth =
                            max(
                                0,
                                self::MONTHLY_FEE -
                                $currentAmount
                            );

                        if (
                            $remainingForMonth <= 0
                        ) {
                            $allocationMonth
                                ->addMonth();

                            continue;
                        }

                        $allocation = min(
                            $difference,
                            $remainingForMonth
                        );

                        $payment->amount =
                            $currentAmount +
                            $allocation;

                        $payment->paid_at = now();

                        $payment->save();

                        $difference -=
                            $allocation;

                        $allocationMonth
                            ->addMonth();
                    }
                }

                // ----------------------------------------------------
                // UPDATE HISTORY TRANSAKSI
                // ----------------------------------------------------

                $transaction->amount =
                    $newAmount;

                // ----------------------------------------------------
                // UPDATE NOMINAL DI KETERANGAN
                // ----------------------------------------------------

                $transaction->description =
                    $this->updateAmountInDescription(
                        $transaction->description,
                        $newAmount
                    );

                $transaction->save();
            }
        );

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
        $formattedAmount =
            'Rp ' .
            number_format(
                $amount,
                0,
                ',',
                '.'
            );

        // ------------------------------------------------------------
        // Kalau description kosong
        // ------------------------------------------------------------

        if (!$description) {
            return $formattedAmount;
        }

        // ------------------------------------------------------------
        // Ganti nominal Rp ... yang berada di bagian akhir
        // ------------------------------------------------------------

        $updatedDescription = preg_replace(
            '/Rp\s*[0-9\.\,]+$/i',
            $formattedAmount,
            $description
        );

        // ------------------------------------------------------------
        // Kalau tidak menemukan nominal di akhir,
        // tambahkan nominal baru
        // ------------------------------------------------------------

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
        $transaction =
            Transaction::findOrFail($id);

        DB::transaction(
            function () use ($transaction) {

                // ----------------------------------------------------
                // KAS SISWA
                // ----------------------------------------------------

                if (
                    $transaction->category ===
                    'Kas Siswa'
                ) {
                    StudentPayment::where(
                        'transaction_id',
                        $transaction->id
                    )->delete();
                }

                // ----------------------------------------------------
                // HAPUS HISTORY TRANSAKSI
                // ----------------------------------------------------

                $transaction->delete();
            }
        );

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

    public function update(
        Request $request,
        $id
    ) {
        $request->validate([
            'amount' =>
                'required|numeric|min:0|max:' .
                self::MONTHLY_FEE,
        ]);

        $payment =
            StudentPayment::findOrFail($id);

        $year =
            Carbon::parse(
                $payment->payment_month
            )->year;

        $amount =
            (float) $request->amount;

        if ($amount <= 0) {
            $payment->delete();

            return redirect()
                ->route(
                    'transactions.index',
                    [
                        'year' => $year,
                    ]
                )
                ->with(
                    'success',
                    'Pembayaran bulan tersebut berhasil dikosongkan.'
                );
        }

        $payment->amount = $amount;

        $payment->paid_at = now();

        $payment->save();

        return redirect()
            ->route(
                'transactions.index',
                [
                    'year' => $year,
                ]
            )
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
        $payment =
            StudentPayment::findOrFail($id);

        $year =
            Carbon::parse(
                $payment->payment_month
            )->year;

        $payment->delete();

        return redirect()
            ->route(
                'transactions.index',
                [
                    'year' => $year,
                ]
            )
            ->with(
                'success',
                'Catatan pembayaran berhasil dihapus.'
            );
    }
}