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
    <title>Transactions</title>

    <style>
        .header {
            background-color: #f1f1f1;
            text-align: start;
            padding: 5px;
        }

        .header a {
            margin: 0 15px;
            text-decoration: none;
            color: gray;
        }

        .header a:hover {
            color: black;
        }

        .logoutBtn {
            --black: #000000;
            --ch-black: #141414;
            --eer-black: #1b1b1b;
            --night-rider: #2e2e2e;
            --white: #ffffff;
            --af-white: #f3f3f3;
            --ch-white: #e1e1e1;
            --gray: #808080;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 35px;
            height: 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: var(--gray);
            margin-left: 20px;
            margin-right: 10px;
        }

        /* plus sign */
        .logoutSign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logoutSign svg {
            width: 17px;
        }

        .logoutSign svg path {
            fill: var(--af-white);
        }

        /* text */
        .logoutText {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: var(--af-white);
            font-size: 1.0em;
            font-weight: 600;
            transition-duration: .3s;
        }

        /* hover effect on button width */
        .logoutBtn:hover {
            width: 100px;
            border-radius: 5px;
            transition-duration: .3s;
        }

        .logoutBtn:hover .logoutSign {
            width: 30%;
            transition-duration: .3s;
        }

        /* hover effect button's text */
        .logoutBtn:hover .logoutText {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }

        /* button click effect*/
        .logoutBtn:active {
            transform: translate(2px, 2px);
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header d-flex justify-content-between align-items-center">
            <div>
                <a class="ms-5" href="{{ route('Users.orders') }}">Transaction History</a>
                <a href="{{ route('Users.POS') }}">Point of Sale</a>
            </div>
            <form action="{{ route('Logins.logout') }}" method="get">
                @csrf
                @method('get')
                <button type="submit" class="logoutBtn me-5">
                    <div class="logoutSign">
                        <svg viewBox="0 0 512 512">
                            <path
                                d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                            </path>
                        </svg>
                    </div>
                    <div class="logoutText">Logout</div>
                </button>
            </form>
        </div>
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
