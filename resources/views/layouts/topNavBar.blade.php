<nav class="navbar navbar-expand-md navbar-light shadow-sm nav-bar-color">
    @guest
    @else
    <button type="button" id="sidebarCollapse" class="btn mr-3">
        <i class="fa fa-bars fa-lg"></i>
    </button>
    @endguest
    <div class="container">
        @guest
        <a href="" class="logo mr-auto"><img src="{{ asset('img/logo-s.svg') }}" alt="" class="guest-logo"></a>
        @endguest
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('hospitals.index') }}">Hospitals</a>
                </li>
                --}}
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle nav-bar-hospital-position" href="#"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->first_name }} <span class="caret pr-2"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('password.reset', ['token' => Str::random(30)]) }}">
                            Change Password
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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