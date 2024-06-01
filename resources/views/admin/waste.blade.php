@extends('layout.dashboard_layout')

@section('dashboard')
    <div class="container-fluid">

        <div class="card mb-2">
            <div class="card-body">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-md-10 d-flex align-items-center ">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="" id="search" class="form-control"
                                    placeholder="Search anything here">
                                <button class="btn btn-secondary" disabled>
                                    <i class='bx bx-search-alt  fs-5'></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-7 d-flex align-items-center mx-2">
                            <div class="col-md-4">
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <span class="mx-3"> to </span>
                            <div class="col-md-4">
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                            <button class="btn btn-info mx-2" onclick="filterDate()">submit</button>
                            <a href="{{ route('Admins.Wastehome') }}" id="back" class="btn btn-danger">Exit</a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <h5 class="float-end">Waste List</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="oldTable">
                <thead>
                    <tr>

                        <th class="bg-dark text-light text-center align-middle">Move Date</th>
                        <th class="bg-dark text-light text-center align-middle">Code</th>
                        <th class="bg-dark text-light text-center align-middle">Category</th>
                        <th class="bg-dark text-light text-center align-middle">Product Name</th>
                        <th class="bg-dark text-light text-center align-middle">Description</th>
                        <th class="bg-dark text-light text-center align-middle">Price</th>
                        <th class="bg-dark text-light text-center align-middle">Beginning INV</th>
                        <th class="bg-dark text-light text-center align-middle">Initial Amount</th> {{-- 2 --}}
                        <th class="bg-dark text-light text-center align-middle">Stock In</th>
                        <th class="bg-dark text-light text-center align-middle">Stock Out</th>
                        <th class="bg-dark text-light text-center align-middle">Ending INV </th>
                        <th class="bg-dark text-light text-center align-middle">Total Amount </th>
                        <th class="bg-dark text-light text-center align-middle">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wastes as $waste)
                        <tr>
                            <td>{{ $waste->created_at }}</td>
                            <td class="text-center align-middle">{{ $waste->code }}</td>
                            <td class="text-center align-middle">{{ $waste->category }}</td>
                            <td class="text-center align-middle">{{ $waste->name }}</td>
                            <td class="text-center align-middle">{{ $waste->description }}</td>
                            <td class="text-center align-middle">{{ number_format($waste->price, 2) }}</td>
                            <td class="text-center align-middle">{{ $waste->beg_inv }}</td>
                            <td class="text-center align-middle">{{ number_format($waste->initial, 2) }}</td>
                            <td class="text-center align-middle">{{ number_format($waste->stockin, 2) }}</td>
                            <td class="text-center align-middle">{{ number_format($waste->stockout, 2) }}</td>
                            <td class="text-center align-middle">
                                @if ($waste->end_inv < 10)
                                    <span class="badge bg-danger">{{ $waste->end_inv }}</span>
                                @elseif ($waste->end_inv > 10 && $waste->end_inv < 20)
                                    <span class="badge bg-warning">{{ $waste->end_inv }}</span>
                                @else
                                    <span class="badge bg-success">{{ $waste->end_inv }}</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">{{ $waste->total_amount }}</td>
                            <td class="text-center align-middle">
                                @if ($waste->end_inv < 10)
                                    <span class="badge bg-danger">Order</span>
                                @elseif ($waste->end_inv > 10 && $waste->end_inv < 20)
                                    <span class="badge bg-warning">Running out of stocks</span>
                                @else
                                    <span class="badge bg-success">Good</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-center mt-5">
                {{ $wastes->links() }}
            </div>


            <table class="table table-striped" id="searchTable">
                <thead>
                    <tr>
                        <th class="bg-dark text-light">Move Date</th>
                        <th class="bg-dark text-light">Code</th>
                        <th class="bg-dark text-light">Category</th>
                        <th class="bg-dark text-light">Product Name</th>
                        <th class="bg-dark text-light">Description</th>
                        <th class="bg-dark text-light">Price</th>
                        <th class="bg-dark text-light">Beginning INV</th>
                        <th class="bg-dark text-light">Initial Amount</th>
                        <th class="bg-dark text-light">Stock In</th>
                        <th class="bg-dark text-light">Stock Out</th>
                        <th class="bg-dark text-light">Ending INV </th>
                        <th class="bg-dark text-light">Total Amount </th>
                        <th class="bg-dark text-light">Remarks</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                </tbody>

            </table>


        </div>
    </div>


