<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function create($id)
    {
        $book = Book::findOrFail($id);
        $today = Carbon::now()->format('Y-m-d');

        return view('student.borrowings.create', compact('book', 'today'));
    }

    public function store(Request $request, $id)
    {
        // Cek apakah data sampai ke sini
        // dd($request->all());

        $request->validate([
            'due_date' => 'required|date|after:today',
        ]);

        try {
            $book = Book::findOrFail($id);
            $userId = Auth::id();

            // ... (Logika validasi alreadyBorrowed dan stok tetap sama) ...

            // GENERATE REFERENCE NUMBER
            $todayCode = Carbon::now()->format('dmy');
            $lastTransaction = Borrowing::where('reference_no', 'LIKE', $todayCode . '%')
                                ->orderBy('id', 'desc') // Ubah orderBy ke ID agar lebih pasti
                                ->first();

            $nextNumber = $lastTransaction
                ? str_pad((int)substr($lastTransaction->reference_no, -4) + 1, 4, '0', STR_PAD_LEFT)
                : '0001';

            $referenceNo = $todayCode . $nextNumber;

            // EKSEKUSI SIMPAN
            $borrowing = Borrowing::create([
                'reference_no' => $referenceNo,
                'user_id'      => $userId,
                'book_id'      => $id,
                'borrow_date'  => Carbon::now()->format('Y-m-d'),
                'due_date'     => $request->due_date,
                'status'       => 'pending',
            ]);

            return redirect()->route('student.borrowings.index')
                            ->with('success', "Permintaan pinjam #$referenceNo berhasil dikirim!");

        } catch (\Exception $e) {
            // Jika gagal, tampilkan pesan error aslinya
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function myBorrowings()
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('student.borrowings.index', compact('borrowings'));
    }

    public function penalties()
    {
        $penalties = Borrowing::where('user_id', Auth::id())
            ->where(function($query) {
                $query->where('penalty', '>', 0)
                      ->orWhere('has_warning', true);
            })
            ->with('book')
            ->latest()
            ->get();

        return view('student.borrowings.penalties', compact('penalties'));
    }
}
