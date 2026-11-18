<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Student;
use App\Models\StudentPayment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionExport;

class ReportController extends Controller
{
    private function getReportData(Request $request): array
    {
        // Filter tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Filter jenis transaksi
        $type = $request->input('type', 'all');

        if (!in_array($type, ['all', 'in', 'out'])) {
            $type = 'all';
        }

        // Filter kategori
        $category = $request->input('category', 'all');

        // Query transaksi
        $transactionQuery = Transaction::query();

        if ($startDate) {
            $transactionQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $transactionQuery->whereDate('created_at', '<=', $endDate);
        }

        if ($type !== 'all') {
            $transactionQuery->where('type', $type);
        }

        if ($category !== 'all') {
            $transactionQuery->where('category', $category);
        }

        // Ambil kategori yang tersedia
        $categories = Transaction::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Data transaksi hasil filter
        $transactions = (clone $transactionQuery)
            ->latest('created_at')
            ->get();

        // Ringkasan pemasukan dan pengeluaran
        $summaryQuery = Transaction::query();

        if ($startDate) {
            $summaryQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $summaryQuery->whereDate('created_at', '<=', $endDate);
        }

        $totalPemasukan = (clone $summaryQuery)
            ->where('type', 'in')
            ->sum('amount');

        $totalPengeluaran = (clone $summaryQuery)
            ->where('type', 'out')
            ->sum('amount');

        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $totalTransaksi = $transactions->count();

        // Data siswa
        $students = Student::orderBy('name', 'asc')
            ->get()
            ->keyBy('id');

        // Detail pembayaran siswa
        $transactionIds = $transactions->pluck('id');

        $paymentDetails = StudentPayment::whereIn(
            'transaction_id',
            $transactionIds
        )
            ->orderBy('payment_month', 'asc')
            ->get()
            ->groupBy('transaction_id');

        // Total kas siswa berdasarkan periode
        $paymentQuery = StudentPayment::query();

        if ($startDate) {
            $paymentQuery->whereDate('payment_month', '>=', $startDate);
        }

        if ($endDate) {
            $paymentQuery->whereDate('payment_month', '<=', $endDate);
        }

        $totalKasSiswa = $paymentQuery->sum('amount');

        return compact(
            'transactions',
            'students',
            'paymentDetails',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'totalTransaksi',
            'totalKasSiswa',
            'startDate',
            'endDate',
            'type',
            'category',
            'categories'
        );
    }

    public function index(Request $request)
    {
        return view(
            'laporan.index',
            $this->getReportData($request)
        );
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);

        $pdf = Pdf::loadView('laporan.pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-mycash.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getReportData($request);

        return Excel::download(
            new TransactionExport($data['transactions']),
            'laporan-mycash.xlsx'
        );
    }
}
