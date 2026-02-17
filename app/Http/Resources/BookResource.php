<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title' => $this->title,
            'author' => $this->author,
            'stock' => $this->stock,
            'published_year' => $this->published_year,
            // Konversi path gambar ke URL Lengkap agar muncul di Mobile/Postman
            'image_url' => $this->image ? asset('storage/' . $this->image) : asset('images/default-book.png'),
            'category' => $this->category->name ?? 'N/A',
            'description' => $this->description,
        ];
    }
}
