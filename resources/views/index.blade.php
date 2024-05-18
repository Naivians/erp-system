<!DOCTYPE html>
<html lang="en">
@include('includes.head')

<body>

    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="card" style="width: 30rem;">
            <div class="card-body">
                <h1 class="text-center text-dark mt-3">Login Here</h1>

                <form action="{{ route('Logins.auth') }}" method="post" class="p-4">
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label text-secondary">Username</label>
                        <input type="text" name="username" id="username" class="form-control" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label text-secondary  ">Password</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('includes.bsjs')
</body>

</html>
