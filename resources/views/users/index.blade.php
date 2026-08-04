@extends('layouts.app')

@section('title', 'Users')

@section('content')

@include('layouts.navbar')

<h1>Halaman Users</h1>

<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Create</a>

<form action="{{ route('admin.users') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            class="form-control" 
            placeholder="Search username or email"
        >
        <button class="btn btn-outline-secondary" type="submit">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.users') }}" class="btn btn-outline-danger">Reset</a>
        @endif
    </div>
</form>

<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($users as $user)
    <tr>
        <td>{{ $users->firstItem() + $loop->index }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role?->name ?? 'Tanpa Role' }}</td>
        <td>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                Edit Akun
            </a>

            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center py-3">Data pengguna tidak ditemukan.</td>
    </tr>
    @endforelse
  </tbody>
</table>


<div class="d-flex justify-content-end">
    {{ $users->appends(request()->query())->links() }}
</div>

@endsection