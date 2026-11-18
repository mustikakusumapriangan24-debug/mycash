<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Student;
use App\Models\StudentPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private const MONTHLY_FEE = 10000;

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
            ->withQueryString();

        $totalTransaksi = $transactions->total();

        return view('wali-kelas.pantau-kas', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'transactions',
            'totalTransaksi',
            'search',
            'type',
            'startDate',
            'endDate'
        ));
    }

    public function paymentStatus(Request $request)
    {
        $selectedYear = (int) $request->input('year', now()->year);

        if ($selectedYear < 2020 || $selectedYear > 2100) {
            $selectedYear = now()->year;
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

        $payments = StudentPayment::whereIn('student_id', $students->pluck('id'))
            ->whereYear('payment_month', $selectedYear)
            ->get()
            ->groupBy('student_id');

        $studentPayments = $students->getCollection()->map(
            function ($student) use ($payments, $selectedYear) {
                $paymentData = $payments->get($student->id, collect());
                $months = [];

                for ($i = 1; $i <= 12; $i++) {
                    $month = Carbon::create($selectedYear, $i, 1);

                    $payment = $paymentData->first(function ($item) use ($month) {
                        return Carbon::parse($item->payment_month)->format('Y-m')
                            === $month->format('Y-m');
                    });

                    $amount = $payment ? (float) $payment->amount : 0;

                    $months[] = [
                        'month' => $month->format('Y-m-d'),
                        'label' => $month->translatedFormat('M'),
                        'amount' => $amount,
                        'paid' => $amount >= self::MONTHLY_FEE,
                    ];
                }

                return [
                    'student' => $student,
                    'months' => $months,
                    'total' => collect($months)->sum('amount'),
                ];
            }
        );

        return view('status-pembayaran', [
            'students' => $students,
            'studentPayments' => $studentPayments,
            'selectedYear' => $selectedYear,
            'monthlyFee' => self::MONTHLY_FEE,
            'search' => $search,
        ]);
    }
}
