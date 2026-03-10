<!-- resources/views/admin/order/index.blade.php -->
@extends('layouts.admin-template')
@section('content')

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Daftar Pesanan</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <div class="container-fluid">
        <div class="none-mobile-ui">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box-header">
                        <h6 class="box-title">Daftar Pesanan</h6>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row" style="margin-bottom: 30px;">
                                <div class="col-5">
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        placeholder="From Date" />
                                </div>
                                <div class="col-5">
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        placeholder="To Date" />
                                </div>
                                <div class="col">
                                    <button type="button" name="filter" id="filter"
                                        class="btn btn-primary">Filter</button>
                                    <button type="button" name="refresh" id="refresh"
                                        class="btn btn-secondary">Reset</button>
                                </div>
                            </div>
                            <div style="overflow: auto;">
                                <table class="table table-bordered" id="product-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Penerima</th>
                                            <th>No Telepon</th>
                                            <th>Total Bayar</th>
                                            <th>Kode Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Status Pengiriman</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr data-id="{{ $order->id }}" data-receiver="{{ $order->receiver }}"
                                                data-phone="{{ $order->address ?? '' }}"
                                                data-total="{{ number_format($order->total_price, 0, ',', '.') }}"
                                                data-date="{{ $order->date }}" data-status="{{ $order->status }}"
                                                data-order-code="{{ $order->id }}"
                                                data-detail-status="{{ $order->detail_status ?? '' }}">
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->receiver }}</td>
                                                <td>{{ $order->address }}</td>
                                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->date }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>{{ $order->detail_status ?? 'Belum diatur' }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.order.detail', $order->id) }}"
                                                            class="btn btn-sm btn-primary">Detail</a>
                                                        <button class="btn btn-sm btn-danger print-btn"
                                                            data-id="{{ $order->id }}">Cetak</button>
                                                        <form action="{{ route('admin.order.updateStatus', $order->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <select name="detail_status" onchange="this.form.submit()">
                                                                <option value="">Pilih Status</option>
                                                                @foreach (\App\Models\Order::$deliveryStatuses as $status)
                                                                    <option value="{{ $status }}"
                                                                        {{ $order->detail_status == $status ? 'selected' : '' }}>
                                                                        {{ $status }}</option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
            $(document).on('click', '.print-btn', function() {
                var row = $(this).closest('tr');
                var orderId = row.data('id');
                var receiver = row.data('receiver');
                var phone = row.data('phone');
                var total = row.data('total');
                var date = row.data('date');
                var orderCode = row.data('order-code');
                var status = row.data('status');
                var detailStatus = row.data('detail-status');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pesanan ini akan dicetak!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, cetak!',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var printWindow = window.open('', '', 'height=400,width=800');
                        var content = `
                        <html>
                            <head>
                                <title>Cetak Pesanan ${orderCode}</title>
                                <style>
                                    body { font-family: Arial, sans-serif; }
                                    .table { width: 100%; border-collapse: collapse; }
                                    .table th, .table td { padding: 8px; text-align: center; border: 1px solid #ddd; }
                                    .table th { background-color: #f2f2f2; }
                                </style>
                            </head>
                            <body>
                                <h2>Detail Pesanan Kode: ${orderCode}</h2>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Penerima</th>
                                            <th>No Telepon</th>
                                            <th>Total Bayar</th>
                                            <th>Kode Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Status Pengiriman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>${receiver}</td>
                                            <td>${phone}</td>
                                            <td>Rp ${total}</td>
                                            <td>${orderCode}</td>
                                            <td>${date}</td>
                                            <td>${status}</td>
                                            <td>${detailStatus || 'Belum diatur'}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </body>
                        </html>
                    `;
                        printWindow.document.write(content);
                        printWindow.document.close();
                        printWindow.print();
                    }
                });
            });
        </script>
    @endsection
