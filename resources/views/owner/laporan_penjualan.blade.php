@extends('layouts.owner-template')
@section('content')
<div class="container-fluid">
    <h6 class="box-title text-center text-uppercase font-weight-bold text-primary mb-5">Laporan Penjualan</h6>

    <!-- Form untuk Filter Tanggal -->
    <form method="GET" action="{{ route('owner.laporan_penjualan') }}" class="row mb-4">
        <div class="col-md-4">
            <label for="from_date" class="text-dark font-weight-bold">Dari Tanggal</label>
            <input type="date" name="from_date" id="from_date" class="form-control shadow-sm border-primary" value="{{ $startDate }}" required>
        </div>
        <div class="col-md-4">
            <label for="to_date" class="text-dark font-weight-bold">Sampai Tanggal</label>
            <input type="date" name="to_date" id="to_date" class="form-control shadow-sm border-primary" value="{{ $endDate }}" required>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2 shadow">Filter</button>
            <a href="{{ route('owner.laporan_penjualan') }}" class="btn btn-secondary shadow">Reset</a>
        </div>
    </form>

    <!-- Statistik Penjualan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card p-3 shadow-sm border-info" style="border-radius: 10px;">
                <h5>Total Penjualan</h5>
                <p class="fw-bold text-info">Rp. {{ number_format($stats['total_sales'] ?? 0, 0) }}</p>
                <p class="text-muted">Ini adalah total pendapatan yang dihasilkan dari semua pesanan dalam periode yang dipilih. Laporan ini mencakup semua produk yang terjual.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm border-success" style="border-radius: 10px;">
                <h5>Jumlah Pesanan</h5>
                <p class="fw-bold text-success">{{ $stats['order_count'] ?? 0 }}</p>
                <p class="text-muted">Menunjukkan berapa banyak pesanan yang diproses selama periode ini. Setiap pesanan dihitung terlepas dari jenis produk yang dibeli.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm border-warning" style="border-radius: 10px;">
                <h5>Rata-rata Pesanan</h5>
                <p class="fw-bold text-warning">Rp. {{ number_format($stats['avg_order_value'] ?? 0, 0) }}</p>
                <p class="text-muted">Menghitung rata-rata pendapatan per pesanan yang diterima. Angka ini memberikan gambaran tentang seberapa banyak pelanggan membelanjakan untuk setiap pesanan.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm border-danger" style="border-radius: 10px;">
                <h5>Pertumbuhan</h5>
                <p class="fw-bold {{ ($stats['sales_growth'] ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($stats['sales_growth'] ?? 0, 1) }}%
                </p>
                <p class="text-muted">Persentase pertumbuhan penjualan dibandingkan dengan periode sebelumnya. Jika angka positif, berarti penjualan meningkat, jika negatif berarti terjadi penurunan.</p>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan Harian dan Bulanan -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm border-primary" style="border-radius: 10px;">
                <h5>Penjualan Harian</h5>
                <canvas id="dailySalesChart" height="100"></canvas>
                <p class="text-muted">Grafik ini menunjukkan fluktuasi penjualan harian dalam periode yang dipilih. Setiap titik menggambarkan total penjualan pada hari tersebut.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow-sm border-primary" style="border-radius: 10px;">
                <h5>Penjualan Bulanan</h5>
                <canvas id="monthlySalesChart" height="100"></canvas>
                <p class="text-muted">Grafik ini menunjukkan penjualan bulanan yang mengilustrasikan bagaimana total penjualan berkembang sepanjang tahun.</p>
            </div>
        </div>
    </div>

        <!-- Produk Terlaris & Distribusi Status Pesanan (side by side) -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm border-success" style="border-radius: 10px;">
                <h5>Produk Terlaris</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jumlah Terjual</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stats['top_products'] ?? [] as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->total_quantity }}</td>
                                <td>Rp. {{ number_format($product->total_revenue, 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data produk terlaris</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow-sm border-danger" style="border-radius: 10px;">
                <h5>Distribusi Status Pesanan</h5>
                <div style="max-width: 350px; margin: 0 auto;">
                    <canvas id="statusChart"></canvas>
                </div>
                <p class="text-muted">Pie chart ini menunjukkan distribusi status pesanan berdasarkan status seperti 'Pending', 'Selesai', 'Dibatalkan', dan lainnya. Ini membantu Anda memantau sejauh mana pesanan diproses.</p>
            </div>
        </div>
    </div>

        <!-- Penjualan per Kategori (di bawahnya) -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card p-3 shadow-sm border-info" style="border-radius: 10px;">
                <h5>Penjualan per Kategori</h5>
                <div style="max-width: 600px; margin: 0 auto;">
                    <canvas id="categorySalesChart" height="150"></canvas>
                </div>
                <p class="text-muted">Grafik ini menunjukkan kontribusi setiap kategori produk terhadap total penjualan. Dengan chart ini, Anda dapat melihat kategori mana yang memiliki kontribusi terbesar.</p>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari backend Laravel, sudah di-convert ke JSON
    const dailySalesLabels = @json($stats['daily_sales']->pluck('date'));
    const dailySalesData = @json($stats['daily_sales']->pluck('total_sales'));

    const monthlySalesLabels = @json($stats['monthly_sales']->pluck('month'));
    const monthlySalesData = @json($stats['monthly_sales']->pluck('total_sales'));

    const categoryLabels = @json($stats['sales_by_category']->pluck('category'));
    const categoryData = @json($stats['sales_by_category']->pluck('total_sales'));

    // Untuk chart distribusi status pesanan
    const statusLabels = {!! json_encode(array_keys($stats['status_distribution'] ?? [])) !!};
    const statusData = {!! json_encode(array_values($stats['status_distribution'] ?? [])) !!};

    // Hitung persentase distribusi status
    const statusTotal = statusData.reduce((a, b) => a + b, 0);
    const statusPercent = statusData.map(val => statusTotal ? ((val / statusTotal) * 100).toFixed(1) : 0);

    // Chart Penjualan Harian - Line Chart
    const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
    const dailySalesChart = new Chart(dailySalesCtx, {
        type: 'line',
        data: {
            labels: dailySalesLabels,
            datasets: [{
                label: 'Penjualan Harian',
                data: dailySalesData,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Chart Penjualan Bulanan - Bar Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    const monthlySalesChart = new Chart(monthlySalesCtx, {
        type: 'bar',
        data: {
            labels: monthlySalesLabels,
            datasets: [{
                label: 'Penjualan Bulanan',
                data: monthlySalesData,
                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Chart Penjualan per Kategori - Doughnut Chart
    const categorySalesCtx = document.getElementById('categorySalesChart').getContext('2d');
    const categorySalesChart = new Chart(categorySalesCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Penjualan per Kategori',
                data: categoryData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            // Hitung persentase kategori
                            const total = context.chart._metasets[0].total || 1;
                            const percent = ((value / total) * 100).toFixed(1);
                            return `${label}: Rp ${value.toLocaleString()} (${percent}%)`;
                        }
                    }
                },
                legend: { position: 'bottom' }
            }
        }
    });

    // Pie Chart Distribusi Status
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: statusLabels.map((label, i) => `${label} (${statusPercent[i]}%)`),
            datasets: [{
                data: statusData,
                backgroundColor: ['#dc3545', '#ffc107', '#28a745', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            return `${label}: ${value} pesanan`;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection