@extends('layouts.app')

@section('title', 'POS')

@section('content')

    {{-- Alert Pesan Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Alert Pesan Custom Error (session) --}}
    @if (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Alert Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <h4 class="mb-3">
        {{ $mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }}
    </h4>

    <div class="row">

        {{-- ==================== DAFTAR PRODUK ==================== --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="max-height:70vh; overflow:auto">
                    
                    {{-- Form Pencarian --}}
                    <div class="mb-3">
                        <form method="GET" action="{{ route('penjualan.create') }}">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                   placeholder="Cari produk..." onkeyup="this.form.submit()">
                        </form>
                    </div>

                    {{-- List Produk --}}
                    @foreach ($products as $product)
<form method="POST" action="{{ ter"route('item-penjualan.store') }}" class="row mb-2 align-items-cen>
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="col-7">
                                <div class="d-flex align-items-center gap-2 border p-2 rounded">
                                    {{-- Gambar produk --}}
                                    <img src="{{ asset('storage/' . $product->foto) }}" 
                                         alt="Gambar" 
                                         class="rounded-circle"
                                         style="width:45px; height:45px; object-fit:cover;">

                                    {{-- Nama & harga --}}
                                    <div>
                                        <div class="fw-semibold">{{ $product->nama }}</div>
                                        <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <input type="number" name="quantity" value="1" min="1" 
                                       class="form-control" {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                            </div>

                            <div class="col-2">
                                <button type="submit" class="btn btn-primary w-100 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                    +
                                </button>
                            </div>
                        </form>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- ==================== KERANJANG ==================== --}}
        <div class="col-md-6">
            <div class="card">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sale->itemPenjualan as $item)
                            <tr>
                                <td>{{ $item->produk->nama }}</td>
                                <td>
                                    {{-- Update Quantity --}}
                                    <form method="POST" action="{{ route('item-penjualan.update', $item->id) }}">
                                        @csrf 
                                        @method('PUT')
                                        <input type="number" name="quantity"
                                               value="{{ $item->kuantitas }}"
                                               class="form-control form-control-sm"
                                               onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>Rp {{ number_format($item->subtotal) }}</td>
                                <td>
                                    {{-- Hapus Item --}}
                                    <form method="POST" action="{{ route('item-penjualan.destroy', $item->id) }}">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada barang di keranjang</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Total Pembayaran:</span>
                        <strong>Rp {{ number_format($sale->total_pembayaran) }}</strong>
                    </div>

                    {{-- Form Checkout --}}
                    <form method="POST" action="{{ route('penjualan.update', $sale->id) }}" class="mt-2">
                        @csrf
                        @method('PUT')
                        <select name="payment_method" class="form-select mb-2" required>
                            <option value="">Pilih Pembayaran</option>
                            <option value="CASH">Cash</option>
                            <option value="QRIS">QRIS</option>
                        </select>

                        <button type="submit" class="btn btn-success w-100" {{ $sale->itemPenjualan->isEmpty() ? 'disabled' : '' }}>
                            Checkout
                        </button>
                    </form>

                    {{-- Form Batal Transaksi --}}
                    <form method="POST" action="{{ route('penjualan.destroy', $sale->id) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            Batal Transaksi
                        </button>
                    </form>
                </div>
            </div>    
        </div>

    </div>

@endsection