<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->latest()->get();
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function approve($id)
    {
        $borrowing = Borrowing::with('book')->findOrFail($id);

        // UX Safeguard: Cek stok terakhir sebelum approve
        if ($borrowing->book->stock <= 0) {
            return redirect()->back()->with('error', 'Gagal! Stok buku sudah habis saat akan disetujui.');
        }

        $borrowing->status = 'borrowed';
        $borrowing->save();

        // Kurangi stok
        $borrowing->book->decrement('stock');

        return redirect()->back()->with('success', 'Peminjaman #' . $borrowing->reference_no . ' berhasil disetujui!');
    }

    public function reject($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Peminjaman telah ditolak.');
    }

    // Peringatan jika sudah melewati waktu peminjaman
    public function giveWarning($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update(['has_warning' => true]);

        // --- untuk lanjutan fitur, jika telat kirim email ---
        // Mail::to($borrowing->user->email)->send(new LateWarningMail($borrowing));
        // -------------------------------------

        return redirect()->back()->with('success', 'Peringatan denda telah dikirim (Dashboard & Antrean Email)!');
    }

    // Mengatur pengembalian dan denda
    public function returnBook(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $book = Book::findOrFail($borrowing->book_id);

        $now = Carbon::now();
        $dueDate = Carbon::parse($borrowing->due_date);

        // Hitung denda: jika telat, per hari 2000
        $penalty = 0;
        if ($now->gt($dueDate)) {
            $lateDays = (int) ceil($dueDate->diffInHours($now) / 24);
            $penalty = $lateDays * 2000;
        }

        // Update data peminjaman
        $borrowing->update([
            'status' => 'returned',
            'return_date' => $now->format('Y-m-d H:i:s'), // Format DB friendly
            'penalty' => $penalty,
            'has_warning' => false
        ]);

        // Kembalikan stok buku
        $book->increment('stock');

        return redirect()->back()->with('success', 'Buku "' . $book->title . '" berhasil dikembalikan. Denda Rp ' . number_format($penalty, 0, ',', '.') . ' telah dibayar offline.');
    }
}
