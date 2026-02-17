<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Borrowing;

class LateWarningMail extends Mailable
{
    use Queueable;

    public $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

    public function build()
    {
        return $this->subject('Peringatan: Keterlambatan Pengembalian Buku')
                    ->view('emails.late_warning');
    }
}
