<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['category_id', 'title', 'author', 'published_year', 'stock', 'description', 'image'];

        public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-book.jpg'); // Pastikan ada gambar default
    }

    // Relasi: satu buku punya satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
