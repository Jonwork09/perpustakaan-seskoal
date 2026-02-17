<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'book' => [
                'id' => $this->book->id,
                'title' => $this->book->title,
                'image' => $this->book->image ? asset('storage/' . $this->book->image) : null,
            ],
            'user' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'status' => $this->status, // pending, borrowed, returned, rejected
            'borrow_date' => $this->borrow_date,
            'due_date' => $this->due_date,
            'return_date' => $this->return_date,
            'penalty' => (int) $this->penalty,
            'formatted_penalty' => 'Rp ' . number_format($this->penalty, 0, ',', '.'),
        ];
    }
}
