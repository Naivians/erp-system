@extends('layout.dashboard_layout')

@section('dashboard')
    <div class="container-fluid">
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error: </strong> {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success: </strong> {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @if (Session::has('warning'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success: </strong> {{ Session::get('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @if ($edited ?? false)
            <div class="card">
                <form action="{{ route('Admins.InventoryStockinsUpdate') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mx-3 mt-3">Edit / Update Stocks</h5>
                            </div>
                            <div class="col-md-2 d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-success me-2">Update</button>
                                {{-- <a href="{{route('Admins.InventoryHome')}}" class="btn btn-danger" id="back">Back</a> --}}
                                <a href="{{ route('Admins.InventoryStockList') }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="price" value="{{ $item->price }}">
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-2">
                                <label for="" class="form-label">Product Code</label>
                                <input type="text" name="code" id="code" class="form-control" maxlength="20"
                                    value="{{ $item->code }}" disabled>
                            </div>

                            <div class="col-md-2">
                                <label for="" class="form-label">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" maxlength="20"
                                    value="{{ $item->name }}" disabled>
                            </div>

                            <div class="col-md-1">
                                <label for="" class="form-label">Stocks</label>
                                <input type="text" name="stocks" id="stocks" class="form-control" maxlength="20"
                                    value="{{ $item->stocks }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="" id="search" class="form-control"
                                    placeholder="Search anything here">
                                <button class="btn btn-secondary" disabled>
                                    <i class='bx bx-search-alt  fs-5'></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h5 class="float-end">Stockin List</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped" id="oldTable">
                <thead>
                    <tr>
                        <th class="bg-dark text-light">Date Added</th>
                        <th class="bg-dark text-light">Code</th>
                        <th class="bg-dark text-light">Category</th>
                        <th class="bg-dark text-light">Produuct Name</th>
                        <th class="bg-dark text-light">Description</th>
                        <th class="bg-dark text-light">Price</th>
                        <th class="bg-dark text-light">Stocks</th>
                        <th class="bg-dark text-light">total Amount</th>
                        <th class="bg-dark text-light">Actions</th>
                    </tr>
                </thead>
                <tbody id="searchTableBody">
                    @foreach ($stockins as $stock)
                        <tr>
                            <td>{{ $stock->created_at }}</td>
                            <td>{{ $stock->code }}</td>
                            <td>{{ $stock->category }}</td>
                            <td>{{ $stock->name }}</td>
                            <td>{{ $stock->description }}</td>
                            <td>{{ number_format($stock->price, 2) }}</td>
                            <td>{{ number_format($stock->stocks, 2) }}</td>
                            <td>{{ number_format($stock->total_amount, 2) }}</td>
                            <td>
                                <span>
                                    <a href="{{ route('Admins.StockinsEdit', ['id' => $stock->id]) }}"
                                        class="text-decoration-none text-dark">
                                        <i class='bx bx-edit btn btn-outline-primary'></i>
                                    </a>
                                </span>

                                <span>
                                    <a href="{{ route('Admins.StockinsDestroy', ['id' => $stock->id]) }}"
                                        class="text-decoration-none text-dark">
                                        <i class='bx bx-trash btn btn-outline-danger'></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex align-items-center justify-content-center mt-5">
                {{ $stockins->links() }}
            </div>


            <table class="table table-striped" id="searchTable">
                <thead>
                    <tr>
                        <th class="bg-dark text-light">Date Added</th>
                        <th class="bg-dark text-light">Code</th>
                        <th class="bg-dark text-light">Category</th>
                        <th class="bg-dark text-light">Produuct Name</th>
                        <th class="bg-dark text-light">Description</th>
                        <th class="bg-dark text-light">Price</th>
                        <th class="bg-dark text-light">Stocks</th>
                        <th class="bg-dark text-light">total Amount</th>
                        <th class="bg-dark text-light">Actions</th>
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
                        <td>
                        </td>
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
                            model: "Stockin",
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

                                    var editUrl = `/stockin/${item.id}/edit`;
                                    var editLink =
                                        `<a href="${editUrl}" class="text-decoration-none text-dark"><i class='bx bx-edit btn btn-outline-primary'></i></a>`;

                                    var deleteUrl = `/stockin/${item.id}/destroy`;
                                    var deleteLink =
                                        `<a href="${deleteUrl}" class="text-decoration-none text-dark"><i class='bx bx-trash btn btn-outline-danger'></a>`;

                                    // <a href="{{ route('Admins.StockinsDestroy', ['id' => $stock->id]) }}"
                                    //             class="text-decoration-none text-dark">
                                    //             <i class='bx bx-trash btn btn-outline-danger'></i>
                                    //         </a>

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
                                        item.stocks +
                                        "</td>" +
                                        "<td>" +
                                        item.total_amount +
                                        "</td>" +
                                        "<td>" +
                                        editLink +
                                        deleteLink +
                                        "</td>" +
                                        "</tr>";

                                    // Append the row to the table body
                                    $("#searchTable tbody").append(row);
                                });
                            } else {
                                // If there are no search results, display a message or handle it accordingly
                                $("#searchTable tbody").append(
                                    '<tr><td colspan="10" class="text-center text-danger">No results found</td></tr>'
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

        function formatDateTime(dateTimeString) {
            // Create a new Date object from the ISO string
            const date = new Date(dateTimeString);

            // Extract date and time components
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, "0");
            const day = String(date.getDate()).padStart(2, "0");
            const hours = String(date.getHours()).padStart(2, "0");
            const minutes = String(date.getMinutes()).padStart(2, "0");
            const seconds = String(date.getSeconds()).padStart(2, "0");

            // Construct the formatted date-time string
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
    </script>
@endsection
@endsection
