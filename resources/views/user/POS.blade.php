<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Point of Sale</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .itemsCard {
            width: 12rem;
            height: 7rem;
            border: 1px solid black;
            border-radius: 10px;
            padding: 10px;
            margin: 1rem;
            margin-right: 10px;
            text-align: center;
        }

        .order-item {
            margin-bottom: 10px;
        }

        .card-body {
            padding: 10px;
        }

        .left-content {
            text-align: left;
        }

        .quantity-container {
            display: flex;
            align-items: center;
        }

        .quantity-input {
            width: 60px;
            margin: 0 5px;
        }

        .delete-btn {
            margin-left: 10px;
        }

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

    <div class="container-fluid" style="Background-color:rgb(169, 169, 255);">
        <div class="row">
            <div class="col-8 col-md-8">
                <div class="row">
                    <div class="col-12 col-md-12 mt-4" style="background-color:rgb(223, 38, 69);">
                        @foreach ($categories as $category)
                            <button class="ms-5 categoryButton"
                                data-category="{{ $category->category }}">{{ $category->category }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 mt-3" style="background-color:rgb(91, 255, 76);" id="itemsContainer">
                        <!-- Products will be dynamically added here -->
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-4" style="background-color: pink;">
                <h3 class="mt-4">Current Order</h3>
                <div id="currentOrder"></div>
                <h5 class="mt-5" id="subtotal">Subtotal:</h5>
                <h5 id="total">Total:</h5>
                <button class="btn btn-success" id="submitOrder">Order</button>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load session data when the page loads
            $.get('/session-data', function(data) {
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    addToOrder(item);
                }
            });

            // Will handle adding the items to the current order.
            function addToOrder(product) {
                // Check if the item already exists in the current order
                var existingOrderItem = $('.order-item').filter(function() {
                    return $(this).find('.product-name').text() === product
                        .product_name;
                });

                if (existingOrderItem.length > 0) {
                    // Item already exists, do nothing
                    return;
                } else {
                    // Item doesn't exist, add it to the current order
                    var orderCard = $('<div class="card order-item"></div>');
                    var cardBody = $(
                        '<div class="card-body d-flex justify-content-between align-items-center"></div>'
                    );
                    var leftContent = $('<div class="left-content"></div>');
                    var productName = $('<p class="product-name mb-0">' + product
                        .product_name + '</p>');
                    var price = $('<p class="price mb-0">Price: ₱ ' + product
                        .price + '</p>');
                    var quantityContainer = $(
                        '<div class="quantity-container"></div>');
                    var minusButton = $(
                        '<button class="btn btn-danger minus-btn">-</button>');
                    var quantityInput = $(
                        '<input type="number" class="form-control quantity-input" value="1" min="1">'
                    );
                    var plusButton = $(
                        '<button class="btn btn-success plus-btn">+</button>');
                    var deleteButton = $(
                        '<button class="btn btn-danger delete-btn"><i class="fa-solid fa-xmark"></i></button>'
                    );

                    leftContent.append(productName, price);
                    quantityContainer.append(minusButton, quantityInput,
                        plusButton);
                    cardBody.append(leftContent, quantityContainer, deleteButton);
                    orderCard.append(cardBody);

                    $('#currentOrder').append(orderCard);
                    updateSessionData();

                    // Add event listeners for the minus, plus, and delete buttons
                    minusButton.click(function() {
                        var currentQuantity = parseInt(quantityInput.val());
                        if (currentQuantity > 1) {
                            quantityInput.val(currentQuantity - 1);
                            calculateTotals();
                            updateSessionData();
                        }
                    });

                    plusButton.click(function() {
                        var currentQuantity = parseInt(quantityInput.val());
                        quantityInput.val(currentQuantity + 1);
                        calculateTotals();
                        updateSessionData();
                    });

                    deleteButton.click(function() {
                        orderCard.remove();
                        calculateTotals();
                        updateSessionData();
                    });

                    // Call calculateTotals after adding the order item
                    calculateTotals();
                }
            }

            var subtotal = 0;
            var total = 0;

            function calculateTotals() {
                subtotal = 0;
                total = 0;

                $('.order-item').each(function() {
                    var quantity = parseInt($(this).find('.quantity-input')
                        .val());
                    var price = parseFloat($(this).find('.price').text()
                        .replace('Price: ₱ ', ''));
                    var itemTotal = quantity * price;

                    subtotal += itemTotal;
                });

                total =
                    subtotal; // For now, we'll assume no additional charges or deductions

                $('#subtotal').text('Subtotal: ₱ ' + subtotal.toFixed(2));
                $('#total').text('Total: ₱ ' + total.toFixed(2));
            }

            $('.categoryButton').click(function() {
                var category = $(this).data('category');

                $.ajax({
                    url: '/pos/' + category,
                    type: 'GET',
                    success: function(data) {
                        // Clear the current items
                        $('.itemsCard').remove();

                        // Append the new items based on the selected categor
                        // Click event listener to itemsCard.
                        $.each(data, function(index, product) {
                            var itemCard = $(
                                '<div class="card mt-2 itemsCard d-inline-block"></div>'
                            );
                            var itemContent = $('<div class="card-body"></div>');
                            itemContent.append('<p class="card-title">' + product
                                .product_name + '</p>');
                            itemContent.append('<p class="card-text">Price: ₱ ' +
                                product.price + '</p>');
                            itemCard.append(itemContent);
                            itemCard.click(function() {
                                addToOrder(product);
                            });
                            $('#itemsContainer').append(itemCard);
                        });

                    },
                    error: function() {
                        alert('Error fetching products.');
                    }
                });
            });

            // function for session
            function updateSessionData() {
                var orderData = [];
                $('.order-item').each(function() {
                    var productName = $(this).find('.product-name').text();
                    var price = parseFloat($(this).find('.price').text().replace(
                        'Price: ₱ ', ''));
                    var quantity = parseInt($(this).find('.quantity-input').val());

                    orderData.push({
                        product_name: productName,
                        price: price,
                        quantity: quantity
                    });
                });

                $.ajax({
                    url: '/update-session',
                    type: 'POST',
                    data: {
                        order: orderData,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Session data updated successfully.');
                    },
                    error: function() {
                        console.log('Error updating session data.');
                    }
                });
            }

            $('#submitOrder').click(function() {
                var orderData = [];
                $('.order-item').each(function() {
                    var productName = $(this).find('.product-name').text();
                    var price = parseFloat($(this).find('.price').text().replace('Price: ₱ ', ''));
                    var quantity = parseInt($(this).find('.quantity-input').val());

                    orderData.push({
                        product_name: productName,
                        price: price,
                        quantity: quantity
                    });
                });

                $.ajax({
                    url: '/place-order',
                    type: 'POST',
                    data: {
                        order: orderData,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Order placed successfully!');
                            // Clear the current order section
                            $('#currentOrder').empty();
                        }
                    },
                    error: function() {
                        alert('Error placing order. Please try again.');
                    }
                });
            });
        });
    </script>

</body>

</html>
