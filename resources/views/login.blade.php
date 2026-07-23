<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke tittle untuk ditampilkan -->
@section('title', 'login')

<!-- batas awal isi konten -->
@section('content')

<div class="card text-center position-absolute top-50 start-50 translate-middle"
     style="width: 18rem;">

    <h5 class="card-header">Login POS</h5>

    <div class="card-body">
        <form action="{{ route('auth') }}" method="POST">
            @csrf

            <div class="mb-3 text-start">
                <label for="exampleInputEmail1" class="form-label">
                    Email address
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       id="exampleInputEmail1">
            </div>

            <div class="mb-3 text-start">
                <label for="exampleInputPassword1" class="form-label">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       id="exampleInputPassword1">
            </div>

            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </form>
    </div>
</div>