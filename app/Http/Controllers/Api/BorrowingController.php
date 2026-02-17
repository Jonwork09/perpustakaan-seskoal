<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Http\Resources\BorrowingResource;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Jika dia admin, tampilkan semua. Jika siswa, tampilkan milik dia saja.
        if ($user->role === 'admin') {
            $borrowings = Borrowing::with(['book', 'user'])->latest()->get();
        } else {
            $borrowings = Borrowing::with(['book', 'user'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => BorrowingResource::collection($borrowings)
        ]);
    }

    public function show($id)
    {
        $borrowing = Borrowing::with(['book', 'user'])->find($id);

        if (!$borrowing) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Cek Keamanan: Siswa tidak boleh lihat data peminjaman orang lain
        if (auth()->user()->role !== 'admin' && $borrowing->user_id !== auth()->id()) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        return new BorrowingResource($borrowing);
    }

    public function store(Request $request)
    {
        // Validasi: Siswa cuma kirim ID buku yang mau dipinjam
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        // Cari bukunya
        $book = \App\Models\Book::find($request->book_id);

        // Cek stok (Logic Bisnis)
        if ($book->stock <= 0) {
            return response()->json(['message' => 'Stok buku habis!'], 422);
        }

        // Proses simpan peminjaman (berikan logic untuk unique code sperti di studetnt)
            $todayCode = Carbon::now()->format('dmy');
            $lastTransaction = Borrowing::where('reference_no', 'LIKE', $todayCode . '%')
                                ->orderBy('id', 'desc')
                                ->first();

            $nextNumber = $lastTransaction
                ? str_pad((int)substr($lastTransaction->reference_no, -4) + 1, 4, '0', STR_PAD_LEFT)
                : '0001';

            $referenceNo = $todayCode . $nextNumber;
            // ------------------------------------

            $borrowing = Borrowing::create([
                'reference_no' => $referenceNo, // Pakai kode rapi kamu
                'user_id'      => auth()->id(),
                'book_id'      => $book->id,
                'borrow_date'  => Carbon::now()->format('Y-m-d'),
                'due_date'     => Carbon::now()->addDays(7)->format('Y-m-d'),
                'status'       => 'pending',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengajukan pinjaman dengan kode: ' . $referenceNo,
                'data' => $borrowing
            ], 201);
    }
}
