<nav class="navbar navbar-dark bg-dark shadow-sm fixed-top px-3">
    <div class="container-fluid d-flex align-items-center">

        <button id="sidebarToggle"
                class="btn me-2 d-flex align-items-center">
            ☰
        </button>

        <div class="d-flex align-items-center gap-2 flex-grow-1">
            {{-- <img src="{{ asset('images/logo.png') }}" width="100" height="50"> --}}
            <span class="text-white fw-bold fs-5 d-none d-sm-inline">
                Mirax Technologies
            </span>
        </div>

        <div class="dropdown">
            <a class="dropdown-toggle text-white text-decoration-none"
               href="#"
               data-bs-toggle="dropdown">
                <span class="d-none d-sm-inline">Welcome Admin</span>
                <i class="bi bi-person-circle fs-5 d-inline d-sm-none"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                {{-- <li>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li> --}}
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>
