<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'announcements');
        if (!in_array($tab, ['announcements', 'payments'], true)) {
            $tab = 'announcements';
        }

        $search = trim((string) $request->query('search', ''));
        $priority = $request->query('priority', 'all');
        if (!in_array($priority, ['all', 'normal', 'important', 'urgent'], true)) {
            $priority = 'all';
        }

        $announcementQuery = Announcement::query()
            ->with('creator')
            ->withCount('recipients');

        if ($search !== '') {
            $announcementQuery->where(function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        if ($priority !== 'all') {
            $announcementQuery->where('prioritas', $priority);
        }

        $announcements = $announcementQuery
            ->latest()
            ->paginate(8, ['*'], 'announcement_page')
            ->withQueryString();

        $paymentHistoryQuery = Transaction::query()
            ->with([
                'studentPayments.student',
                'weeklyPayments.student',
                'bendahara.user',
            ])
            ->where('type', 'in')
            ->whereIn('category', ['Kas Siswa', 'Iuran Kas Siswa']);
        $paymentHistoryCount = (clone $paymentHistoryQuery)->count();

        if ($search !== '') {
            $paymentHistoryQuery->where(function ($query) use ($search) {
                $query->where('description', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        $paymentHistory = $paymentHistoryQuery
            ->latest()
            ->paginate(10, ['*'], 'payment_page')
            ->withQueryString();
        $announcementCount = Announcement::count();
        $notificationStudents = Student::query()
            ->whereHas('user', function ($query) {
                $query->where('role', 'siswa')
                    ->where('status', 'aktif');
            })
            ->orderBy('name')
            ->get(['id', 'user_id', 'name', 'nis']);

        return view('announcements.index', compact(
            'tab',
            'search',
            'priority',
            'announcements',
            'announcementCount',
            'paymentHistory',
            'paymentHistoryCount',
            'notificationStudents'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template' => 'required|in:free,monthly_fee,cash_bill,cash_confirmation',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'target' => 'required|in:all,specific',
            'target_student_id' => 'nullable|required_if:target,specific|integer|exists:students,id',
            'priority' => 'required|in:normal,important,urgent',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'announcement')
                ->withInput();
        }

        $data = $validator->validated();
        if ($data['target'] === 'all') {
            $recipientUserIds = Student::query()
                ->whereHas('user', function ($query) {
                    $query->where('role', 'siswa')
                        ->where('status', 'aktif');
                })
                ->pluck('user_id')
                ->unique()
                ->values();
        } else {
            $student = Student::query()
                ->whereKey($data['target_student_id'])
                ->whereHas('user', function ($query) {
                    $query->where('role', 'siswa')
                        ->where('status', 'aktif');
                })
                ->first();

            if (!$student) {
                return back()
                    ->withErrors([
                        'target_student_id' => 'Siswa yang dipilih belum memiliki akun aktif.',
                    ], 'announcement')
                    ->withInput();
            }

            $recipientUserIds = collect([$student->user_id]);
        }

        if ($recipientUserIds->isEmpty()) {
            return back()
                ->withErrors([
                    'target' => 'Tidak ada siswa dengan akun aktif untuk menerima pengumuman.',
                ], 'announcement')
                ->withInput();
        }

        DB::transaction(function () use ($request, $data, $recipientUserIds) {
            $announcement = Announcement::create([
                'user_id' => $request->user()->id,
                'judul' => $data['title'],
                'isi' => $data['message'],
                'template' => $data['template'],
                'prioritas' => $data['priority'],
            ]);

            $announcement->recipients()->createMany(
                $recipientUserIds->map(function ($userId) {
                    return ['user_id' => $userId];
                })->all()
            );
        });

        return redirect()->route('pengumuman.index')->with(
            'announcement_success',
            'Pengumuman berhasil dikirim ke siswa.'
        );
    }
}
