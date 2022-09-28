<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo me-5" href="#">
            <samp style="color:rgb(255, 255, 255);font-family: Georgia, serif;">ERP</samp> <br> <samp
                style="color:rgba(255, 255, 255, 0.808);">{{ Auth::user()->name }}</samp></a>
        <a class="navbar-brand brand-logo-mini" href="#">
            <samp style="color:rgb(255, 255, 255);font-family: Georgia, serif;">ERP</samp></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize"><i
                class="fa-solid fa-bars"></i>
            <span class="ti-layout-grid2"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">

                    </div>

                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">
                <a style="color: red;" class="nav-link" href="#" data-bs-toggle="dropdown" id="profileDropdown"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="ti-power-off text-primary"><i class="fa-solid fa-power-off logoutcolor"></i></i> Log out
                    {{-- <samp class="profile" style="color:rgb(255, 255, 255);font-family: Georgia, serif;">ERP</samp> --}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                {{-- <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ti-power-off text-primary"><i class="fa-solid fa-power-off"></i></i> Log out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div> --}}
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="ti-layout-grid2"><i class="fa-solid fa-bars"></i></span>
        </button>
    </div>
</nav>
