<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no', // Pastikan ini di baris atas
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'has_warning',
        'penalty'
    ];

    // Tambahkan ini agar tanggal otomatis jadi objek Carbon
    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'datetime',
    ];

    // Relasi ke User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function getCalculatedPenaltyAttribute()
    {
        $finePerDay = 2000;
        $dueDate = \Carbon\Carbon::parse($this->due_date);
        $today = \Carbon\Carbon::now();

        // Jika status sudah returned, ambil dari kolom penalty di DB
        if ($this->status === 'returned') {
            return $this->penalty;
        }

        // Jika masih dipinjam dan telat
        if ($today->gt($dueDate)) {
            return $today->diffInDays($dueDate) * $finePerDay;
        }

        return 0;
    }
}
