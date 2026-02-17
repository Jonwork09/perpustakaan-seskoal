<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Siswa - PERPUSESKOAL</title>

    <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .navbar-student {
            background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
        }

        .nav-link-student {
            color: rgba(255, 255, 255, .8) !important;
            font-weight: 600;
            transition: 0.3s;
            border-radius: 8px;
        }

        .nav-link-student:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .1);
        }

        .nav-link-student.active {
            color: #fff !important;
            background: rgba(255, 255, 255, .2);
            shadow: inset 0 0 5px rgba(0, 0, 0, .1);
        }

        #content-wrapper {
            background-color: #f8f9fc;
            min-height: 100vh;
        }

        .btn-link.nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ff4d4d !important;
            /* Warna merah saat hover */
            transform: scale(1.1);
        }
    </style>
</head>

<body id="page-top">

    <div id="content-wrapper" class="d-flex flex-column">

        <nav class="navbar navbar-expand-lg navbar-dark navbar-student shadow-lg mb-4 sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('student.dashboard') }}">
                    <span class="font-weight-bold tracking-tighter">PERPUSESKOAL</span>
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item mx-1">
                            <a class="nav-link nav-link-student {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
                                href="{{ route('student.dashboard') }}">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link nav-link-student {{ request()->routeIs('student.books.*') ? 'active' : '' }}"
                                href="{{ route('student.books.index') }}">
                                <i class="fas fa-search mr-1"></i> Katalog Buku
                            </a>
                        </li>
                        <li class="nav-item mx-1 text-center">
                            <a class="nav-link nav-link-student {{ request()->routeIs('student.borrowings.index') ? 'active' : '' }}"
                                href="{{ route('student.borrowings.index') }}">
                                <i class="fas fa-history mr-1"></i> Pinjaman
                            </a>
                        </li>
                        <li class="nav-item mx-1">
                            <a class="nav-link nav-link-student {{ request()->routeIs('student.borrowings.penalties') ? 'active' : '' }}"
                                href="{{ route('student.borrowings.penalties') }}">
                                <i class="fas fa-wallet mr-1"></i> Denda
                                @if (isset($warningCount) && $warningCount > 0)
                                    <span class="badge badge-danger ml-1">{{ $warningCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item d-flex align-items-center mr-2">
                            <span class="mr-2 d-none d-lg-inline text-white small font-weight-bold">
                                {{ Auth::user()->name }}
                            </span>
                            {{-- <img class="img-profile rounded-circle border border-white shadow-sm" width="32"
                                height="32" src="{{ asset('admin_assets/img/undraw_profile.svg') }}"> --}}
                        </li>

                        <div class="d-none d-sm-block"
                            style="width: 1px; background: rgba(255,255,255,0.2); height: 20px; margin: 0 10px;"></div>

                        <li class="nav-item">
                            <button type="button"
                                class="btn btn-link nav-link p-2 shadow-none border-0 d-flex align-items-center justify-content-center"
                                onclick="confirmLogout()" title="Keluar"
                                style="background: rgba(255,255,255,0.1); border-radius: 10px; transition: all 0.3s;">

                                {{-- Icon Logout SVG --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                    class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                    <path fill-rule="evenodd"
                                        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                </svg>
                            </button>

                            {{-- Form asli tetap dibutuhkan --}}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="content">
            <div class="container py-2">
                @yield('content')
            </div>
        </div>

        <footer class="sticky-footer bg-white mt-auto border-top">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>&copy; 2026 PERPUSESKOAL - Sistem Perpustakaan Digital</span>
                </div>
            </div>
        </footer>
    </div>


    <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Gunakan fungsi global agar bisa dipanggil oleh onclick="confirmLogout()"
        window.confirmLogout = function() {
            Swal.fire({
                title: 'Yakin mau keluar?',
                text: "Sesi Anda akan berakhir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#e74a3b',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Pastikan ID form-nya sesuai yaitu 'logout-form'
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
