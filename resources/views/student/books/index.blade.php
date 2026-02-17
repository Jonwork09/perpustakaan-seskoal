@extends('layouts.student')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Katalog Buku</h1>
            <p class="text-muted">Pilih buku yang ingin kamu pinjam hari ini.</p>
        </div>

        {{-- Section Filter & Pencarian --}}
        <div class="card shadow mb-4 border-0" style="border-radius: 15px;">
            <div class="card-body">
                <form method="GET" action="{{ route('student.books.index') }}" class="row align-items-center">
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control border-0 bg-light"
                                placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <select name="category" class="form-control border-0 bg-light">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 text-md-right">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ route('student.books.index') }}" class="btn btn-light ml-2 border">
                            <i class="fas fa-undo mr-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid Katalog Buku --}}
        <div class="row">
            @forelse($books as $book)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 transition-hover"
                        style="border-radius: 15px; overflow: hidden;">

                        {{-- Bagian Cover Buku --}}
                        <div class="position-relative">
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top"
                                    alt="{{ $book->title }}" style="height: 380px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-gradient-primary"
                                    style="height: 250px;">
                                    <i class="fas fa-book fa-4x text-white-50"></i>
                                </div>
                            @endif

                            {{-- Badge Stok --}}
                            <div class="position-absolute" style="top: 10px; right: 10px;">
                                <span
                                    class="badge {{ $book->stock > 0 ? 'badge-success' : 'badge-danger' }} px-3 py-2 shadow-sm">
                                    {{ $book->stock > 0 ? 'Stok: ' . $book->stock : 'Habis' }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ $book->category->name }}
                            </div>
                            <h6 class="font-weight-bold text-gray-900 mb-1">{{ Str::limit($book->title, 45) }}</h6>
                            <p class="text-muted small mb-3">Oleh: {{ $book->author }}</p>

                            <div class="mt-auto">
                                @if ($book->stock > 0)
                                    <a href="{{ route('student.borrowings.create', $book->id) }}"
                                        class="btn btn-primary btn-block font-weight-bold shadow-sm"
                                        style="border-radius: 10px;">
                                        <i class="fas fa-plus-circle mr-1"></i> Pinjam Buku
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-block disabled font-weight-bold"
                                        style="border-radius: 10px;" disabled>
                                        <i class="fas fa-ban mr-1"></i> Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-4x text-gray-200 mb-3"></i>
                    <h5 class="text-gray-500">Buku yang kamu cari tidak ditemukan.</h5>
                    <a href="{{ route('student.books.index') }}" class="btn btn-link">Lihat semua koleksi</a>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .transition-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .transition-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        }
    </style>
@endsection
