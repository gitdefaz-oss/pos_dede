@csrf


<div class="mb-3">
    <label class="form-label">Gambar</label>
    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
    @error('foto')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $produk->nama ?? '') }}">
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Harga Beli</label>
    <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror"
        value="{{ old('purchase_price', $produk->harga_beli ?? '') }}">
    @error('purchase_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Harga Jual</label>
    <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror"
        value="{{ old('selling_price', $produk->harga_jual ?? '') }}">
    @error('selling_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Stok</label>
    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
        value="{{ old('stock', $produk->stok ?? '') }}">
    @error('stock')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<button class="btn btn-success mt-2" type="submit">Simpan</button>
<a href="{{ route('produk.index') }}" class="btn btn-secondary mt-3">Kembali</a>


<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>