@extends('admin.app_admin')

@section('title', 'Dashboard')

@section('content_admin')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Penjualan Hari Ini</p>
                    <h6 class="mb-0">Rp {{ number_format($data['today_sales'] ?? 0, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Penjualan</p>
                    <h6 class="mb-0">Rp {{ number_format($data['total_sales'] ?? 0, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pendapatan Hari Ini</p>
                    <h6 class="mb-0">Rp {{ number_format($data['today_revenue'] ?? 0, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-pie fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Pendapatan</p>
                    <h6 class="mb-0">Rp {{ number_format($data['total_revenue'] ?? 0, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Area -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">Penjualan Mingguan</h6>
                <div id="chart-weekly-sales"></div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">Produk Terlaris</h6>
                <div id="chart-top-product"></div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">Status Pesanan</h6>
                <div id="chart-order-status"></div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">Pertumbuhan Bulanan</h6>
                <div id="chart-monthly-growth"></div>
            </div>
        </div>
    </div>
</div>

<!-- Highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    const weeklySales = @json($data['weekly_sales'] ?? []);
    const bestsellers = @json($data['bestsellers'] ?? []);
    const orderStatus = @json($data['order_status_summary'] ?? []);
    const monthlySales = @json($data['monthly_sales'] ?? []);

    // Weekly Sales
    Highcharts.chart('chart-weekly-sales', {
        title: { text: 'Penjualan Mingguan' },
        xAxis: { categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] },
        yAxis: { title: { text: 'Jumlah Produk Terjual' } },
        series: [{
            name: 'Produk Terjual',
            data: weeklySales
        }]
    });

    // Top Product Chart
    Highcharts.chart('chart-top-product', {
        chart: { type: 'column' },
        title: { text: 'Produk Terlaris' },
        xAxis: {
            categories: bestsellers.map(item => item.product?.name ?? 'Unknown'),
            title: { text: 'Produk' }
        },
        yAxis: {
            min: 0,
            title: { text: 'Jumlah Terjual' }
        },
        series: [{
            name: 'Qty',
            data: bestsellers.map(item => item.total_qty)
        }]
    });

    // Order Status Chart
    Highcharts.chart('chart-order-status', {
        chart: { type: 'column' },
        title: { text: 'Status Pesanan' },
        xAxis: {
            categories: Object.keys(orderStatus),
            title: { text: 'Status' }
        },
        yAxis: {
            title: { text: 'Jumlah Pesanan' }
        },
        series: [{
            name: 'Pesanan',
            data: Object.values(orderStatus)
        }]
    });

    // Monthly Growth Chart
    Highcharts.chart('chart-monthly-growth', {
        chart: { type: 'line' },
        title: { text: 'Pertumbuhan Pendapatan Bulanan' },
        xAxis: {
            categories: monthlySales.map(item => item.month),
        },
        yAxis: {
            title: { text: 'Pendapatan (Rp)' }
        },
        series: [{
            name: 'Pendapatan',
            data: monthlySales.map(item => parseFloat(item.total))
        }]
    });
</script>
@endsection