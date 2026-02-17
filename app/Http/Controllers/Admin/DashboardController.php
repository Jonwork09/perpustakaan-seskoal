<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data dari database
        $totalUsers = User::where('role', 'siswa')->count(); // Hitung user yang role-nya siswa
        $totalBooks = Book::count();
        $borrowedBooks = Borrowing::where('status', 'borrowed')->count(); // Sesuaikan field statusmu
        $totalPenalties = Borrowing::sum('penalty'); // Menghitung total denda

        // Kirim data ke view dashboard
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBooks',
            'borrowedBooks',
            'totalPenalties'
        ));
    }

    // Untuk report
    public function report(Request $request)
    {
        $query = Borrowing::with(['user', 'book']);

        // Filter Harian, Mingguan, Bulanan
        if ($request->filter == 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($request->filter == 'weekly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($request->filter == 'monthly') {
            $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        }

        $reports = $query->get();

        return view('admin.reports.index', compact('reports'));
    }
}
