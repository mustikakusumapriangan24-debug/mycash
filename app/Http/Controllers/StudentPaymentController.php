<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentPayment;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Kelas;
use App\Models\StudentWeeklyPayment;
use App\Services\CashPeriodService;
use App\Services\TransactionAuditLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class StudentPaymentController extends Controller
{
    public function __construct(
        private readonly TransactionAuditLogger $auditLogger,
        private readonly CashPeriodService $cashPeriods
    ) {
    }

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
        $cashSetting = $this->cashPeriods->settingForUser($request->user());
        $selectedYear = (int) $request->input(
            'year',
            $this->cashPeriods->currentSchoolYear($cashSetting)
        );

        if ($selectedYear < 2020 || $selectedYear > 2100) {
            $selectedYear = $this->cashPeriods->currentSchoolYear($cashSetting);
        }

        $search = trim((string) ($request->input('search') ?? ''));
        $paymentSearch = trim((string) ($request->input('payment_search') ?? ''));
        $type = (string) ($request->input('type') ?? '');
        $category = (string) ($request->input('category') ?? '');
        $fromDate = (string) ($request->input('from_date') ?? '');
        $toDate = (string) ($request->input('to_date') ?? '');

        // DATA SISWA
        $students = Student::orderBy('name')->get();

        $paginationQuery = $request->query();
        unset(
            $paginationQuery['page'],
            $paginationQuery['payment_page'],
            $paginationQuery['report_table']
        );

        $paymentStudentQuery = Student::query();

        if ($paymentSearch !== '') {
            $paymentStudentQuery->where(function ($query) use ($paymentSearch) {
                $query->where('name', 'like', "%{$paymentSearch}%")
                    ->orWhere('nis', 'like', "%{$paymentSearch}%");
            });
        }

        $paymentStudents = $paymentStudentQuery
            ->orderBy('name')
            ->paginate(10, ['*'], 'payment_page')
            ->appends(array_merge($paginationQuery, [
                'report_table' => 'payments',
            ]));

        $paymentPeriods = $this->cashPeriods->periods(
            $cashSetting,
            $selectedYear
        );
        $currentMonthPeriod = collect($paymentPeriods)->first(
            fn (array $period) => $period['month_date']->isSameMonth(now())
        );
        $defaultPaymentMonth = $currentMonthPeriod['key']
            ?? $paymentPeriods[0]['key'];
        $defaultPaymentWeek = $currentMonthPeriod
            && $currentMonthPeriod['week_number'] !== null
            ? $currentMonthPeriod['week_number']
                + min(3, (int) floor((now()->day - 1) / 7))
            : ($paymentPeriods[0]['week_number'] ?? 1);
        $studentPayments = $this->cashPeriods->buildChecklist(
            $paymentStudents->getCollection(),
            $cashSetting,
            $selectedYear
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
            ->appends(array_merge($paginationQuery, [
                'report_table' => 'transactions',
            ]));

        $activeReportTable = $request->input('report_table') === 'payments'
            ? 'payments'
            : 'transactions';

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
            'paymentStudents' => $paymentStudents,
            'transactions' => $transactions,
            'activeReportTable' => $activeReportTable,
            'selectedYear' => $selectedYear,
            'periodFee' => $this->cashPeriods->fee($cashSetting),
            'periodType' => $this->cashPeriods->periodType($cashSetting),
            'paymentPeriods' => $paymentPeriods,
            'cashSetting' => $cashSetting,
            'defaultPaymentMonth' => $defaultPaymentMonth,
            'defaultPaymentWeek' => $defaultPaymentWeek,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalSaldo' => $totalSaldo,
            'search' => $search,
            'paymentSearch' => $paymentSearch,
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
            'receipt' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Kategori hanya dipilih untuk pengeluaran.
        if ($request->type === 'out') {
            $request->validate([
                'category' => 'required|in:' .
                    implode(',', self::EXPENSE_CATEGORIES),
            ]);

            $category = $this->normalizeCategory($request->category);
        } else {
            if ($request->filled('income_type')) {
                $request->validate([
                    'income_type' => 'required|in:student_cash,general',
                ]);

                $category = $request->income_type === 'student_cash'
                    ? 'Kas Siswa'
                    : 'Pemasukan Lainnya';
            } else {
                // Tetap menerima form lama yang mengirim kategori pemasukan.
                $request->validate([
                    'category' => 'required|in:' .
                        implode(',', self::INCOME_CATEGORIES),
                ]);

                $category = $this->normalizeCategory($request->category);
            }
        }

        // PEMBAYARAN KAS SISWA
        if (
            $request->type === 'in' &&
            $category === 'Kas Siswa'
        ) {
            $cashSetting = $this->cashPeriods->settingForUser($request->user());
            $periodType = $this->cashPeriods->periodType($cashSetting);
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'payment_year' => 'required|integer|between:2020,2100',
                'payment_month' => $periodType === 'Bulanan'
                    ? 'required|date_format:Y-m'
                    : 'nullable',
                'payment_week' => $periodType === 'Mingguan'
                    ? 'required|integer|between:1,48'
                    : 'nullable',
            ]);

            $paymentYear = (int) $validated['payment_year'];
            $periods = $this->cashPeriods->periods(
                $cashSetting,
                $paymentYear
            );
            $periodIndex = $this->cashPeriods->findPeriodIndex(
                $periods,
                $periodType,
                $validated['payment_month'] ?? null,
                isset($validated['payment_week'])
                    ? (int) $validated['payment_week']
                    : null
            );

            if ($periodIndex === null) {
                return back()
                    ->withErrors([
                        'payment_month' => 'Periode pembayaran berada di luar rentang aturan kas yang aktif.',
                    ])
                    ->withInput();
            }

            return $this->storeStudentPayment(
                $request,
                $cashSetting,
                $periods,
                $periodIndex,
                $periodType,
                $paymentYear
            );
        }

        $bendahara = $request->user()->bendahara;
        if (!$bendahara) {
            return redirect()->back()->with(
                'error',
                'Data Bendahara tidak ditemukan. Transaksi tidak dapat disimpan.'
            );
        }

        // TRANSAKSI BIASA
        $receiptPath = null;
        if ($request->type === 'out' && $request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')
                ->store('transaction-receipts', 'public');

            if ($receiptPath === false) {
                throw new RuntimeException('Gagal menyimpan foto bukti transaksi.');
            }
        }

        $actor = $request->user();
        DB::transaction(function () use (
            $request,
            $category,
            $receiptPath,
            $bendahara,
            $actor
        ) {
            $transaction = Transaction::create([
                'bendahara_id' => $bendahara->id,
                'type' => $request->type,
                'amount' => $request->amount,
                'category' => $category,
                'description' => $request->description,
                'receipt_path' => $receiptPath,
            ]);

            $this->auditLogger->record(
                $actor,
                $transaction,
                'tambah',
                [],
                $this->auditLogger->snapshot($transaction),
                'Transaksi kas ditambahkan.'
            );
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    // ================================================================
    // STORE PEMBAYARAN SISWA
    // ================================================================

    private function storeStudentPayment(
        Request $request,
        ?Kelas $cashSetting,
        array $periods,
        int $periodIndex,
        string $periodType,
        int $paymentYear
    )
    {
        if ($this->cashPeriods->fee($cashSetting) === null) {
            return redirect()
                ->back()
                ->withErrors([
                    'nominal_standar' => 'Tetapkan tarif kas kelas terlebih dahulu sebelum mencatat pembayaran siswa.',
                ])
                ->withInput();
        }

        $bendahara = $request->user()->bendahara;
        if (!$bendahara) {
            return redirect()->back()->with(
                'error',
                'Data Bendahara tidak ditemukan. Pembayaran tidak dapat disimpan.'
            );
        }

        $bendaharaId = $bendahara->id;

        $student = Student::with('user')->findOrFail(
            (int) $request->student_id
        );
        $actor = $request->user();

        $transaction = null;

        DB::transaction(
            function () use (
                $request,
                $student,
                $bendaharaId,
                $actor,
                &$transaction,
                $periods,
                $periodIndex,
                $periodType,
                $cashSetting
            ) {
                $studentId = (int) $request->student_id;

                $transaction = Transaction::create([
                    'bendahara_id' => $bendaharaId,
                    'type' => 'in',
                    'amount' => $request->amount,
                    'category' => 'Kas Siswa',
                    'description' => 'Pembayaran kas siswa',
                ]);

                $allocationSummary = $this->cashPeriods->allocate(
                    $transaction,
                    $studentId,
                    $periods,
                    $periodIndex,
                    $periodType,
                    $this->cashPeriods->fee($cashSetting),
                    (float) $request->amount
                );

                $transaction->description = $this->paymentDurationDescription(
                    $periodType,
                    $allocationSummary
                );
                $transaction->save();

                $this->auditLogger->record(
                    $actor,
                    $transaction,
                    'tambah',
                    [],
                    $this->auditLogger->snapshot($transaction),
                    'Transaksi kas siswa ditambahkan.'
                );
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
                    ' telah berhasil dicatat oleh bendahara.',
            ]);
        }

        return redirect()
            ->route('transactions.index', [
                'year' => $paymentYear,
            ])
            ->with(
                'success',
                'Pembayaran kas siswa berhasil dicatat.'
            );
    }

    private function paymentDurationDescription(
        string $periodType,
        array $allocationSummary
    ): string {
        $unit = $periodType === 'Mingguan' ? 'minggu' : 'bulan';
        $periodCount = $allocationSummary['period_count'];
        $fullyPaidCount = $allocationSummary['fully_paid_count'];

        if ($periodCount === 1 && $fullyPaidCount === 1) {
            return "Pembayaran kas untuk 1 {$unit}.";
        }

        if ($fullyPaidCount === $periodCount) {
            return "Pembayaran kas untuk {$fullyPaidCount} {$unit}.";
        }

        if ($fullyPaidCount > 0) {
            return "Pembayaran kas untuk {$fullyPaidCount} {$unit} penuh dan sebagian periode berikutnya.";
        }

        return "Pembayaran kas untuk sebagian {$unit}.";
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
        $actor = $request->user();
        $beforeData = $this->auditLogger->snapshot($transaction);

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

            DB::transaction(function () use (
                $transaction,
                $category,
                $request,
                $actor,
                $beforeData
            ) {
                $transaction->update([
                    'category' => $category,
                    'amount' => $request->amount,
                    'description' => $request->description,
                ]);

                $afterData = $this->auditLogger->snapshot($transaction);
                if ($beforeData !== $afterData) {
                    $this->auditLogger->record(
                        $actor,
                        $transaction,
                        'edit',
                        $beforeData,
                        $afterData,
                        'Data transaksi kas diperbarui.'
                    );
                }
            });

            return redirect()
                ->route('transactions.index')
                ->with(
                    'success',
                    'Transaksi berhasil diperbarui.'
                );
        }

        // TRANSAKSI KAS SISWA
        $linkedMonthlyPayments = StudentPayment::where(
            'transaction_id',
            $transaction->id
        )->orderBy('payment_month')->get();
        $linkedWeeklyPayments = StudentWeeklyPayment::where(
            'transaction_id',
            $transaction->id
        )->orderBy('school_year')->orderBy('week_number')->get();

        $oldAmount = (float) $transaction->amount;
        $newAmount = (float) $request->amount;

        $firstLinkedPayment = $linkedWeeklyPayments->first()
            ?? $linkedMonthlyPayments->first();
        $studentId = $firstLinkedPayment?->student_id;

        $student = $studentId
            ? Student::with('user')->find($studentId)
            : null;
        $cashSetting = $this->cashPeriods->settingForUser($actor);
        $periodType = $linkedWeeklyPayments->isNotEmpty()
            ? 'Mingguan'
            : 'Bulanan';
        $fee = $this->cashPeriods->fee($cashSetting);

        if ($fee === null) {
            return redirect()
                ->back()
                ->withErrors([
                    'nominal_standar' => 'Tetapkan tarif kas kelas terlebih dahulu sebelum mengubah pembayaran siswa.',
                ])
                ->withInput();
        }

        DB::transaction(
            function () use (
                $transaction,
                $linkedMonthlyPayments,
                $linkedWeeklyPayments,
                $oldAmount,
                $newAmount,
                $actor,
                $beforeData,
                $cashSetting,
                $periodType,
                $fee,
                $studentId
            ) {
                if ($oldAmount !== $newAmount && $studentId) {
                    $difference = abs($newAmount - $oldAmount);
                    $linkedPayments = $periodType === 'Mingguan'
                        ? $linkedWeeklyPayments
                        : $linkedMonthlyPayments;

                    if ($newAmount < $oldAmount) {
                        $orderedPayments = $periodType === 'Mingguan'
                            ? $linkedPayments->sortByDesc('week_number')
                            : $linkedPayments->sortByDesc('payment_month');

                        foreach ($orderedPayments as $payment) {
                            if ($difference <= 0) {
                                break;
                            }

                            $deduct = min(
                                $difference,
                                (float) $payment->amount
                            );
                            $payment->amount = (float) $payment->amount - $deduct;

                            if ((float) $payment->amount <= 0) {
                                $payment->delete();
                            } else {
                                $payment->paid_at = now();
                                $payment->save();
                            }

                            $difference -= $deduct;
                        }

                        if ($difference > 0) {
                            throw new RuntimeException(
                                'Alokasi pembayaran yang terhubung tidak mencukupi untuk mengurangi nominal transaksi.'
                            );
                        }
                    } elseif ($linkedPayments->isNotEmpty()) {
                        if ($periodType === 'Mingguan') {
                            $schoolYear = (int) $linkedPayments->last()->school_year;
                            $lastWeek = (int) $linkedPayments->last()->week_number;
                            $lastMonth = null;
                        } else {
                            $lastMonth = Carbon::parse(
                                $linkedPayments->last()->payment_month
                            );
                            $schoolYear = $lastMonth->month >=
                                $this->cashPeriods->startMonth($cashSetting)
                                ? $lastMonth->year
                                : $lastMonth->year - 1;
                            $lastWeek = null;
                        }

                        $periods = $this->cashPeriods->periods(
                            $cashSetting,
                            $schoolYear
                        );
                        $startIndex = $this->cashPeriods->findPeriodIndex(
                            $periods,
                            $periodType,
                            $lastMonth?->format('Y-m'),
                            $lastWeek
                        );

                        if ($startIndex === null) {
                            throw new RuntimeException(
                                'Periode pembayaran transaksi tidak ditemukan dalam aturan kas aktif.'
                            );
                        }

                        $this->cashPeriods->allocate(
                            $transaction,
                            $studentId,
                            $periods,
                            $startIndex,
                            $periodType,
                            $fee,
                            $difference
                        );
                    }
                }

                // UPDATE HISTORY TRANSAKSI
                $transaction->amount = $newAmount;
                $allocationCount = $periodType === 'Mingguan'
                    ? StudentWeeklyPayment::where('transaction_id', $transaction->id)->count()
                    : StudentPayment::where('transaction_id', $transaction->id)->count();
                if ($allocationCount > 0) {
                    $linkedAfterUpdate = $periodType === 'Mingguan'
                        ? StudentWeeklyPayment::where('transaction_id', $transaction->id)->get()
                        : StudentPayment::where('transaction_id', $transaction->id)->get();
                    $transaction->description = $this->paymentDurationDescription(
                        $periodType,
                        [
                            'period_count' => $linkedAfterUpdate->count(),
                            'fully_paid_count' => $linkedAfterUpdate
                                ->filter(fn ($payment) => (float) $payment->amount >= $fee)
                                ->count(),
                        ]
                    );
                }

                $transaction->save();

                $afterData = $this->auditLogger->snapshot($transaction);
                if ($beforeData !== $afterData) {
                    $this->auditLogger->record(
                        $actor,
                        $transaction,
                        'edit',
                        $beforeData,
                        $afterData,
                        'Data pembayaran kas siswa diperbarui.'
                    );
                }
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
    // DELETE TRANSAKSI
    // ================================================================

    public function destroyTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $actor = request()->user();
        $beforeData = $this->auditLogger->snapshot($transaction);

        $linkedPayment = StudentPayment::where(
            'transaction_id',
            $transaction->id
        )
            ->with('student.user')
            ->first();

        $weeklyPayment = StudentWeeklyPayment::where(
            'transaction_id',
            $transaction->id
        )
            ->with('student.user')
            ->first();

        $student = $linkedPayment?->student ?? $weeklyPayment?->student;

        DB::transaction(
            function () use ($transaction, $actor, $beforeData) {
                if ($transaction->category === 'Kas Siswa') {
                    StudentPayment::where(
                        'transaction_id',
                        $transaction->id
                    )->delete();
                    StudentWeeklyPayment::where(
                        'transaction_id',
                        $transaction->id
                    )->delete();
                }

                $transaction->delete();

                $this->auditLogger->record(
                    $actor,
                    $transaction,
                    'hapus',
                    $beforeData,
                    null,
                    'Transaksi kas dihapus.'
                );
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
        $fee = $this->cashPeriods->fee(
            $this->cashPeriods->settingForUser($request->user())
        );

        if ($fee === null) {
            return redirect()
                ->back()
                ->withErrors([
                    'nominal_standar' => 'Tetapkan tarif kas kelas terlebih dahulu sebelum mengubah status pembayaran.',
                ])
                ->withInput();
        }

        $request->validate([
            'amount' =>
                'required|numeric|min:0|max:' .
                $fee,
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
