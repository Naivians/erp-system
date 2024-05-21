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

        <div class="card mb-2">
            <div class="card-body">
                <h5>Stockin List</h5>
            </div>
        </div>

        <div class="table-responsive ">
            <table class="table table-striped" id="searchTables">
                <thead>
                    <tr>
                        <th class="bg-dark text-light">Date Added</th>
                        <th class="bg-dark text-light">Code</th>
                        <th class="bg-dark text-light">Category</th>
                        <th class="bg-dark text-light">Produuct Name</th>
                        <th class="bg-dark text-light">Description</th>
                        <th class="bg-dark text-light">Price</th>
                        <th class="bg-dark text-light">Beg_INV</th>
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
                            <td>{{ $stock->price }}</td>
                            <td>{{ $stock->beg_inv }}</td>
                            <td>{{ $stock->stocks }}</td>
                            <td>{{ $stock->total_amount }}</td>
                            <td>
                                <span>
                                    <a href="{{ route('Admins.InventoryEdit', ['id' => $stock->id]) }}"
                                        class="text-decoration-none text-dark">
                                        <i class='bx bx-edit btn btn-outline-primary'></i>
                                    </a>
                                </span>

                                <span>
                                    <a href="{{ route('Admins.InventoryDestroy', ['id' => $stock->id]) }}"
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
        </div>

    </div>
    </div>
@endsection
