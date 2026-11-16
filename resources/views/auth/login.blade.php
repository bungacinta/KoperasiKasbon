
@extends('layouts.app')

@section('title', 'Masuk - KASBON')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">

        <div class="text-center mb-4">
            <h1 class="brand h2 mb-0 judul-login">KASBON</h1>
            <p class="text-muted small">
                Koperasi Andalan Simpanan dan Bantuan Online
            </p>
        </div>

        <div class="card p-4">

            <form method="POST"
                  action="{{ route('login.process') }}"
                  class="cek-form"
                  novalidate>

                @csrf

                <label class="form-label">Email</label>
                <input
                    type="text"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required
                    autofocus
                >

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <label class="form-label mt-3">Kata sandi</label>
                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                >

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <div class="form-check my-3">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="ingat"
                        id="ingat"
                    >

                    <label class="form-check-label" for="ingat">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn btn-kas w-100">
                    Masuk
                </button>

            </form>

        </div>

    </div>
</div>
@endsection
