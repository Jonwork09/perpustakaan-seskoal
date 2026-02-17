@extends('layouts.student')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Konfirmasi Peminjaman</h1>

        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow-sm mb-4 border-0" style="border-radius: 15px;">
                    <div class="card-header py-3 bg-white border-0">
                        <h6 class="m-0 font-weight-bold text-primary">Form Peminjaman Buku</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('student.borrowings.store', $book->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    {{-- Tampilkan Gambar Buku di Samping Form --}}
                                    <img src="{{ $book->image ? asset('storage/' . $book->image) : asset('images/default.png') }}"
                                        class="img-fluid rounded shadow-sm"
                                        style="width: 100%; height: 200px; object-fit: cover;">
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark">Judul Buku</label>
                                        <input type="text" class="form-control bg-light" value="{{ $book->title }}"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark">Tanggal Pinjam (Hari Ini)</label>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ date('d M Y', strtotime($today)) }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark">Rencana Tanggal Kembali</label>
                                        <input type="date" name="due_date" id="due_date"
                                            class="form-control @error('due_date') is-invalid @enderror"
                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                        <small class="text-info font-italic" id="duration_hint"></small>
                                        @error('due_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('student.books.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Kirim Permintaan
                                    Pinjam</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('due_date').addEventListener('change', function() {
            const start = new Date("{{ $today }}");
            const end = new Date(this.value);
            const submitBtn = document.querySelector('button[type="submit"]');

            // Reset jam ke 0 untuk akurasi perhitungan hari
            start.setHours(0, 0, 0, 0);
            end.setHours(0, 0, 0, 0);

            const diffTime = end - start;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            const hint = document.getElementById('duration_hint');

            if (diffDays > 0 && diffDays <= 14) {
                hint.innerText = "✓ Kamu akan meminjam selama " + diffDays + " hari.";
                hint.classList.replace('text-danger', 'text-info');
                submitBtn.disabled = false;
            } else if (diffDays > 14) {
                hint.innerText = "⚠ Maksimal peminjaman adalah 14 hari!";
                hint.classList.replace('text-info', 'text-danger');
                submitBtn.disabled = true;
            } else {
                hint.innerText = "⚠ Tanggal tidak valid!";
                hint.classList.replace('text-info', 'text-danger');
                submitBtn.disabled = true;
            }
        });
    </script>
@endsection
