@extends('admin.app_admin')

@section('title', 'Detail Pesanan')

@section('content_admin')
<div class="container-fluid pt-4 px-4">
    <h4 class="mb-4">Detail Pesanan #{{ $order['id'] }}</h4>

    <p><strong>Pelanggan:</strong> {{ $order['user']['name'] ?? '-' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order['status']) }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($order['total_price'], 0, ',', '.') }}</p>
    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y H:i') }}</p>

    <h5 class="mt-4">Produk</h5>
    <ul class="list-group mb-4">
        @foreach ($order['details'] ?? [] as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $item['product']['name'] ?? '-' }}
            <span>{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
            <img src="{{ $item['product']['image'] }}"
                 style="max-width: 100px;"
                 alt="gambar">
        </li>


        @endforeach
    </ul>

    <form action="{{ route('admin.orders.updateStatus', $order['id']) }}"
          method="POST"
          class="d-flex">
        @csrf
        @method('PUT')
        <select name="status"
                class="form-select me-2"
                required>
            <option value="pending"
                    {{
                    $order['status']=='pending'
                    ? 'selected'
                    : ''
                    }}>Pending</option>
            <option value="processed"
                    {{
                    $order['status']=='processed'
                    ? 'selected'
                    : ''
                    }}>Diproses</option>
            <option value="completed"
                    {{
                    $order['status']=='completed'
                    ? 'selected'
                    : ''
                    }}>Selesai</option>
            <option value="cancelled"
                    {{
                    $order['status']=='cancelled'
                    ? 'selected'
                    : ''
                    }}>Dibatalkan</option>
        </select>
        <button type="submit"
                class="btn btn-primary">Ubah Status</button>
    </form>
</div>
@endsection