<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        // Fitur Filter: Siswa bisa cari judul atau filter per kategori
        $books = Book::with('category')
            ->when($request->category, function($query) use ($request) {
                return $query->where('category_id', $request->category);
            })
            ->when($request->search, function($query) use ($request) {
                return $query->where('title', 'like', '%'.$request->search.'%');
            })
            ->where('stock', '>', 0) // Hanya tampilkan yang stoknya ada
            ->latest()
            ->get();

        return view('student.books.index', compact('books', 'categories'));
    }
}
