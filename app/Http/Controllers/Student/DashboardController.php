<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil pinjaman yang kena denda/peringatan
        $warnings = \App\Models\Borrowing::where('user_id', $user->id)
                    ->where('has_warning', true)
                    ->where('status', 'borrowed')
                    ->with('book')
                    ->get();

        $data = [
            'total_pinjam' => \App\Models\Borrowing::where('user_id', $user->id)->count(),
            'sedang_dipinjam' => \App\Models\Borrowing::where('user_id', $user->id)->where('status', 'borrowed')->count(),
            'belum_kembali' => \App\Models\Borrowing::where('user_id', $user->id)->where('status', 'borrowed')->where('due_date', '<', now())->count(),
        ];

        return view('student.dashboard', compact('data', 'warnings'));
    }
}
