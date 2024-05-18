@extends('layout.dashboard_layout')

@section('dashboard')
    <div class="d-flex align-items-center justify-content-between">
        <h3 class="mx-3 mt-3">Inventory Form</h3>
    </div>
    <div class="container-fluid">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="bg-dark text-light">code</th>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                        <tr>
                            <td>{{ $inventory->category }}</td>
                            <td>{{ $inventory->name }}</td>
                            <td>{{ $inventory->description }}</td>
                            <td>{{ $inventory->price }}</td>
                            <td>{{ $inventory->beg_inv }}</td>
                            <td>{{ $inventory->initial }}</td>
                            <td>{{ $inventory->stockin }}</td>
                            <td>{{ $inventory->stockout }}</td>
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
                            <td>
                                @if ($inventory->role == 1)
                                    <span>Admin</span>
                                @else
                                    <span>Cashier</span>
                                @endif
                            </td>
                            <td class="text-wrap">{{ $inventory->password }}</td>
                            <td>
                                <span>
                                    <a href="{{ route('Admins.edit', ['id' => $inventory->id]) }}"
                                        class="text-decoration-none text-dark">
                                        <i class='bx bx-edit btn btn-outline-primary'></i>
                                    </a>

                                </span>
                                <span onclick='deleteUser({{ $inventory->id }})'><i
                                        class='bx bx-trash btn btn-outline-danger'>
                                    </i></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-center mt-5">
                {{ $inventories->links() }}
            </div>
        </div>
    </div>
@endsection
