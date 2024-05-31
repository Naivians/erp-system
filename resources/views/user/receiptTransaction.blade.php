<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Receipt</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Monospace font for the receipt */
            font-size: 12px; /* Adjust based on your specific printer */
            margin: 0; /* Remove default margins */
            padding: 0; /* Remove default padding */
        }
        h1, h2 {
            font-size: 15px; /* Larger font size for headers */
        }
        ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove default padding */
        }
        li {
            margin-bottom: 5px; /* Add some space between items */
        }
        p {
            margin-bottom: 5px; /* Add some space between paragraphs */
        }
    </style>
</head>

<body>
    <h1>Receipt</h1>
    <p>Order ID: {{ $orderId }}</p>
    <p>Date: {{ $date }}</p>
    <h2>Order Details:</h2>
    <ul>
        @foreach ($orderData as $item)
            <li>{{ $item->product_name }}: {{ $item->QTY }}: ₱{{ number_format($item->price, 2) }}</li>
        @endforeach
    </ul>
    <p>Total: ₱{{ number_format($total, 2) }}</p>
</body>

</html>
