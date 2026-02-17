<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'slug'  => $this->slug, // Jika kamu pakai slug untuk URL
            // Menampilkan jumlah buku dalam kategori ini (Opsional tapi keren)
            'books_count' => $this->books->count(),
        ];
    }
}