@section('scripts')
    <script>
        $(document).ready(function() {
            var $table = $("#oldTable"); // Use jQuery to select the table element
            $("#searchTable").hide();
            $('#back').hide();

            $("#search").on("keyup", function() {
                var query = $(this).val().trim(); // Trim whitespace from the search query

                if (query !== "") {
                    $("#searchTable").show();
                    $table.hide();
                    $.ajax({
                        url: "/searchAll",
                        method: "GET",
                        data: {
                            query: query,
                            model: "Waste",
                        },
                        success: function(res) {
                            var results = "";

                            // Clear existing table content
                            $("#searchTable tbody").empty();

                            // Check if there are search results
                            if (res.length > 0) {
                                console.log(res);
                                // Iterate over each item in the res array and populate the table
                                $.each(res, function(index, item) {
                                    var itemId = item.id;
                                    // /admin/{id}/edit
                                    var editUrl = `/admin/${item.id}/edit`;
                                    var editLink =
                                        `<a href="${editUrl}" class="text-decoration-none text-dark"><i class='bx bx-edit btn btn-outline-primary'></i></a>`;

                                    var deleteUrl = `/stockin/${item.id}/destroy`;
                                    var deleteLink =
                                        `<span> <i class='bx bx-trash btn btn-outline-danger ' onclick="deleteInventory(${item.code})"> </span>`;

                                    var remarks = '';
                                    if (item.end_inv < 10) {
                                        remarks =
                                            '<span class="badge bg-danger">Order</span>'
                                    } else if ($item.end_inv > 10 && $item.end_inv >
                                        end_inv < 20) {
                                        remarks =
                                            '<span class="badge bg-warning">Running out of stocks</span>'
                                    } else {
                                        remarks =
                                            '<span class="badge bg-success">Good</span>'
                                    }

                                    var row =
                                        "<tr>" +
                                        "<td>" +
                                        formatDateTime(item.created_at) +
                                        "</td>" +
                                        "<td>" +
                                        item.code +
                                        "</td>" +
                                        "<td>" +
                                        item.category +
                                        "</td>" +
                                        "<td>" +
                                        item.name +
                                        "</td>" +
                                        "<td>" +
                                        item.description +
                                        "</td>" +
                                        "<td>" +
                                        item.price +
                                        "</td>" +
                                        "<td>" +
                                        item.beg_inv +
                                        "</td>" +
                                        "<td>" +
                                        item.initial +
                                        "</td>" +
                                        "<td>" +
                                        item.stockin +
                                        "</td>" +
                                        "<td>" +
                                        item.stockout +
                                        "</td>" +

                                        "<td>" +
                                        item.end_inv +
                                        "</td>" +

                                        "<td>" +
                                        item.total_amount +
                                        "</td>" +

                                        "<td>" +

                                        remarks +
                                        "</td>" +
                                        "</tr>";

                                    // Append the row to the table body
                                    $("#searchTable tbody").append(row);
                                });
                            } else {
                                // If there are no search results, display a message or handle it accordingly
                                $("#searchTable tbody").append(
                                    '<tr><td colspan="13" class="text-center text-danger">No results found</td></tr>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.error("Error searching:", error);
                            // Optionally, display an error message to the user
                        },
                    });
                } else {
                    // If the search query is empty, show the table
                    $table.show();
                    $("#searchTable").hide();
                }
            });
        });

        function deleteInventory(code) {
            Swal.fire({
                title: "Are you sure?",
                text: "All Data with this code from stockin, stockout and from this table will be deleted forever",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/deleteInventory/" + code,
                        method: "GET",
                        data: {
                            _token: csrfToken, // Include CSRF token as a parameter
                        },
                        success: (res) => {
                            if (res.status === 200) {
                                window.location.href = res.url;
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: res.message,
                                });
                            }

                            console.log(res);
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.error(xhr.responseText);
                        },
                    });
                }
            });
        }

        function formatDateTime(dateTime) {
            var options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            return new Date(dateTime).toLocaleDateString('en-GB', options);
        }



        function filterDate() {
            start = $('#start_date').val()
            end = $('#end_date').val()

            if (start == '' || end == '') {
                alert('date field is empty')
            } else {
                $.ajax({
                    url: '/searchDate',
                    method: 'GET',
                    data: {
                        start_date: start,
                        end_date: end,
                        model: 'Waste'
                    },
                    success: (res) => {
                        if (res.status != 200) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: res.message,
                            });
                        } else {
                            displayData(res.data, res.sum)
                        }
                    }
                });
            }
        }


        function displayData(products, sum) {
            $("#searchTable tbody").empty();
            var $table = $("#oldTable").hide();
            $("#searchTable").show();

            if (products.length > 0) {
                // document.getElementById('sum').innerText = 'Total Stocks: ' + sum
                $('#back').show();
                for (let i = 0; i < products.length; i++) {
                    var item = products[i];

                    if (item.end_inv < 10) {
                        remarks =
                            '<span class="badge bg-danger">Order</span>'
                    } else if (item.end_inv > 10 && item.end_inv >
                        end_inv < 20) {
                        remarks =
                            '<span class="badge bg-warning">Running out of stocks</span>'
                    } else {
                        remarks =
                            '<span class="badge bg-success">Good</span>'
                    }

                    var row =
                        "<tr>" +
                        "<td>" +
                        formatDateTime(item.created_at) +
                        "</td>" +
                        "<td>" +
                        item.code +
                        "</td>" +
                        "<td>" +
                        item.category +
                        "</td>" +
                        "<td>" +
                        item.name +
                        "</td>" +
                        "<td>" +
                        item.description +
                        "</td>" +
                        "<td>" +
                        item.price +
                        "</td>" +
                        "<td>" +

                        item.beg_inv +
                        "</td>" +
                        "<td>" +
                        item.initial +
                        "</td>" +
                        "<td>" +
                        item.stockin +
                        "</td>" +
                        "<td>" +
                        item.stockout +
                        "</td>" +

                        "<td>" +
                        item.end_inv +
                        "</td>" +

                        "<td>" +
                        item.total_amount +
                        "</td>" +

                        "<td>" +

                        remarks +
                        "</td>" +
                        "</tr>";

                    // Append the row to the table body
                    $("#searchTable tbody").append(row);
                }
            } else {
                $("#searchTable tbody").append(
                    '<tr><td colspan="10" class="text-center text-danger">No results found</td></tr>'
                );
            }
        }
    </script>
@endsection
@endsection
