<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <title>Sidebar</title>

    <style>
        .header {
            background-color: #f1f1f1;
            text-align: start;
            padding: 10px;
        }

        .header a {
            margin: 0 15px;
            text-decoration: none;
            color: gray;
        }

        .header a:hover {
            color: black;
        }
    </style>
</head>

<body>
    <div class="header">
        <a class="ms-5" href="{{ route('Users.orders') }}">Transaction History</a>
        <a href="{{ route('Users.POS') }}">Point Of Sale</a>
    </div>

    <div>
        <h4 class="text-center mt-3">Transaction History</h4>
    </div>

    <div class="container-fluid">
        <div class="row w-75 m-auto mt-3 justify-content-center">
            @foreach ($groupedOrders as $orderId => $orders)
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @foreach ($orders as $order)
                                        <p class="mb-0">{{ $order->product_name }}: {{ $order->QTY }}</p>
                                    @endforeach
                                </div>
                                <div class="col-md-6 text-end">
                                    <h5 class="card-title"> {{ date('F j, Y', strtotime($orders[0]->created_at)) }}
                                    </h5>
                                    <p class="card-text">Total Price: <b>{{ $orders->sum('total_price') }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container d-flex justify-content-center">
            {{ $groupedOrders->links() }}
        </div>
    </div>
</body>

</html>
