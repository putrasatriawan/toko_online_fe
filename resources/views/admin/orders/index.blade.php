@extends('admin.app_admin')

@section('title', 'Daftar Pesanan')

@section('content_admin')
<div class="container-fluid pt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Pesanan</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order['user']['name'] ?? '-' }}</td>
                    <td>Rp{{ number_format($order['total_price'], 0, ',', '.') }}</td>
                    <td>{{ ucfirst($order['status']) }}</td>
                    <td>{{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order['id']) }}"
                           class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6"
                        class="text-center">Pesanan tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection