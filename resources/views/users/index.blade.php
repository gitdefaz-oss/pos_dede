@extends('layouts.app')

@section('title', 'Users')

@section('content')

@include('layouts.navbar')

<h1>Halaman Users</h1>
<a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col">aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
<tr>
    <td>{{ $users->firstItem() + $loop->index }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role->name }}</td>
    <td>
        <a href="" class="btn btn-sm btn-warning">
            Edit Akun
        </a>
        ||
        <form action="" method="" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')">
                Hapus
            </button>
        </form>
    </td>
</tr>
@endforeach

  </tbody>
</table>

@endsection