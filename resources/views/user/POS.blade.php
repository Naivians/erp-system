<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Point of Sale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container-fluid" style="Background-color:rgb(169, 169, 255);">
        <div class="row">
            <div class="col-8 col-md-8">
                <div class="row">
                    <div class="col-12 col-md-12 mt-4" style="background-color:rgb(223, 38, 69);">
                        <button id="foods" class="ms-5">Foods</button>
                        <button id="nonFoodItems" class="ms-5">Non-food Items</button>
                        <button id="miscellaneous" class="ms-5">Miscellaneous</button>
                        <button id="officeSupplies" class="ms-5">Office Supplies</button>

                    </div>
                </div>
                <div class="row" id="itemsContainer">
                    <div class="col-12 col-md-12" style="background-color:rgb(91, 255, 76);">'

                    </div>
                </div>
            </div>
            <div class="col-4 col-md-4" style="background-color: pink;">
                <h3 class="mt-4">Current Order</h3>
                <div id="currentOrderContainer"></div>
                <button class="btn btn-success" id="submitOrders">Order</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Load session data when the page loads
            $.get('/session-data', function(data) {
                for (var i = 0; i < data.length; i++) {
                    // Capture the current item in a closure
                    (function(item) {
                        // Create a new order card for each item
                        var orderCard = $('<div class="card">' + item.product_name + '</div>');

                        // Create a container for the delete button and position it at the top right of the order card
                        var deleteButtonContainer = $('<div></div>');
                        deleteButtonContainer.css({
                            'position': 'absolute',
                            'top': '-10px',
                            'right': '-10px'
                        });

                        var minusButtonContainer = $('<div></div>');
                        minusButtonContainer.css({
                            'position': 'absolute',
                            'top': '30px',
                            'right': '90px'
                        });

                        var plusButtonContainer = $('<div></div>');
                        plusButtonContainer.css({
                            'position': 'absolute',
                            'top': '30px',
                            'right': '10px'
                        });

                        var quantityContainer = $('<div></div>');
                        quantityContainer.css({
                            'position': 'absolute',
                            'top': '28px',
                            'right': '58px'
                        });

                        // Create a div for the price and add it to the order card
                        var price = $('<div>Price: ' + item.price + '</div>');
                        orderCard.append(price);

                        // Create the delete button and add it to the container
                        var deleteButton = $(
                            '<button class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button>'
                        );
                        deleteButtonContainer.append(deleteButton);

                        // Add a minus button, a plus button, and a delete button to the order card
                        var minusButton = $(
                            '<button class="btn btn-danger"><i class="fa-solid fa-minus"></i></button>'
                        );
                        minusButtonContainer.append(minusButton);

                        var plusButton = $(
                            '<button class="btn btn-success"><i class="fa-solid fa-plus"></i></button>'
                        );
                        plusButtonContainer.append(plusButton);

                        var quantity = $(
                            '<span><bold>1</bold></span>'); // Initialize quantity to 1
                        quantityContainer.append(quantity);

                        // Add the buttons container, item name and quantity, and the minus and plus buttons to the order card
                        orderCard.append(deleteButtonContainer, quantityContainer,
                            minusButtonContainer, plusButtonContainer, price);

                        orderCard.css({
                            'position': 'relative',
                            'width': '24rem',
                            'height': '4rem',
                            'border': '1px solid black',
                            'border-radius': '5px',
                            'padding-top': '3px',
                            'padding-left': '5px',
                            'margin': '1rem'
                        });

                        minusButton.css({
                            'border': 'none',
                            'color': 'white',
                            'max-width': '20px',
                            'max-height': '20px',
                            'display': 'flex',
                            'justify-content': 'center',
                            'font-size': '11px',
                            'border-radius': '2px',
                            'align-items': 'center'
                        });

                        plusButton.css({
                            'border': 'none',
                            'color': 'white',
                            'max-width': '20px',
                            'max-height': '20px',
                            'display': 'flex',
                            'justify-content': 'center',
                            'font-size': '11px',
                            'border-radius': '2px',
                            'align-items': 'center'
                        });

                        deleteButton.css({
                            'border': 'none',
                            'color': 'white',
                            'max-width': '20px',
                            'max-height': '20px',
                            'display': 'flex',
                            'border-radius': '100%',
                            'justify-content': 'center',
                            'font-size': '11px',
                            'align-items': 'center'
                        });

                        // Add click event handlers to the buttons
                        minusButton.click(function() {
                            // Decrease the order number
                            var currentQuantity = parseInt(quantity.text());
                            if (currentQuantity >
                                1) { // Prevent quantity from going below 1
                                quantity.text(currentQuantity - 1);
                            }
                        });
                        plusButton.click(function() {
                            // Increase the order number
                            var currentQuantity = parseInt(quantity.text());
                            quantity.text(currentQuantity + 1);
                        });
                        deleteButton.click(function() {
                            /* Remove the order card */
                        });

                        // Add the order card to the "Current Order" container
                        $('#currentOrderContainer').append(orderCard);
                    })(data[i]); // Pass the current item to the closure
                }
            });
        });

        // Handle click events on category buttons
        $('#foods, #nonFoodItems, #miscellaneous, #officeSupplies').click(function() {
            var category = $(this).text();
            $.get('/pos/' + category, function(data) {
                // Clear the current items from the container
                $('#itemsContainer').empty();

                // Loop through the items returned from the server
                for (var i = 0; i < data.length; i++) {
                    // Capture the current item in a closure
                    (function(item) {
                        // Create a new card for each item
                        var card = $('<div class="card ms-3 pt-5">' + item.product_name +
                            '</div>');

                        card.css({
                            'width': '12rem',
                            'height': '7rem',
                            'border': '1px solid black',
                            'border-radius': '10px',
                            'padding': '10px',
                            'margin': '1rem',
                            'text-align': 'center'
                        });

                        // Add a click event handler to the item card
                        card.click(function() {
                            // When the item card is clicked, create a new order card
                            var orderCard = $('<div class="card">' + $(this)
                                .text() + '</div>');

                            // Create a container for the delete button and position it at the top right of the order card
                            var deleteButtonContainer = $('<div></div>');
                            deleteButtonContainer.css({
                                'position': 'absolute',
                                'top': '-10px',
                                'right': '-10px'
                            });

                            var minusButtonContainer = $('<div></div>');
                            minusButtonContainer.css({
                                'position': 'absolute',
                                'top': '30px',
                                'right': '90px'
                            });

                            var plusButtonContainer = $('<div></div>');
                            plusButtonContainer.css({
                                'position': 'absolute',
                                'top': '30px',
                                'right': '10px'
                            });

                            var quantityContainer = $('<div></div>');
                            quantityContainer.css({
                                'position': 'absolute',
                                'top': '28px',
                                'right': '58px'
                            });

                            // Create a div for the price and add it to the order card
                            var price = $('<div>Price: ' + item.price + '</div>');
                            orderCard.append(price);

                            // Create the delete button and add it to the container
                            var deleteButton = $(
                                '<button class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button>'
                            );
                            deleteButtonContainer.append(deleteButton);

                            // Add a minus button, a plus button, and a delete button to the order card
                            var minusButton = $(
                                '<button class="btn btn-danger"><i class="fa-solid fa-minus"></i></button>'
                            );
                            minusButtonContainer.append(minusButton);

                            var plusButton = $(
                                '<button class="btn btn-success"><i class="fa-solid fa-plus"></i></button>'
                            );
                            plusButtonContainer.append(plusButton);

                            var quantity = $(
                                '<span><bold>1</bold></span>'); // Initialize quantity to 1
                            quantityContainer.append(quantity);

                            // Add the buttons container, item name and quantity, and the minus and plus buttons to the order card
                            orderCard.append(deleteButtonContainer, quantityContainer,
                                minusButtonContainer, plusButtonContainer, price);

                            orderCard.css({
                                'position': 'relative',
                                'width': '24rem',
                                'height': '4rem',
                                'border': '1px solid black',
                                'border-radius': '5px',
                                'padding-top': '3px',
                                'padding-left': '5px',
                                'margin': '1rem'
                            });

                            minusButton.css({
                                'border': 'none',
                                'color': 'white',
                                'max-width': '20px',
                                'max-height': '20px',
                                'display': 'flex',
                                'justify-content': 'center',
                                'font-size': '11px',
                                'border-radius': '2px',
                                'align-items': 'center'
                            });

                            plusButton.css({
                                'border': 'none',
                                'color': 'white',
                                'max-width': '20px',
                                'max-height': '20px',
                                'display': 'flex',
                                'justify-content': 'center',
                                'font-size': '11px',
                                'border-radius': '2px',
                                'align-items': 'center'
                            });

                            deleteButton.css({
                                'border': 'none',
                                'color': 'white',
                                'max-width': '20px',
                                'max-height': '20px',
                                'display': 'flex',
                                'border-radius': '100%',
                                'justify-content': 'center',
                                'font-size': '11px',
                                'align-items': 'center'
                            });

                            // Add click event handlers to the buttons
                            minusButton.click(function() {
                                // Decrease the order number
                                var currentQuantity = parseInt(quantity.text());
                                if (currentQuantity >
                                    1) { // Prevent quantity from going below 1
                                    quantity.text(currentQuantity - 1);
                                }
                            });
                            plusButton.click(function() {
                                // Increase the order number
                                var currentQuantity = parseInt(quantity.text());
                                quantity.text(currentQuantity + 1);
                            });
                            deleteButton.click(function() {
                                /* Remove the order card */
                            });

                            // Add the order card to the "Current Order" container
                            $('#currentOrderContainer').append(orderCard);

                            // Add the item to the session
                            $.ajax({
                                url: '/add-to-session',
                                type: 'POST',
                                data: {
                                    product: item,
                                    _token: '{{ csrf_token() }}'
                                }
                            });
                        });

                        // Add the card to the container
                        $('#itemsContainer').append(card);
                    })(data[i]); // Pass the current item to the closure
                }
            });
        });

        $(document).ready(function() {
            $('#submitOrders').click(function() {
                var orders = [];
                $('#currentOrderContainer .card').each(function() {
                    var order = {
                        product_name: $(this).text().split("Price: ")[0].trim(),
                        price: parseFloat($(this).find('div:contains("Price:")').text().split(
                            "Price: ")[1]),
                        quantity: parseInt($(this).find('span bold').text()),
                        // Add other fields if necessary, e.g., code, category, description
                    };
                    orders.push(order);
                });

                // Send the orders to the server
                $.ajax({
                    url: '/save-orders',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        orders: orders
                    },
                    success: function(response) {
                        console.log(response.message); // Log the success message
                        // Clear the session data and redirect to the POS view
                        $.post('/clear-session', {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }, function(response) {
                            console.log(response.message); // Log the success message
                            window.location.href = '/pos';
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to save orders:', error);
                    }
                });
            });
        });
    </script>

</body>

</html>
