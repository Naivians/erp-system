@extends('layout.dashboard_layout')

@section('dashboard')
    <h1 class="mx-3 mt-3">Accounts</h1>
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
                    <form action="{{ route('Admins.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="name" value="{{ $editUser->name }}" required>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{$editUser->id}}">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Username</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        placeholder="username" required value="{{ $editUser->username }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Password</label>
                                    <input type="text" name="password" id="password" class="form-control"
                                        placeholder="Enter new password">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">User Role</label>
                                    <select name="role" id="role" class="form-control">
                                        @if ($editUser->role == 1)
                                            <option value="1" selected>Admin</option>
                                        @else
                                            <option value="0" selected>Cashier</option>
                                        @endif
                                        <option value="0">Cashier</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex align-items-center ">
                                <button type="submit" class="btn btn-success mt-3">Update Account</button>
                                <a href="{{ route('Admins.user') }}" class="btn btn-danger mx-2 mt-3">Back</a>
                            </div>
                        </div>
                    </form>
                @else
                    <form action="{{ route('Admins.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                         required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Username</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                         required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                         required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Confirm Password</label>
                                    <input type="password" name="confirmPass" id="confirmPass" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary">Role</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="0" selected>Cashier</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 d-flex align-items-center ">
                                <button type="submit" class="btn btn-success mt-3">Add Account</button>
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
                        <th class="bg-dark text-light">Name</th>
                        <th class="bg-dark text-light">Username</th>
                        <th class="bg-dark text-light">Role</th>
                        <th class="bg-dark text-light">Password</th>
                        <th class="bg-dark text-light">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                @if ($user->role == 1)
                                    <span>Admin</span>
                                @else
                                <span>Cashier</span>
                                @endif
                            </td>
                            <td class="text-wrap">{{ $user->password }}</td>
                            <td>
                                <span>
                                    <a href="{{ route('Admins.edit', ['id' => $user->id]) }}"
                                        class="text-decoration-none text-dark">
                                        <i class='bx bx-edit btn btn-outline-primary'></i>
                                    </a>

                                </span>
                                <span onclick='deleteUser({{ $user->id }})'><i
                                        class='bx bx-trash btn btn-outline-danger'>
                                    </i></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-center mt-5">
                {{$users->links()}}
            </div>
        </div>
    </div>
@endsection
