@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <h4>Tambah Produk</h4>

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('produk._form')
    </form>
@endsection