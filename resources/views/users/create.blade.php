@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah User</h2>

    <form action="{{ route('admin.users.store') }}" method="POST" autocomplete="off">
        @csrf

        {{-- Input Nama --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name') }}" 
                required
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email') }}" 
                autocomplete="new-email"
                required
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control @error('password') is-invalid @enderror" 
                autocomplete="new-password"
                required
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Select Role --}}
        <div class="mb-3">
            <label for="role_id" class="form-label">Role</label>
            <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                <option value="" disabled selected>-- Pilih Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection