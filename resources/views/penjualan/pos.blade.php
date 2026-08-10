@extends('layouts.app')

@section('title', 'POS')

@section('content')

    {{-- Alert Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error') || session('success'))
        <div class="alert alert-{{ session('error') ? 'danger' : 'success' }} mb-3">
            {{ session('error') ?? session('success') }}
        </div>
    @endif

    <h4 class="mb-3">{{ $mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }}</h4>

    <div class="row">
        {{-- ==================== DAFTAR PRODUK ==================== --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="max-height:70vh; overflow:auto">

                    {{-- Form Pencarian --}}
                    <div class="mb-3">
                        <form method="GET" action="{{ route('penjualan.create') }}">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari produk..." id="searchInput">
                        </form>
                    </div>

                    {{-- List Produk --}}
                    @forelse ($products as $product)
                        <form method="POST" action="{{ route('itempenjualan.store') }}"
                            class="row mb-2 align-items-center">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            @if (isset($sale) && $sale?->id)
                                <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                            @endif

                            <div class="col-7">
                                <div class="d-flex align-items-center gap-2 border p-2 rounded">
                                    <img src="{{ $product->foto ? asset('storage/' . $product->foto) : asset('images/no-image.png') }}"
                                        alt="{{ $product->nama }}" class="rounded-circle"
                                        style="width:45px; height:45px; object-fit:cover;">
                                    <div>
                                        <div class="fw-semibold">{{ $product->nama }}</div>
                                        <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <input type="number" name="quantity" value="1" min="1" class="form-control"
                                    {{ $sale?->status === 'COMPLETED' ? 'readonly' : '' }}>
                            </div>

                            <div class="col-2">
                                <button type="submit" class="btn btn-primary w-100"
                                    {{ $sale?->status === 'COMPLETED' ? 'disabled' : '' }}>
                                    +
                                </button>
                            </div>
                        </form>
                    @empty
                        <p class="text-muted text-center">Produk tidak ditemukan</p>
                    @endforelse

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
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sale?->itemPenjualan ?? [] as $item)
                            <tr>
                                <td>{{ $item->produk->nama }}</td>
                                <td>Rp {{ number_format($item->produk->harga_jual) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->kuantitas }}" min="1"
                                            class="form-control form-control-sm" onchange="this.form.submit()"
                                            {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                                    </form>
                                </td>
                                <td>Rp {{ number_format($item->subtotal) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada barang di keranjang</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Total Pembayaran:</span>
                        <strong>Rp {{ number_format($sale?->total_pembayaran ?? 0) }}</strong>
                    </div>

                    @if ($sale)
                        {{-- Form Checkout --}}
                        <form method="POST" action="{{ route('penjualan.checkout', $sale->id) }}">
                            @csrf
                            <select name="payment_method" class="form-select mb-2" required
                                {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                <option value="">Pilih Pembayaran</option>
                                <option value="CASH">Cash</option>
                                <option value="QRIS">QRIS</option>
                            </select>

                            <button type="submit" class="btn btn-success w-100"
                                {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                Checkout
                            </button>
                        </form>

                        {{-- Form Batalkan Transaksi --}}
                        <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-danger w-100 mt-2"
                                {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                Batalkan Transaksi
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Debounce untuk pencarian produk agar tidak submit form tiap huruf diketik
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;

            let timeout = null;
            searchInput.addEventListener('keyup', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    this.form.submit();
                }, 500); // tunggu 500ms setelah berhenti mengetik
            });
        });
    </script>
@endpush
