@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Buku</h1>
        <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Judul Buku</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $book->title) }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="category_id" class="form-control" required>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penulis</label>
                                    <input type="text" name="author" class="form-control"
                                        value="{{ old('author', $book->author) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <label>Sampul Saat Ini</label>
                            <div class="mb-2">
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" class="img-thumbnail"
                                        style="height: 150px;">
                                @else
                                    <div class="py-4 bg-light border rounded">Tidak ada foto</div>
                                @endif
                            </div>
                            <label class="btn btn-outline-primary btn-sm btn-block">
                                Ganti Foto
                                <input type="file" name="image" hidden>
                            </label>
                            <small class="text-muted">Format: JPG, PNG, Max 2MB</small>
                        </div>
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
