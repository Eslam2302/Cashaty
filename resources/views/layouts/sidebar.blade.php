<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
    <i class="nav-icon fas fa-cash-register"></i>
    <span class="brand brand-text font-weight-light">Cashaty</span>
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
            <a href="{{ route('orders.create') }}" class="nav-link {{ request()->routeIs('orders.create') ? 'active' : '' }}">
                <i class="nav-icon fas fa-box"></i>
                <p>@lang('orders.open_pos')</p>
            </a>
            <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>@lang('customers.customers')</p>
            </a>
            <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>@lang('orders.orders')</p>
            </a>
            <a href="{{ route('stockTransactions.index') }}" class="nav-link {{ request()->routeIs('stockTransactions.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>@lang('stockTransactions.stockTransactions')</p>
            </a>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>@lang('users.users')</p>
            </a>
            <a href="{{ route('activityLogs.index') }}" class="nav-link {{ request()->routeIs('activityLogs.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>@lang('activityLogs.activityLogs')</p>
            </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
