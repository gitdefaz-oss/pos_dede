@extends('layouts.app')

@section('title', 'Produk')

@section('content')

    @include('layouts.navbar')

    <h1 class="my-3">Halaman Produk</h1>

    {{-- Tombol Create dengan Otorisasi --}}
    @can('create', App\Models\Produk::class)
        <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
    @endcan

    {{-- Form Pencarian --}}
    <form action="{{ route('produk.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="Search nama produk">
            <button class="btn btn-outline-secondary" type="submit">
                Search
            </button>
            @if (request('search'))
                <a href="{{ route('produk.index') }}" class="btn btn-outline-danger">Reset</a>
            @endif
        </div>
    </form>

    {{-- Tabel Produk --}}
    <table class="table align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User</th>
                <th scope="col">Foto</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <th scope="row">{{ $products->firstItem() + $loop->index }}</th>
                    <td>{{ $product->user?->name ?? 'N/A' }}</td>
                    <td>
                        @if ($product->foto)
                            <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" width="60"
                                class="img-thumbnail">
                        @else
                            <span class="badge bg-secondary">Tidak ada foto</span>
                        @endif
                    </td>
                    <td>{{ $product->nama }}</td>
                    <td>Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                    <td>{{ $product->stok }}</td>
                    <td class="d-flex gap-1">
                        @can('update', $product)
                            <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan

                        @can('delete', $product)
                            <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                    Hapus
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <h5 class="text-muted">Data produk tidak tersedia</h5>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginasi --}}
    <div class="d-flex justify-content-end">
        {{ $products->appends(request()->query())->links() }}
    </div>

@endsection