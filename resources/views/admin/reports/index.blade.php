@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Laporan Peminjaman</h1>
            <div>
                <a href="{{ route('admin.reports.index', ['filter' => 'today']) }}" class="btn btn-sm btn-primary">Harian</a>
                <a href="{{ route('admin.reports.index', ['filter' => 'weekly']) }}" class="btn btn-sm btn-info">Mingguan</a>
                <a href="{{ route('admin.reports.index', ['filter' => 'monthly']) }}"
                    class="btn btn-sm btn-success">Bulanan</a>
                <button onclick="window.print()" class="btn btn-sm btn-dark shadow-sm">
                    <i class="fas fa-print fa-sm text-white-50"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">Data Transaksi Peminjaman</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Status</th>
                                {{-- <th>Denda</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $key => $r)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $r->created_at->format('d M Y') }}</td>
                                    <td>{{ $r->user->name }}</td>
                                    <td>{{ $r->book->title }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $r->status == 'returned' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($r->status) }}
                                        </span>
                                    </td>
                                    {{-- <td>Rp {{ number_format($r->penalty_amount, 0, ',', '.') }}</td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data untuk periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* CSS Khusus Cetak: Menghilangkan sidebar/navbar saat diprint */
        @media print {

            .no-print,
            .sidebar,
            .navbar,
            .sticky-footer {
                display: none !important;
            }

            #content-wrapper {
                margin: 0 !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
                shadow: none !important;
            }
        }
    </style>
@endsection
