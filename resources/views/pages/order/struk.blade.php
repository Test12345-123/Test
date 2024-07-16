<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-info,
        .order-details,
        .total,
        .payment {
            margin-bottom: 20px;
        }

        .divider {
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .order-details h3,
        .total h3,
        .payment h3 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border-bottom: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .qty,
        .price {
            text-align: center;
        }

        .price {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Order Receipt</h1>

        <!-- Receipt Info -->
        <div class="receipt-info">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Employee Name:</strong> {{ $order->user->nama }}</p>
            <p><strong>Customer Name:</strong> {{ $order->nama_pelanggan }}</p>
            <p><strong>Status:</strong>
                @if($order->status == 'Completed')
                <span style="color: green;">{{ $order->status }}</span>
                @elseif($order->status == 'Pending')
                <span style="color: orange;">{{ $order->status }}</span>
                @else
                {{ $order->status }}
                @endif
            </p>
            <p><strong>Table Number:</strong> {{ $order->table->nomor_meja }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</p>
        </div>
        <div class="divider"></div>

        <!-- Order Details -->
        <div class="order-details">
            <h3>Order Details</h3>
            <table>
                <tr>
                    <th>Nama Menu</th>
                    <th class="qty">Qty</th>
                    <th class="price">Harga</th>
                </tr>
                @foreach($order->menus as $menu)
                <tr>
                    <td>{{ $menu->nama_menu }}</td>
                    <td class="qty">{{ $menu->pivot->qty }}</td>
                    <td class="price">Rp {{ number_format($menu->harga * $menu->pivot->qty, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <td></td>
                    <td class="price">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="divider"></div>

        <!-- Payment -->
        <div class="payment">
            <h3>Payment</h3>
            <table>
                <tr>
                    <th>Payment Amount</th>
                    <td></td>
                    <td class="price">Rp {{ number_format($order->bayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Change</th>

                    @if ($order->bayar > 0)
                    <td></td>
                    <td class="price">Rp {{ number_format($order->bayar - $order->total, 0, ',', '.') }}</td>
                    @else
                    <td></td>
                    <td class="price">Change: Rp 0</td>
                    @endif
                </tr>
            </table>
        </div>
        <div class="divider"></div>
    </div>
</body>

</html>
