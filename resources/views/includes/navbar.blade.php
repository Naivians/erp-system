<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <span onclick="toggleSidebar()"><i class='bx bx-menu fs-3 text-danger'></i></span>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if (Session::has('user'))
                    {{Session::get('user')->name}}
                @endif
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item d-flex align-items-center" href="">
                <i class='bx bxs-user-rectangle fs-4 text-danger me-2'></i>
                Profile</a></li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="{{route('Logins.logout')}}">
                <i class='bx bx-log-out fs-4 text-danger me-2'></i>
                Logout</a></li>
            </ul>
          </div>
    </div>
</nav>
