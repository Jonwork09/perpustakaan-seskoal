@extends('layouts.student')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Daftar Pinjaman</h1>
            <div class="text-gray-500 font-weight-600">
                <i class="fas fa-calendar-alt mr-1"></i> {{ date('d F Y') }}
            </div>
        </div>

        <div class="card shadow mb-4 border-0" style="border-radius: 15px;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                                <th>ID Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowings as $b)
                                @php
                                    $isOverdue =
                                        \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($b->due_date)) &&
                                        $b->status == 'borrowed';
                                @endphp
                                <tr class="{{ $isOverdue ? 'bg-light' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold text-dark">{{ $b->book->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($b->due_date)->format('d M Y') }}</td>
                                    <td>
                                        @if ($b->status == 'pending')
                                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                                        @elseif($b->status == 'borrowed')
                                            @if ($isOverdue)
                                                <span class="badge badge-danger pulse-red">Terlambat (Denda Menanti)</span>
                                            @else
                                                <span class="badge badge-info">Sedang Dipinjam</span>
                                            @endif
                                        @elseif($b->status == 'returned')
                                            <span class="badge badge-success">Sudah Dikembalikan</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary"
                                            style="cursor: pointer; padding: 8px 12px; border-radius: 8px;"
                                            onclick="showKode('{{ $b->reference_no ?? '#' . str_pad($b->id, 4, '0', STR_PAD_LEFT) }}')">
                                            <i class="fas fa-id-card"></i> ID:
                                            {{ $b->reference_no ?? '#' . str_pad($b->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada riwayat peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <p>* ID Peminjaman ditunjukkan ke Admin perpustakaan untuk penukaran buku</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showKode(kode) {
            // Cek dulu di console apakah fungsi terpanggil
            console.log("Memunculkan kode: " + kode);

            // Swal.fire({
            //     title: 'Kode Referensi',
            //     html: '<h2 class="text-primary font-weight-bold">' + kode + '</h2>',
            //     text: "Tunjukan kode berikut ke petugas.",
            //     confirmButtonText: 'OK',
            //     confirmButtonColor: '#4e73df'
            // });

            Swal.fire({
                text: "Tunjukan kode berikut ke petugas",
                title: '<h2 class="text-primary font-weight-bold">' + kode + '</h2>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4e73df'
            });
        }
    </script>
@endsection
