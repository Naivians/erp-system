<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <span onclick="toggleSidebar()"><i class='bx bx-menu fs-3'></i></span>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if (Session::has('user'))
                    {{Session::get('user')->name}}
                @endif
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="">Profile</a></li>
              <li><a class="dropdown-item" href="{{route('Logins.logout')}}">Logout</a></li>
            </ul>
          </div>
    </div>
</nav>
