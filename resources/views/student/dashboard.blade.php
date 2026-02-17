@extends('layouts.student')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard Siswa</h1>
            <div class="text-gray-500 font-weight-600">
                <i class="fas fa-calendar-alt mr-1"></i> {{ date('d F Y') }}
            </div>
        </div>

        {{-- Header Welcome Card --}}
        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="card shadow border-0 overflow-hidden"
                    style="border-radius: 20px; background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);">
                    <div class="card-body py-5 text-white position-relative">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <h3 class="font-weight-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                                <p class="mb-0 text-white-50 opacity-8" style="font-size: 1.1rem;">Senang melihatmu kembali.
                                    Sudahkah kamu membaca sesuatu yang menginspirasi hari ini?</p>
                            </div>
                            <div class="col-auto d-none d-lg-block">
                                <i class="fas fa-user-graduate fa-5x text-white-50 opacity-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik Card --}}
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 border-0"
                    style="border-radius: 15px; border-left: 5px solid #4e73df !important;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Peminjaman
                                </div>
                                <a href="{{ route('student.borrowings.index') }}">
                                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $data['total_pinjam'] }}</div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book-reader fa-2x text-gray-200"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 border-0"
                    style="border-radius: 15px; border-left: 5px solid #36b9cc !important;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Dipinjam</div>
                                <a href="{{ route('student.borrowings.index') }}">
                                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $data['sedang_dipinjam'] }}</div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-200"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 border-0"
                    style="border-radius: 15px; border-left: 5px solid #e74a3b !important;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Belum Kembali</div>
                                <a href="{{ route('student.borrowings.penalties') }}">
                                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $data['belum_kembali'] }}
                                    </div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-gray-200"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            {{-- Panduan --}}
            <div class="col-lg-7">
                <div class="card shadow mb-4 border-0" style="border-radius: 15px;">
                    <div class="card-header py-3 bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h6 class="m-0 font-weight-bold text-primary">Panduan Peminjaman Buku</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline-simple">
                            <div class="d-flex mb-3">
                                <div class="bg-light rounded-circle px-3 py-2 mr-3 font-weight-bold">1</div>
                                <p class="mb-0 pt-1 text-dark">Buka menu <b>Katalog Buku</b> di sidebar.</p>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="bg-light rounded-circle px-3 py-2 mr-3 font-weight-bold">2</div>
                                <p class="mb-0 pt-1 text-dark">Pilih buku yang diinginkan, lalu klik <b>Pesan Buku</b>.</p>
                            </div>
                            <div class="d-flex mb-4">
                                <div class="bg-light rounded-circle px-3 py-2 mr-3 font-weight-bold">3</div>
                                <p class="mb-0 pt-1 text-dark">Gunakan <b>ID Pickup</b> saat mengambil buku fisik di
                                    petugas.</p>
                            </div>
                        </div>
                        <a href="{{ route('student.books.index') }}"
                            class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm" style="border-radius: 10px;">
                            Cari Buku Sekarang <i class="fas fa-search ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card Peringatan / Ingat Batas Waktu --}}
            <div class="col-lg-5">
                @if (isset($warnings) && $warnings->count() > 0)
                    {{-- Tampilan saat ada denda/jatuh tempo --}}
                    <div class="card shadow mb-4 border-0 bg-danger text-white animated--fade-in"
                        style="border-radius: 15px;">
                        <div class="card-body py-4">
                            <div class="text-center mb-3">
                                <div class="bg-white d-inline-block rounded-circle shadow-sm mb-3 d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 50px; height: 50px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" class="bi bi-exclamation-triangle-fill text-danger"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </svg>
                                </div>
                                <h5 class="font-weight-bold">Peringatan Penting!</h5>
                                <p class="small opacity-8">Kamu memiliki buku yang harus segera dikembalikan:</p>
                            </div>
                            <div class="bg-white rounded p-2 mb-0 overflow-auto" style="max-height: 150px;">
                                @foreach ($warnings as $w)
                                    <div class="d-flex align-items-center border-bottom pb-2 mb-2 last-child-border-0">
                                        <div class="mr-2">
                                            <i class="fas fa-book text-danger"></i>
                                        </div>
                                        <div class="text-dark small" style="line-height: 1.2;">
                                            <div class="font-weight-bold text-truncate" style="max-width: 200px;">
                                                {{ $w->book->title }}</div>
                                            <div class="text-muted" style="font-size: 10px;">Jatuh tempo:
                                                {{ \Carbon\Carbon::parse($w->due_date)->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Tampilan Normal saat tidak ada denda --}}
                    <div class="card shadow mb-4 border-0 bg-light" style="border-radius: 15px;">
                        <div class="card-body text-center py-5">
                            {{-- <img src="https://undraw.co/api/content/icons/undraw_reading_list_re_avf7.svg"
                                style="width: 150px;" class="mb-4" alt="Icon"> --}}
                            <h6 class="font-weight-bold text-dark">Ingat Batas Waktu!</h6>
                            <p class="text-muted small px-3">Saat ini kamu tidak memiliki tanggungan buku yang telat. Tetap
                                jaga kebiasaan membaca dan kembalikan buku tepat waktu ya!</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
