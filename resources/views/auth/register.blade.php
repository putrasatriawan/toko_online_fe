@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg p-4"
         style="width: 100%; max-width: 450px;">
        <h3 class="text-center mb-4">Buat Akun Baru</h3>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST"
              action="{{ route('register.process') }}">
            @csrf

            <div class="mb-3">
                <label for="name"
                       class="form-label">Nama Lengkap</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required
                       value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="email"
                       class="form-label">Alamat Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       required
                       value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="password"
                       class="form-label">Kata Sandi</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation"
                       class="form-label">Konfirmasi Sandi</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       required>
            </div>

            <button class="btn btn-success w-100">Daftar</button>
        </form>

        <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="{{ route('login') }}">Login</a></small>
        </div>
    </div>
</div>
@endsection