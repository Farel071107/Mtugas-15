@extends('layouts.app')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .register-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .register-box {
        background: rgba(255, 255, 255, 0.95);
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 380px;
        text-align: center;
        position: relative;
    }

    .register-box img {
        width: 80px;
        margin-bottom: 15px;
    }

    .register-box h3 {
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .register-box p {
        margin-bottom: 20px;
        font-size: 14px;
        color: #000000ff;
    }

    .register-box label {
        font-weight: 600;
        float: left;
        margin-bottom: 5px;
    }

    .register-box input[type="text"],
    .register-box input[type="email"],
    .register-box input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
    }

    .btn-login {
        width: 100%;
        padding: 10px;
        background: #28a745 !important;   /* hijau */
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        overflow: hidden;
        position: relative;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-login:hover {
        background: #218838 !important;
        transform: scale(1.05);
    }

    /* Ripple effect */
    .btn-login .ripple-effect {
        position: absolute;
        border-radius: 50%;
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        background-color: rgba(255, 255, 255, 0.6);
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    .register-box .extra {
        margin-top: 15px;
        font-size: 14px;
    }

    .register-box .extra a {
        color: #28a745;
        text-decoration: none;
    }

    .register-box .extra a:hover {
        text-decoration: underline;
    }
</style>

<div class="register-container">
    <div class="register-box">
        <!-- Logo -->
        <img src="{{ asset('images/logo-tugas.png') }}" alt="Logo">

        
        <p>Silakan isi form untuk membuat akun baru</p>

        <!-- Form Register -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <small style="color: red;">{{ $message }}</small>
            @enderror

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <small style="color: red;">{{ $message }}</small>
            @enderror

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <small style="color: red;">{{ $message }}</small>
            @enderror

            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
            @error('password_confirmation')
                <small style="color: red;">{{ $message }}</small>
            @enderror

            <button type="submit" class="btn-login ripple">Register</button>
        </form>

        <div class="extra">
            <a href="{{ route('login') }}">Sudah punya akun? Login</a>
        </div>
    </div>
</div>

<!-- Ripple JS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".ripple");

        buttons.forEach(btn => {
            btn.addEventListener("click", function (e) {
                const circle = document.createElement("span");
                circle.classList.add("ripple-effect");

                const rect = btn.getBoundingClientRect();
                circle.style.width = circle.style.height = Math.max(rect.width, rect.height) + "px";
                circle.style.left = e.clientX - rect.left - (circle.offsetWidth / 2) + "px";
                circle.style.top = e.clientY - rect.top - (circle.offsetHeight / 2) + "px";

                btn.appendChild(circle);
                setTimeout(() => circle.remove(), 600);
            });
        });
    });
</script>
@endsection
