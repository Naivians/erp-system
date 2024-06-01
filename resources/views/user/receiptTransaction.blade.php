<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Receipt</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 8px;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            font-size: 10px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        p {
            margin: 0;
        }

        .upperReceipt {
            text-align: center;
        }

        .bottomReceipt {
            text-align: center;
        }
    </style>
</head>

<body>
    <p class="upperReceipt">OWWO FOOD CORP.</p>
    <p class="upperReceipt">Owned and Operatd By</p>
    <p class="upperReceipt">OWWO FOOD CORP.</p>

    <p class="upperReceipt">BESIDE M. LHUILLIER NATIONAL HIGHWAY</p>
    <p class="upperReceipt">KUMINTANG ILAYA 4200 BATANGAS CITY (CAPITAL)</p>
    <p class="upperReceipt">BATANGAS PHILIPPINES</p>
    <br>
    <p class="upperReceipt">NON VAT REG TIN: 827-275-378-000</p>
    <p class="upperReceipt">MIN: 24012506382304578</p>
    <p class="upperReceipt">S/N: HA1HGKBO (21)</p>
    <br>
    <h1 class="upperReceipt">OFFICIAL RECEIPT</h1>
    <br>
    <p>Date: {{ $date }}</p>
    <p>Cashier: {{ $cashier }}</p>
    <p>Official Receipt No .: {{ $orderId }}</p>
    <br>
    <ul>
        @foreach ($orderData as $item)
            <li>{{ $item->product_name }}: {{ $item->QTY }}: ₱{{ number_format($item->price, 2) }}</li>
        @endforeach
    </ul>
    <p>Subtotal: ₱{{ number_format($total, 2) }}</p>
    <p>Total: ₱{{ number_format($total, 2) }}</p>
    <p>Payment Type: Cash</p>
    <p>Total Qty: {{ $qty }}</p>
    <br>
    <p class="bottomReceipt">THIS DOCUMENT IS NOT VALID FOR</p>
    <p class="bottomReceipt">CLAIM OF INPUT TAX</p>
    <p class="bottomReceipt">THIS SERVES AS YOUR OFFICIAL INVOICE</p>
    <br>
    <p class="bottomReceipt">KRES POS wv2.01</p>
    <p class="bottomReceipt">Powered by UTMAP( www.utak.pn</p>
    <p class="bottomReceipt">Kintoz IT Solutions</p>
    <p class="bottomReceipt">440 M.Leyva ST Mandaluyong City</p>
    <p class="bottomReceipt">VAT REG TIN 278-438-142-000</p>
    <p class="bottomReceipt">Accred No: 0412754381422014980097</p>
    <p class="bottomReceipt">Date Issued: 08/10/2015</p>
    <p class="bottomReceipt">Valid Until: 07/31/2025</p>
    <br>
    <p class="bottomReceipt">PTU No .: PQ12024-658-0427879-00000</p>
    <p class="bottomReceipt">Date Issued: 01/31/2024</p>
    <br>
    <p>Customer Name:____________</p>
    <p>Address:____________</p>
    <p>TIN:____________</p>
    <p>Signature:____________</p>
</body>

</html>
