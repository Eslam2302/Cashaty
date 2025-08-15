<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="text-center brand-link" style="font-weight:bold ; font-size:26px ; ">
    <i class="nav-icon fas fa-cash-register"></i>
    <span class=" brand brand-text font-weight-light">Cashaty</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column">
        <li class="nav-item">

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>@lang('dashboard.dashboard')</p>
            </a>

            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-table"></i>
                <p>@lang('categories.categories')</p>
            </a>

            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-box"></i>
                <p>@lang('products.products')</p>
            </a>

            @can('create order')
                <a href="{{ route('orders.create') }}" class="nav-link {{ request()->routeIs('orders.create') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>@lang('orders.open_pos')</p>
                </a>
            @endcan

            @can('view orders')
                 <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-invoice"></i>
                    <p>@lang('orders.orders')</p>
                </a>
            @endcan

            @can('view customers')
                <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>@lang('customers.customers')</p>
                </a>
            @endcan

            @can('view stock')
                <a href="{{ route('stockTransactions.index') }}" class="nav-link {{ request()->routeIs('stockTransactions.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <p>@lang('stockTransactions.stockTransactions')</p>
                </a>
            @endcan

            @can('view users')
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>@lang('users.users')</p>
                </a>
            @endcan

            @can('view logs')
                <a href="{{ route('activityLogs.index') }}" class="nav-link {{ request()->routeIs('activityLogs.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-history"></i>
                    <p>@lang('activityLogs.activityLogs')</p>
                </a>
            @endcan

        </li>
      </ul>
    </nav>
  </div>
</aside>
