@csrf

{{-- Input Nama --}}
<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- Input Email --}}
<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- Input Password --}}
<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">

    {{-- Petunjuk jika form digunakan untuk Edit --}}
    @if (isset($user))
        <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
    @endif

    @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- Select Role --}}
<div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
        <option value="">-- Pilih Role --</option>
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
    @error('role_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- Tombol Aksi --}}
<button type="submit" class="btn btn-success">
    {{ isset($user) ? 'Update' : 'Simpan' }}
</button>
<a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>
