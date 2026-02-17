@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Data Buku</h1>
        <a href="{{ route('admin.books.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Buku
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">Daftar Buku</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if ($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="Cover"
                                            style="width: 50px; height: 70px; object-fit: cover; border-radius: 5px;"
                                            class="shadow-sm">
                                    @else
                                        <div class="bg-gray-200 d-flex align-items-center justify-content-center mx-auto"
                                            style="width: 50px; height: 70px; border-radius: 5px;">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $book->title }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $book->category->name }}</span>
                                </td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->published_year }}</td>
                                <td>{{ $book->stock }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm btn-icon-split"
                                        onclick="showDetail('{{ $book->title }}', '{{ $book->category->name }}', '{{ $book->author }}', '{{ $book->published_year }}', '{{ $book->stock }}', '{{ $book->description }}', '{{ $book->image ? asset('storage/' . $book->image) : asset('images/default-book.png') }}')">
                                        <span class="icon text-white-50"><i class="fas fa-eye"></i></span>
                                        <span class="text">Lihat</span>
                                    </button>
                                    <a href="{{ route('admin.books.edit', $book->id) }}"
                                        class="btn btn-warning btn-sm btn-icon-split">
                                        <span class="icon text-white-50"><i class="fas fa-pencil-alt"></i></span>
                                        <span class="text">Ubah</span>
                                    </a>

                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-icon-split"
                                            onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                            <span class="icon text-white-50"><i class="fas fa-trash"></i></span>
                                            <span class="text">Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data buku masih kosong.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- pop up untuk view --}}
    <div class="modal fade" id="bookDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white font-weight-bold" id="modalTitle">Detail Buku</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img id="modalImage" src="" class="img-fluid rounded shadow" alt="Cover Buku">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Judul</th>
                                    <td id="detailTitle"></td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td><span id="detailCategory" class="badge badge-info"></span></td>
                                </tr>
                                <tr>
                                    <th>Penulis</th>
                                    <td id="detailAuthor"></td>
                                </tr>
                                <tr>
                                    <th>Tahun Terbit</th>
                                    <td id="detailYear"></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td id="detailStock"></td>
                                </tr>
                            </table>
                            <hr>
                            <h6 class="font-weight-bold">Deskripsi:</h6>
                            <p id="detailDescription" class="text-justify"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showDetail(title, category, author, year, stock, description, image) {
            // Isi data ke dalam modal
            $('#modalTitle').text('Detail: ' + title);
            $('#detailTitle').text(': ' + title);
            $('#detailCategory').text(category);
            $('#detailAuthor').text(': ' + author);
            $('#detailYear').text(': ' + year);
            $('#detailStock').text(': ' + stock);
            $('#detailDescription').text(description || 'Tidak ada deskripsi.');
            $('#modalImage').attr('src', image);

            // Munculkan Modal
            $('#bookDetailModal').modal('show');
        }
    </script>
@endsection
