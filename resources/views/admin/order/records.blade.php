<div class="container">
    <h2>Riwayat Pesanan Anda</h2>

    @if ($orders->isEmpty())
        <p>Anda belum memiliki pesanan.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Penerima</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal Pesan</th>
                    <th>Kode Pesanan</th>
                    <th>Detail Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->receiver }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->date }}</td>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->detail_status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
