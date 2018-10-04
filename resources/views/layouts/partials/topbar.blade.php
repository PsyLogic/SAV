<nav class="navbar navbar-expand navbar-dark bg-primary row">
    <a class="sidebar-toggle pl-2" href="#" style="padding-left:5px;"><i class="fa fa-bars"></i></a>
    <a class="col-4 navbar-brand" href="#">Issue Center</a>
    <a class="col nav-item text-center text-white" href="#">
        <img src="{{ asset('images/logo_stg_telecom_white.png') }}" class="img-fluid" style="width: 40px;" alt="">
    </a>

    <div class="col-4 navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            @auth
            {{-- <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-bell"></i> 3</a></li> --}}
            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name ?? 'none' }}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
            @endauth
            @guest
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            @endguest
        </ul>
    </div>
</nav>