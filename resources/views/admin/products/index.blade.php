@extends('admin.app_admin')

@section('title', 'Produk')

@section('content_admin')
<!-- Content Start -->
<div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Produk</h5>
        <a href="{{ route('admin.products.create') }}"
           class="btn btn-primary">+ Tambah Produk</a>
    </div>

    {{-- Search --}}
    <form method="GET"
          action="{{ route('admin.products.index') }}"
          class="mb-3">
        <div class="input-group w-50">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari produk..."
                   value="{{ request('search') }}">
            <button class="btn btn-outline-secondary"
                    type="submit">Cari</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>Rp{{ number_format($product['price'], 0, ',', '.') }}</td>
                    <td>{{ $product['stock'] }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product['id']) }}"
                           class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('admin.products.destroy', $product['id']) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5"
                        class="text-center">Produk tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- (Optional) Manual Pagination --}}
    {{-- Jika pagination disediakan oleh API, bisa ditambahkan di sini --}}

</div>
<!-- Content End -->
@endsection