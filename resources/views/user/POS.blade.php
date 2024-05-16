<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Point of Sale</title>
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
                    <div class="col-12 col-md-12 mt-5" style="background-color:rgb(223, 38, 69);">
                        <button id="foods" class="ms-5">Foods</button>
                        <button id="nonFoodItems" class="ms-5">Non-food Items</button>
                        <button id="miscellaneous" class="ms-5">Miscellaneous</button>
                        <button id="officeSupplies" class="ms-5">Office Supplies</button>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12" id="itemsContainer" style="background-color:rgb(91, 255, 76);">'
                        <h3>Items</h3>
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-4" style="background-color: pink;">
                <h3>Total</h3>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $('#foods').click(function() {
            loadItems('Foods');
        });

        $('#nonFoodItems').click(function() {
            loadItems('Non-food Items');
        });

        $('#miscellaneous').click(function() {
            loadItems('Miscellaneous');
        });

        $('#officeSupplies').click(function() {
            loadItems('Office Supplies');
        });

        function loadItems(category) {
            $.get('/pos/' + category, function(data) {
                // Clear the current items from the container
                $('#itemsContainer').empty();

                // Loop through the items returned from the server
                for (var i = 0; i < data.length; i++) {
                    // Create a new card for each item
                    var card = $('<div class="card">' + data[i].product_name + '</div>');

                    // // Add a click event handler to the card
                    // card.click(function() {
                    //     // When the card is clicked, add the item's price to the total
                    //     var price = parseFloat($(this).attr('data-price'));
                    //     var total = parseFloat($('#total').text());
                    //     $('#total').text(total + price);
                    // });

                    // Add the card to the container
                    $('#itemsContainer').append(card);
                }
            });
        }
    </script>
</body>

</html>
