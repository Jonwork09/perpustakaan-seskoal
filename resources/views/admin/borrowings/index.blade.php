@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Data Peminjaman</h1>
        </div>

        <div class="card mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">Daftar Transaksi Buku</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID Pinjam</th>
                                <th>Siswa</th>
                                <th>Buku</th>
                                <th>Durasi Pinjam</th>
                                <th>Status & Denda</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borrowings as $b)
                                @php
                                    $start = \Carbon\Carbon::parse($b->borrow_date);
                                    $end = \Carbon\Carbon::parse($b->due_date);
                                    $now = \Carbon\Carbon::now();

                                    // Hitung durasi awal
                                    $durasi = $start->diffInDays($end);

                                    // Logika Terlambat
                                    $isOverdue = $now->gt($end) && $b->status == 'borrowed';
                                    $hariTerlambat = $isOverdue ? (int) ceil($end->diffInHours($now) / 24) : 0;
                                    $estimasiDenda = $hariTerlambat * 2000;
                                @endphp
                                <tr class="{{ $isOverdue ? 'table-warning' : '' }}">
                                    <td class="font-weight-bold text-primary">
                                        {{ $b->reference_no ?? '#' . str_pad($b->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="font-weight-bold text-dark">{{ $b->user->name }}</td>
                                    <td>{{ $b->book->title }}</td>
                                    <td>
                                        <span class="badge badge-light p-2 border">
                                            <i class="fas fa-calendar-alt text-primary"></i> {{ $durasi }} Hari
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $start->format('d M') }} s/d
                                            {{ $end->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        @if ($b->status == 'pending')
                                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                                        @elseif($b->status == 'borrowed')
                                            @if ($isOverdue)
                                                <span class="badge badge-danger">Terlambat {{ $hariTerlambat }} Hari</span>
                                                <br><small class="text-danger font-weight-bold">Denda: Rp
                                                    {{ number_format($estimasiDenda, 0, ',', '.') }}</small>
                                            @else
                                                <span class="badge badge-info">Sedang Dipinjam</span>
                                            @endif
                                        @elseif($b->status == 'returned')
                                            <span class="badge badge-success">Sudah Kembali</span>
                                            @if ($b->penalty > 0)
                                                <br><small class="text-success">Denda Lunas: Rp
                                                    {{ number_format($b->penalty, 0, ',', '.') }}</small>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary text-uppercase">{{ $b->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($b->status == 'pending')
                                            <form action="{{ route('admin.borrowings.approve', $b->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button class="btn btn-success btn-sm btn-icon-split">
                                                    <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                                    <span class="text">Approve</span>
                                                </button>
                                            </form>
                                        @endif

                                        @if ($b->status == 'returned')
                                            <span class="text-muted small"><i class="fas fa-check-double text-success"></i>
                                                Transaksi Selesai</span>
                                        @endif

                                        @if ($b->status == 'borrowed')
                                            <form id="return-form-{{ $b->id }}"
                                                action="{{ route('admin.borrowings.return', $b->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="button" class="btn btn-primary btn-sm btn-icon-split"
                                                    onclick="confirmReturn('{{ $b->id }}', '{{ $b->book->title }}', '{{ $estimasiDenda }}')">
                                                    <span class="icon text-white-50"><i class="fas fa-undo"></i></span>
                                                    <span class="text">Kembalikan</span>
                                                </button>
                                            </form>

                                            @if ($isOverdue && !$b->has_warning)
                                                <form action="{{ route('admin.borrowings.warning', $b->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-warning btn-sm shadow-sm"
                                                        title="Kirim peringatan ke dashboard siswa">
                                                        <i class="fas fa-exclamation-triangle"></i> Peringatkan
                                                    </button>
                                                </form>
                                            @elseif($b->has_warning && $b->status == 'borrowed')
                                                <span class="badge badge-light border text-muted"><i
                                                        class="fas fa-bullhorn"></i> Sudah Diingatkan</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmReturn(id, title, denda) {
            let dendaText = denda > 0 ? "\nTotal Denda: Rp " + new Intl.NumberFormat('id-ID').format(denda) :
                "Tidak ada denda.";

            Swal.fire({
                title: 'Konfirmasi Pengembalian',
                text: "Buku: " + title + "\n" + dendaText +
                    "\n\nPastikan denda sudah dibayar (jika ada) dan buku sudah diterima.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('return-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
