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
            <form action="{{ route('Admins.InventoryStore') }}" method="POST">
                @csrf
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
                            <input type="text" name="code" id="code" class="form-control" maxlength="10"
                                value="{{ $item->code }}">
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
                            <input type="text" name="description" id="description" class="form-control" maxlength="20"
                                value="{{ $item->description }}">
                        </div>

                        <div class="col-md-1">
                            <label for="" class="form-label">Price</label>
                            <input type="text" name="price" id="price" class="form-control" maxlength="10"
                                value="{{ $item->price }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>


                    </div>
                </div>
            </form>
        @else
        <h5>Stockout Form</h5>
            <div class="card mt-3 mb-4 p-2">
                <div class="row  d-flex align-items-center justify-content-between">

                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" id="product_code" class="form-control" autofocus
                                placeholder="search item code" aria-label="Username" aria-describedby="basic-addon1"
                                required autofocus>
                            <button class="btn btn-success" id="searchBtn"><i class='bx bx-search-alt-2'></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-secondary "></h5>
                        <button type="button" onclick="refreshPage()" class="float-end btn btn-outline-danger">
                            <i class='bx bx-refresh'></i>
                            refresh
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="table-responsive ">
            <form action="" method="post">
                @csrf

                <table class="table table-striped" id="searchTables">
                    <thead>
                        <tr>
                            <th class="bg-dark text-light">Code</th>
                            <th class="bg-dark text-light">Category</th>
                            <th class="bg-dark text-light">Produuct Name</th>
                            <th class="bg-dark text-light">Description</th>
                            <th class="bg-dark text-light">Price</th>
                            <th class="bg-dark text-light">Stocks</th>
                            <th class="bg-dark text-light">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="searchTableBody">

                    </tbody>
                </table>
        </div>

        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-success" onclick="saveStockouts()">Submit</button>
                <a href="{{route('Admins.InventoryStockoutList')}}" class="btn btn-danger">Back</a>
            </div>
        </div>
        </form>
    </div>
    </div>


@section('scripts')
    <script>
        function saveStockouts() {
            const formData = new FormData(document.querySelector("form"));

            const formDataObject = {};

            formData.forEach(function(value, key) {
                if (formDataObject.hasOwnProperty(key)) {
                    if (Array.isArray(formDataObject[key])) {
                        formDataObject[key].push(value);
                    } else {
                        formDataObject[key] = [formDataObject[key], value];
                    }
                } else {
                    formDataObject[key] = value;
                }
            });

            // console.log(formDataObject)

            $.ajax({
                url: "/stockout/saveForm",
                method: "POST",
                // dataType: 'json',
                data: formDataObject,
                success: function(res) {
                    console.log(res)

                    if (res.status === 200) {
                        window.location.href = res.url;
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: 'Stocks Error',
                            text: res.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                },
            });
        }
    </script>
@endsection


@endsection
