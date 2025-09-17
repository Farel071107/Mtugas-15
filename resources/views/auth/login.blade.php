@extends('layouts.app')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-box {
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 350px;
        text-align: center;
    }

    .login-box img {
        width: 80px;
        margin-bottom: 15px;
    }

    .login-box h3 {
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .login-box p {
        margin-bottom: 20px;
        font-size: 14px;
        color: #000000ff;
    }

    .login-box label {
        font-weight: 600;
        float: left;
        margin-bottom: 5px;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
    }

    .login-box button {
        width: 100%;
        padding: 10px;
        background: #007bff;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-box button:hover {
        background: #0056b3;
    }

    .login-box .extra {
        margin-top: 15px;
        font-size: 14px;
    }

    .login-box .extra a {
        color: #007bff;
        text-decoration: none;
    }

    .login-box .extra a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container">
    <div class="login-box">
        <!-- Logo -->
        <img src="{{ asset('images/logo-tugas.png') }}" alt="Logo">

       
        <p>Silakan login untuk melanjutkan</p>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>

            <button type="submit" class="btn-login ripple">Login</button>
        </form>

        <div class="extra">
            <a href="{{ route('password.request') }}">Lupa password?</a> | 
            <a href="{{ route('register') }}">Register</a>
        </div>
    </div>
</div>

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
