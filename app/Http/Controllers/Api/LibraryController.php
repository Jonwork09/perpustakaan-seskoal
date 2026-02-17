<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\BorrowingResource;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    //
    public function getBooks() {
        $books = Book::with('category')->get();
        return BookResource::collection($books);
    }

    public function getBookDetail($id) {
        $book = Book::with('category')->find($id);
        if (!$book) return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        return new BookResource($book);
    }

    public function getCategories() {
        return response()->json(['status' => 'success', 'data' => Category::all()]);
    }

    public function getMyBorrowings(Request $request)
    {
        $user = $request->user();
        $borrowings = $user->borrowings()->with('book')->get(); // Eager loading buku

        return response()->json([
            'status' => 'success',
            'data' => BorrowingResource::collection($borrowings)
        ]);
    }
}
