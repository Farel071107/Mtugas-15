<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'To-Do App')</title>

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font: Atkinson Hyperlegible Next -->
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible+Next:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Atkinson Hyperlegible Next', sans-serif;
        }

        /* Glassmorphism Navbar */
        .custom-navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            transition: all 0.3s ease-in-out;
            border-radius: 0 0 16px 16px;
        }

        .custom-navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Hover */
        .navbar .nav-link,
        .btn {
            transition: all 0.3s ease-in-out;
        }

        .navbar .nav-link:hover {
            color: #198754 !important;
            transform: translateY(-2px);
        }

        .btn.transition:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #121212;
            color: #f1f1f1;
        }

        body.dark-mode .custom-navbar {
            background: rgba(18, 18, 18, 0.85);
        }

        body.dark-mode .custom-navbar.scrolled {
            background: rgba(18, 18, 18, 0.95);
            box-shadow: 0 4px 12px rgba(0,0,0,0.4);
        }

        body.dark-mode .nav-link {
            color: #f1f1f1 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg shadow-sm fixed-top custom-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ url('/') }}">
                <i class="bi bi-check2-circle me-1"></i> Manajemen Tugas
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item">
                            <a href="#" class="nav-link fw-semibold">{{ auth()->user()->name }}</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success px-3 py-1 ms-2 rounded-pill shadow-sm transition" type="submit">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-success px-3 py-1 me-2 rounded-pill shadow-sm transition">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-success px-3 py-1 rounded-pill shadow-sm transition">Register</a>
                        </li>
                    @endauth
                    <li class="nav-item ms-3">
                        <button id="toggleThemeBtn" class="btn btn-outline-secondary btn-sm rounded-circle shadow-sm transition" aria-label="Toggle dark mode">
                            <i class="bi bi-moon-fill" id="themeIcon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Progress Section -->
     @if(auth()->check() && !Request::is('login') && !Request::is('register'))
    <div class="container mt-5 pt-5">
        
        @php
            $total = \App\Models\Task::where('user_id', auth()->id())->count();
            $done = \App\Models\Task::where('user_id', auth()->id())->where('is_completed', true)->count();
            $progress = $total > 0 ? round(($done / $total) * 100) : 0;
        @endphp

        <div class="alert alert-light shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-graph-up-arrow text-success me-2"></i>Progress Tugas</h5>
            <div class="progress mb-2" style="height: 14px;">
                <div class="progress-bar bg-success" style="width: {{ $progress }}%">
                    {{ $progress }}%
                </div>
            </div>
            <small class="text-muted">{{ $done }} dari {{ $total }} tugas selesai</small>
        </div>
        @endif
        {{-- Tempat filter & sort berada di file view bagian content --}}
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const toggleBtn = document.getElementById('toggleThemeBtn');
        const themeIcon = document.getElementById('themeIcon');
        const body = document.body;

        // Load theme
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            themeIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
        }

        toggleBtn.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            if(body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
            } else {
                localStorage.setItem('theme', 'light');
                themeIcon.classList.replace('bi-sun-fill', 'bi-moon-fill');
            }
        });

        // Navbar scroll effect
        window.addEventListener("scroll", function () {
            const navbar = document.querySelector(".custom-navbar");
            if (window.scrollY > 30) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });

        // SweetAlert flash
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                timer: 2000,
                toast: true,
                position: 'top-end'
            });
        @endif

        // Konfirmasi hapus
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin mau hapus?',
                        text: "Data tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
