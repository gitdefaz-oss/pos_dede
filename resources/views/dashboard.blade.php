{{-- memanggil file app.blade.php --}}
@extends('layouts.app')

{{-- mengirimkan nilai ke title untuk ditampilkan --}}
@section('title', 'Dashboard')

{{-- batas awal isi konten --}}
@section('content')

@include('layouts.navbar')

<div class="text-center">
  <div class="row">
    <div class="col-md-12">
      <h1>Today's Sales</h1>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                TOTAL PENJUALAN HARI INI
            </div>
            <div class="card-body">
                <h5 class="card-title">Rp {{ number_format($ringkasan['total_penjualan']) }}</h5>
            </div>
        </div>
      <h3>Total Nilai Penjualan Hari ini</h3>
      <div class="card">
  <div class="card-header">
    Featured
  </div>
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                JUMLAH TRANSAKSI HARI INI
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $ringkasan['total_transaksi'] }}</h5>
            </div>
        </div>
        </div>
         <div class="col-md-6">
          <div class="card">
            <div class="card-header">
                JUMLAH TRANSAKSI HARI INI
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ number_format($ringkasan['total_non_tunai']) }}</h5>
            </div>
          </div>
      <h3>Jumlah Transaksi Hari ini</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h1>Cash & Payment Status</h1>
    </div>
    <div class="col-md-6">
        </div>
      <h3>Total pembayaran tunai</h3>
    </div>
    <div class="col-md-6">
      <h3>Total pembayaran non-tunai</h3>
    </div>
  </div>

  </div>
</div>
{{-- batas Akhir isi konten --}}
@endsection