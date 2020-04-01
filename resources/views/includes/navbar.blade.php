<nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Travel Request') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @if(Auth::check())
                <li class="nav-item {{ (request()->is('dashboard*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a>
                </li>

                @if(Auth::user()->role_id === 3)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('request-booking') }}"><i class="fas fa-hand-point-up"></i>&nbsp;Book Now</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('my-bookings') }}"><i class="fas fa-passport"></i>&nbsp;My Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-calendar-alt"></i>&nbsp;Schedules</a>
                </li>
                @endif

                @if(Auth::user()->role_id === 4)
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-passport"></i>&nbsp;Assigned Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-bus"></i>&nbsp;Assigned Vehicles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-calendar-alt"></i>&nbsp;Schedules</a>
                </li>
                @endif

                @if(Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                <!-- Admin Links -->
                <!-- @if(Auth::user()->role_id === 2)
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-passport"></i>&nbsp;Approve Bookings</a>
                </li>
                @endif
                @if(Auth::user()->role_id === 1)
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-passport"></i>&nbsp;Assign Bookings</a>
                </li>
                @endif -->
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-passport"></i>&nbsp;Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-chart-bar"></i>&nbsp;Reports</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="vehicles-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-truck"></i>&nbsp;Vehicles
                    </a>
                    <div class="dropdown-menu" aria-labelledby="vehicles-link">
                        <a class="dropdown-item" href="{{ url('/vehicle/list') }}">Vehicles List</a>
                        <a class="dropdown-item" href="{{ url('/vehicle/create') }}">Add New Vehicle</a>
                    </div>
                </li>
                <li class="nav-item dropdown  {{ (request()->is('user*')) ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="users-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users"></i>&nbsp;Users
                    </a>
                    <div class="dropdown-menu" aria-labelledby="users-link">
                        <a class="dropdown-item" href="{{ url('/user/list') }}">User List</a>
                        <a class="dropdown-item" href="{{ url('/user/create') }}">Add New User</a>
                    </div>
                </li>
                @endif

                @endif
            </ul>

                   
            <form class="d-flex">
              <input id="search-booking-input" class="form-control form-control-sm mr-sm-2" type="search" placeholder="Search/Enter booking number" aria-label="Search">
              <button class="btn btn-sm btn-info text-white" type="button"><i class="fas fa-search fa-lg"></i></button>
            </form>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav border-left border-white ml-3">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item ml-2">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown ml-2">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-user-circle fa-2x"></i>
                            <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <h6 class="dropdown-header font-weight-bold mb-3">Hi {{ Auth::user()->name }}!</h6>
                            <a class="dropdown-item" href="{{ url('/profile/'.Session::get('user.profile_name')) }}"><i class="fas fa-user"></i>&nbsp;Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i>&nbsp;
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@if(Auth::check())
<nav id="breadcrumb" aria-label="breadcrumb border-bottom">
    <div class="container p-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fas fa-home fa-lg"></i>&nbsp;
                <a href="{{ url('/') }}">Home</a>
            </li>
            @if(isset($pageData['breadcrumb']))
            @foreach($pageData['breadcrumb'] as $breadcrumb)
            <li class="breadcrumb-item {{ @$breadcrumb['class'] }}">
                @if($breadcrumb['link'] !== '')
                @if($breadcrumb['icon'] !== '')<i class="{{ $breadcrumb['icon'] }}"></i>&nbsp;@endif
                <a href="{{ @$breadcrumb['link'] }}">{{ $breadcrumb['name'] }}</a>
                @else
                {{ $breadcrumb['name'] }}
                @endif
            </li>
            @endforeach
            @endif
        </ol>
    </div>
</nav>
@endif