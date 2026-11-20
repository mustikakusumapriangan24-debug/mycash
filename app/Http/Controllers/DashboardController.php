<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\CashPeriodService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly CashPeriodService $cashPeriods
    ) {
    }

    public function index()
    {
        $totalPemasukan = Transaction::where('type', 'in')->sum('amount');
        $totalPengeluaran = Transaction::where('type', 'out')->sum('amount');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $transactions = Transaction::latest()->get();

        $expenseByCategory = Transaction::where('type', 'out')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return view('dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'transactions',
            'expenseByCategory'
        ));
    }

    public function waliKelasKas(Request $request)
    {
        $totalPemasukan = Transaction::where('type', 'in')->sum('amount');
        $totalPengeluaran = Transaction::where('type', 'out')->sum('amount');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        $cashSetting = $this->cashPeriods->settingForUser($request->user());
        $paymentYear = (int) $request->input(
            'payment_year',
            $this->cashPeriods->currentSchoolYear($cashSetting)
        );

        if ($paymentYear < 2020 || $paymentYear > 2100) {
            $paymentYear = $this->cashPeriods->currentSchoolYear($cashSetting);
        }

        $activeReportTable = $request->input('report_table') === 'payments'
            ? 'payments'
            : 'transactions';

        $search = $request->input('search');
        $type = $request->input('type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (in_array($type, ['in', 'out'], true)) {
            $query->where('type', $type);
        }

        if (!empty($startDate) && Carbon::hasFormat($startDate, 'Y-m-d')) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if (!empty($endDate) && Carbon::hasFormat($endDate, 'Y-m-d')) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $transactions = $query->latest()
            ->paginate(10)
            ->appends(array_merge(
                $request->query(),
                ['report_table' => 'transactions']
            ));

        $totalTransaksi = $transactions->total();
        $paymentStudents = Student::orderBy('name')
            ->paginate(10, ['*'], 'payment_page')
            ->appends(array_merge(
                $request->query(),
                ['report_table' => 'payments']
            ));
        $paymentPeriods = $this->cashPeriods->periods(
            $cashSetting,
            $paymentYear
        );
        $studentPayments = $this->cashPeriods->buildChecklist(
            $paymentStudents->getCollection(),
            $cashSetting,
            $paymentYear
        );
        $periodFee = $this->cashPeriods->fee($cashSetting);
        $periodType = $this->cashPeriods->periodType($cashSetting);

        return view('wali-kelas.pantau-kas', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'transactions',
            'totalTransaksi',
            'search',
            'type',
            'startDate',
            'endDate',
            'studentPayments',
            'paymentStudents',
            'paymentPeriods',
            'periodFee',
            'periodType',
            'paymentYear',
            'activeReportTable'
        ));
    }

    public function paymentStatus(Request $request)
    {
        $cashSetting = $this->cashPeriods->settingForUser($request->user());
        $selectedYear = (int) $request->input(
            'year',
            $this->cashPeriods->currentSchoolYear($cashSetting)
        );

        if ($selectedYear < 2020 || $selectedYear > 2100) {
            $selectedYear = $this->cashPeriods->currentSchoolYear($cashSetting);
        }

        $search = trim($request->input('search', ''));

        $studentQuery = Student::query();

        if ($search !== '') {
            $studentQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $students = $studentQuery->orderBy('name')->paginate(10)->withQueryString();

        $paymentPeriods = $this->cashPeriods->periods(
            $cashSetting,
            $selectedYear
        );
        $studentPayments = $this->cashPeriods->buildChecklist(
            $students->getCollection(),
            $cashSetting,
            $selectedYear
        );

        return view('status-pembayaran', [
            'students' => $students,
            'studentPayments' => $studentPayments,
            'selectedYear' => $selectedYear,
            'periodFee' => $this->cashPeriods->fee($cashSetting),
            'periodType' => $this->cashPeriods->periodType($cashSetting),
            'paymentPeriods' => $paymentPeriods,
            'search' => $search,
        ]);
    }
}
