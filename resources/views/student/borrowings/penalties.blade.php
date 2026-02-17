@extends('layouts.student')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Informasi Denda</h1>
        </div>

        <div class="alert alert-info mt-3">
            <small>* Denda dihitung <span><b><u>Rp 2.000</u></b></span> per hari keterlambatan. Pembayaran denda dilakukan
                langsung di loket perpustakaan.</small>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-danger">
                <h6 class="m-0 font-weight-bold text-white">Daftar Denda Peminjaman</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Buku</th>
                                <th>Jatuh Tempo</th>
                                <th>Tgl Kembali</th>
                                <th>Keterlambatan</th>
                                <th>Total Denda</th>
                                <th>Status Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penalties as $p)
                                @php
                                    // 1. Ambil tanggal jatuh tempo (due_date)
                                    $due = \Carbon\Carbon::parse($p->due_date)->startOfDay();

                                    // 2. Tentukan tanggal pembanding (Jika sudah kembali pakai return_date, jika belum pakai hari ini)
                                    $return = $p->return_date
                                        ? \Carbon\Carbon::parse($p->return_date)->startOfDay()
                                        : \Carbon\Carbon::now()->startOfDay();

                                    // 3. Hitung selisih hari keterlambatan
                                    $late = 0;
                                    if ($return->gt($due)) {
                                        $late = $due->diffInDays($return);
                                    }

                                    // 4. Hitung Nominal Denda (Gunakan denda dari DB jika ada, jika tidak hitung otomatis)
                                    $finePerDay = 2000;
                                    $totalFine = $p->penalty > 0 ? $p->penalty : $late * $finePerDay;
                                @endphp
                                <tr>
                                    <td class="font-weight-bold text-dark">{{ $p->book->title }}</td>
                                    <td>{{ $due->format('d M Y') }}</td>
                                    <td>
                                        @if ($p->return_date)
                                            {{ \Carbon\Carbon::parse($p->return_date)->format('d M Y') }}
                                        @else
                                            <span class="badge badge-light text-warning"><i>Belum Kembali</i></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($late > 0)
                                            <span class="badge badge-outline-danger text-danger border-danger">
                                                <i class="fas fa-clock"></i> {{ $late }} Hari
                                            </span>
                                        @else
                                            <span class="text-success small"><i class="fas fa-check-circle"></i> Tepat
                                                Waktu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $totalFine > 0 ? 'danger' : 'success' }} p-2 shadow-sm">
                                            Rp {{ number_format($totalFine, 0, ',', '.') }}
                                        </span>
                                        @if ($totalFine > 0 && !$p->return_date)
                                            <br><small class="text-muted font-italic" style="font-size: 10px;">*Denda
                                                berjalan</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary text-uppercase">{{ $p->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">
                                        <i class="fas fa-info-circle"></i> Tidak ada riwayat denda ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
