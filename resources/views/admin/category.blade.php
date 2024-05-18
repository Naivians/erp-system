@extends('layout.dashboard_layout')

@section('dashboard')
    <h1 class="mx-3 mt-3">Product Category</h1>
    {{-- table  --}}

    {{-- add users --}}
    <div class="container-fluid">

        <div class="card my-3">
            <div class="card-body">
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
                    <form action="{{ route('Admins.updateCategory') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="hidden" name="category_id" value="{{$category->id}}">
                                    <label for="" class="form-label text-secondary">Category</label>
                                    <input type="text" name="category" id="category" class="form-control" value="{{$category->category}}" required>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex align-items-center ">
                            <button type="submit" class="btn btn-success mt-3">Update</button>
                            <a href="{{ route('Admin.category') }}" class="btn btn-danger mx-2 mt-3">Back</a>
                            </div>
                        </div>
                    </form>
                @else
                    <form action="{{ route('Admins.storeCategory') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Category</label>
                                    <input type="text" name="category" id="category" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex align-items-center ">
                                <button type="submit" class="btn btn-success mt-3">Add Category</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="bg-dark text-light">Category ID</th>
                        <th class="bg-dark text-light">Category</th>
                        <th class="bg-dark text-light">Date Added</th>
                        <th class="bg-dark text-light">Date Updated</th>
                        <th class="bg-dark text-light">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <span>
                                    {{--  --}}
                                    <a href="{{ route('Admins.editCategory', ['id' => $category->id]) }}" class="text-decoration-none text-dark">
                                        <i class='bx bx-edit btn btn-outline-primary'></i>
                                    </a>

                                </span>
                                <span onclick='deleteCategory({{ $category->id }})'><i
                                        class='bx bx-trash btn btn-outline-danger'>
                                    </i>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex align-items-center justify-content-center mt-5">
                {{$categories->links()}}
            </div>
        </div>
    </div>
@endsection
