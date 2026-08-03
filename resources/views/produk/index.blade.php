@extends('layouts.app')

@section('title', 'Produk')

@section('content')

    @include('layouts.navbar')

    <h1>Halaman Produk</h1>

    <a href="{{ route('admin.produk.create') }}" method="GET" class="btn btn-primary mb-3">Create</a>

    <form action="{{ route('admin.produk.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input 
                type="text"
                name="search"
                value=""
                class="form-control"
                placeholder="Search nama produk"
            >
            <button class="btn btn-outline-secondary" type="submit">
                Search
            </button>
        </div>
    </form>

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
                    <td>{{ $product->user->name }}</td>
                    <td>{{ $product->foto }}</td>
                    <td>{{ $product->nama }}</td>
                    <td>Rp. {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                    <td>{{ $product->stok }}</td>
                    <td class="d-flex gap-1">
                        <a href="" class="btn btn-warning btn-sm">Edit</a>
                        <form action="" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h3>Data tidak tersedia</h3>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}

@endsection