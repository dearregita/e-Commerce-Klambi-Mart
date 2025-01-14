<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - {{ $month }}</title>
    <style>
        @page {
          size: A4 landscape;
          margin: 20mm;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .invoice {
            max-width: 1280px;
            margin: 15px auto;
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 28px;
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }
        .details {
            font-size: 14px;
            color: #555;
        }
        .details p {
            margin: 5px 0;
        }
        .items table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items table th, .items table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .items table th {
            background-color: #4CAF50;
            color: white;
            font-size: 14px;
        }
        .items table td {
            font-size: 14px;
            color: #555;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <h1>Laporan Bulanan</h1>
            <p>{{ $month }}</p>
        </div>
        <div class="details">
            <p><strong>Total Pelanggan:</strong> {{ $totalCustomer }}</p>
            <p><strong>Total Pesanan Selesai:</strong> {{ $totalCompleteOrders }}</p>
            <p><strong>Total Pendapatan:</strong> Rp{{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="items">
            <h3>Daftar Pesanan</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Total Pembayaran</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $statusText = [
                            'pending' => 'Pembayaran Sedang Diperiksa',
                            'delivered' => 'Pesanan Telah Diterima Kurir',
                            'arrived' => 'Pesanan Telah Sampai',
                            'completed' => 'Langganan Anda Telah Disetujui',
                            'rejected' => 'Pesanan Telah Ditolak',
                        ];
                      @endphp
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->user->email }}</td>
                            <td>
                              {{ $statusText[$order->status] ?? 'Status Tidak Diketahui' }}
                            </td>
                            <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                          </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="total">
            Total Pendapatan: Rp{{ number_format($totalIncome, 0, ',', '.') }}
        </div>
    </div>
</body>
</html>
