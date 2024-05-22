@extends('layout.dashboard_layout')

@section('dashboard')
    <div class="container-fluid">

        <div class="card mb-3">
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
                <form action="{{ route('Admins.InventoryUpdate') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mx-3 mt-3">Edit / Update Items</h5>
                            </div>
                            <div class="col-md-2 d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-success me-2">Update</button>
                                {{-- <a href="{{route('Admins.InventoryHome')}}" class="btn btn-danger" id="back">Back</a> --}}
                                <a href="{{ route('Admins.InventoryHome') }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-2">
                                <label for="" class="form-label">Code</label>
                                <input type="text" name="old_code" id="old_code" class="form-control" maxlength="10"
                                    value="{{ $item->code }}">
                                <input type="hidden" name="code" value="{{ $item->code }}">
                            </div>

                            <div class="col-md-2">
                                <label for="" class="form-label">Category</label>
                                <select name="category" id="category" class="form-select">
                                    <option selected value="{{ $item->category }}">{{ $item->category }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" maxlength="15"
                                    value="{{ $item->name }}">
                            </div>

                            <div class="col-md-3">
                                <label for="" class="form-label">Description</label>
                                <input type="text" name="description" id="description" class="form-control"
                                    maxlength="20" value="{{ $item->description }}">
                            </div>

                            <div class="col-md-1">
                                <label for="" class="form-label">Price</label>
                                <input type="text" name="price" id="price" class="form-control" maxlength="10"
                                    value="{{ $item->price }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>

                            <div class="col-md-1">
                                <label for="" class="form-label">Beginning</label>
                                <input type="text" name="beg_inv" id="beg_inv" class="form-control" maxlength="20"
                                    value="{{ $item->beg_inv }}">
                            </div>

                        </div>
                    </div>
                </form>
            @else
                <form action="{{ route('Admins.InventoryStore') }}" method="POST">
                    @csrf
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="" id="search" class="form-control"
                                        placeholder="Search anything here">
                                    <button class="btn btn-secondary" disabled>
                                        <i class='bx bx-search-alt  fs-5'></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-5 text-center">
                                <h5 class="mx-3 mt-3">Kumintang Checklist Inventory</h5>
                            </div>
                            <div class="dol-md-4">
                                <button type="submit" class="btn btn-success mx-3">Add new product</button>
                            </div>
                        </div>
                    </div>



                    <div class="card-body">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-2">
                                <label for="" class="form-label">Code</label>
                                <input type="text" name="code" id="code" class="form-control" maxlength="10"
                                    placeholder="ITM-CHKN">
                            </div>

                            <div class="col-md-2">
                                <label for="" class="form-label">Category</label>
                                <select name="category" id="category" class="form-select">
                                    <option selected></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Chicken">
                            </div>

                            <div class="col-md-3">
                                <label for="" class="form-label">Description</label>
                                <input type="text" name="description" id="description" class="form-control"
                                    maxlength="20" placeholder="unit or size">
                            </div>

                            <div class="col-md-1">
                                <label for="" class="form-label">Price</label>
                                <input type="text" name="price" id="price" class="form-control" maxlength="10"
                                    placeholder="200.00"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>

                            <div class="col-md-1">
                                <label for="" class="form-label">Beginning</label>
                                <input type="text" name="beg_inv" id="beg_inv" class="form-control" maxlength="20"
                                    placeholder="1">
                            </div>

                        </div>
                    </div>
                </form>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="oldTable">
                <thead>
                    <tr>

                        <th class="bg-dark text-light">Code</th> {{-- 1 --}}
                        <th class="bg-dark text-light">Category</th> {{-- 2 --}}
                        <th class="bg-dark text-light">Produuct Name</th> {{-- 2 --}}
                        <th class="bg-dark text-light">Description</th> {{-- 2 --}}
                        <th class="bg-dark text-light">Price</th> {{-- 1 --}}
                        <th class="bg-dark text-light">Beginning INV</th> {{-- 2 --}}
                        <th class="bg-dark text-light">Initial Amount</th> {{-- 2 --}}
                        <th class="bg-dark text-light">Stock In</th>
                        <th class="bg-dark text-light">Stock Out</th>
                        <th class="bg-dark text-light">Ending INV </th>
                        <th class="bg-dark text-light">Total Amount </th>
                        <th class="bg-dark text-light">Remarks</th>
                        <th class="bg-dark text-light">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                        <tr>
                            <td>{{ $inventory->code }}</td>
                            <td>{{ $inventory->category }}</td>
                            <td>{{ $inventory->name }}</td>
                            <td>{{ $inventory->description }}</td>
                            <td>{{ number_format($inventory->price, 2) }}</td>
                            <td>{{ $inventory->beg_inv }}</td>
                            <td>{{ number_format($inventory->initial, 2) }}</td>
                            <td>{{ number_format($inventory->stockin, 2) }}</td>
                            <td>{{ number_format($inventory->stockout, 2) }}</td>
                            <td>
                                @if ($inventory->end_inv < 10)
                                    <span class="badge bg-danger">{{ $inventory->end_inv }}</span>
                                @elseif ($inventory->end_inv > 10 && $inventory->end_inv < 20)
                                    <span class="badge bg-warning">{{ $inventory->end_inv }}</span>
                                @else
                                    <span class="badge bg-success">{{ $inventory->end_inv }}</span>
                                @endif
                            </td>
                            <td>{{ $inventory->total }}</td>
                            <td></td>
                            <td>
                                <span>
                                    <a href="{{ route('Admins.InventoryEdit', ['id' => $inventory->id]) }}"
                                        class="text-decoration-none text-dark">
                                        <i class='bx bx-edit btn btn-outline-primary'></i>
                                    </a>
                                </span>

                                <span>
                                    {{-- <a href="{{ route('Admins.InventoryDestroy', ['id' => $inventory->id]) }}"
                                        class="text-decoration-none text-dark">
                                        <i class='bx bx-trash btn btn-outline-danger'></i>
                                    </a> --}}

                                    <i class='bx bx-trash btn btn-outline-danger'
                                        onclick='deleteInventory("{{ $inventory->code }}")'></i>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-center mt-5">
                {{ $inventories->links() }}
            </div>


            <table class="table table-striped" id="searchTable">
                <thead>
                    <tr>
                        <th class="bg-dark text-light">Code</th>
                        <th class="bg-dark text-light">Category</th>
                        <th class="bg-dark text-light">Produuct Name</th>
                        <th class="bg-dark text-light">Description</th>
                        <th class="bg-dark text-light">Price</th>
                        <th class="bg-dark text-light">Beginning INV</th>
                        <th class="bg-dark text-light">Initial Amount</th>
                        <th class="bg-dark text-light">Stock In</th>
                        <th class="bg-dark text-light">Stock Out</th>
                        <th class="bg-dark text-light">Ending INV </th>
                        <th class="bg-dark text-light">Total Amount </th>
                        <th class="bg-dark text-light">Remarks</th>
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
                            model: "Inventory",
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

                                    var row =
                                        "<tr>" +
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
                                        item.remarks +
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

        function formatTotalAmounts(amounts) {
            // Format each amount to two decimal places
            return amounts.map(amount => amount.toFixed(2)).join('\t'); // Use '\t' for tab separation
        }
    </script>
@endsection
@endsection
