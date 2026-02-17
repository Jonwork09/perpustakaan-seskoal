<h1>Halo, {{ $borrowing->user->name }}!</h1>
<p>Ini adalah pengingat otomatis dari Perpustakaan.</p>
<p>Buku <strong>{{ $borrowing->book->title }}</strong> yang kamu pinjam sudah melewati batas waktu.</p>
<p>Batas Kembali: {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') }}</p>
<br>
<p>Harap segera kembalikan buku tersebut untuk menghindari akumulasi denda.</p>
