@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

    @include('layouts.navbar')

    <h1 class="my-3">Halaman Penjualan</h1>

    {{-- Alert Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tombol Create --}}
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Create</a>

    {{-- Form Pencarian --}}
    <form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                class="form-control" 
                placeholder="Search penjualan"
            >
            <button class="btn btn-outline-secondary" type="submit">
                Search
            </button>
            @if (request('search'))
                <a href="{{ route('penjualan.index') }}" class="btn btn-outline-danger">Reset</a>
            @endif
        </div>
    </form>

    {{-- Tabel Penjualan --}}
    <table class="table align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Kasir</th>
                <th scope="col">Total Pembayaran</th>
                <th scope="col">Metode Pembayaran</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <th scope="row">{{ $sales->firstItem() + $loop->index }}</th>
                    <td>{{ $sale->created_at?->translatedFormat('d-m-Y H:i:s') }}</td>
                    <td>{{ $sale->user?->name ?? 'N/A' }}</td>
                    <td>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
                    <td>{{ $sale->metode_pembayaran }}</td>
                    <td>
                        <span class="badge {{ $sale->status == 'Complete' || $sale->status == 'CLOSED' ? 'bg-success' : 'bg-warning' }}">
                            {{ $sale->status }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-primary btn-sm">Detail</a>
                            <span>||</span>
                            <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <span>||</span>
                            <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <h5 class="text-muted">Data Tidak Ditemukan</h5>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginasi --}}
    <div class="d-flex justify-content-end">
        {{ $sales->appends(request()->query())->links() }}
    </div>

@endsection