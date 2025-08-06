@extends('admin.app_admin')

@section('title', 'Edit Produk')

@section('content_admin')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <h4 class="mb-4">Edit Produk</h4>

        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.products.update', $product['id']) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name"
                       class="form-label">Nama Produk</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required
                       value="{{ old('name', $product['name']) }}">
            </div>

            <div class="mb-3">
                <label for="price"
                       class="form-label">Harga</label>
                <input type="text"
                       name="price"
                       id="price"
                       class="form-control only-number"
                       required
                       value="{{ old('price', number_format($product['price'], 0, ',', '.')) }}">
            </div>

            <div class="mb-3">
                <label for="stock"
                       class="form-label">Stok</label>
                <input type="number"
                       name="stock"
                       class="form-control"
                       required
                       value="{{ old('stock', $product['stock']) }}">
            </div>

            <div class="mb-3">
                <label for="description"
                       class="form-label">Deskripsi</label>
                <textarea name="description"
                          class="form-control"
                          id="description"
                          rows="4"
                          required>{{ old('description', $product['description'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image"
                       class="form-label">Gambar Produk</label>
                <input type="file"
                       name="image"
                       class="form-control">

                @if (!empty($product['image']))
                <div class="mt-2">
                    <p class="mb-1">Gambar saat ini:</p>
                    <img src="{{ $product['image'] }}"
                         alt="Gambar Produk"
                         class="img-thumbnail"
                         style="max-width: 150px;">
                </div>
                @endif
            </div>

            <button type="submit"
                    class="btn btn-success">Update</button>
            <a href="{{ route('admin.products.index') }}"
               class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(document).ready(function () {
            $('.only-number').on('input', function () {
            let value = $(this).val().replace(/[^0-9]/g, '');
            if (value) {
                value = formatRupiah(value);
            }
        $(this).val(value);
    });

        function formatRupiah(angka) {
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
</script>
@endsection