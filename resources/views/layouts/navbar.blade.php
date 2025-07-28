<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>

  </ul>

    <!-- Right navbar links -->

    <ul class="ml-auto navbar-nav">

        <li  class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                 {{ strtoupper(app()->getLocale()) }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">🇺🇸 English</a>
                <a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">🇪🇬 العربية</a>
            </div>
        </li>

        <li  class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                <i class="fas fa-th-large"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">###</a>
                <a class="dropdown-item" href="#">###</a>
                <hr>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="{{ route('logout') }}" class="btn dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        @lang('auth.logout')
                    </a>
                </form>
            </div>
        </li>

    </ul>

</nav>
