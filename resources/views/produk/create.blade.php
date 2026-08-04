@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Produk</h2>

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Input Gambar --}}
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input 
                type="file" 
                name="gambar" 
                id="gambar" 
                class="form-control @error('gambar') is-invalid @enderror"
                accept="image/*"
            >
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Nama Produk --}}
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input 
                type="text" 
                name="nama_produk" 
                id="nama_produk" 
                class="form-control @error('nama_produk') is-invalid @enderror" 
                value="{{ old('nama_produk') }}" 
                required
            >
            @error('nama_produk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Harga Beli --}}
        <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input 
                type="number" 
                name="harga_beli" 
                id="harga_beli" 
                class="form-control @error('harga_beli') is-invalid @enderror" 
                value="{{ old('harga_beli') }}" 
                required
            >
            @error('harga_beli')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Harga Jual --}}
        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input 
                type="number" 
                name="harga_jual" 
                id="harga_jual" 
                class="form-control @error('harga_jual') is-invalid @enderror" 
                value="{{ old('harga_jual') }}" 
                required
            >
            @error('harga_jual')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Stok --}}
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input 
                type="number" 
                name="stok" 
                id="stok" 
                class="form-control @error('stok') is-invalid @enderror" 
                value="{{ old('stok') }}" 
                required
            >
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection