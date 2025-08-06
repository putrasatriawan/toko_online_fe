@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg p-4"
         style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Login ke Akun Adhiva's</h3>

        @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST"
              action="{{ route('login.process') }}">
            @csrf
            <div class="mb-3">
                <label for="email"
                       class="form-label">Alamat Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       required
                       autofocus>
            </div>

            <div class="mb-3">
                <label for="password"
                       class="form-label">Kata Sandi</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <button class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <small>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></small>
        </div>
    </div>
</div>
@endsection