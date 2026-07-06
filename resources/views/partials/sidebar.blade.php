<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/admin/dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ $settings['company_name'] ?? __('settings.app_name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('menu.dashboard') }}</p>
                    </a>
                </li>

                <li class="nav-header text-uppercase">{{ __('menu.management') }}</li>

                <li class="nav-item">
                    <a href="{{ route('contacts.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{ __('menu.contacts') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/admin/timesheets') }}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>{{ __('menu.timesheets') }}</p>
                    </a>
                </li>

                <li class="nav-header text-uppercase">{{ __('menu.inventory') }}</li>

                <li class="nav-item">
                    <a href="{{ url('/admin/products') }}" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>{{ __('menu.products') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/admin/suppliers') }}" class="nav-link">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>{{ __('menu.suppliers') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/admin/purchases') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>{{ __('menu.purchases') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact_roles.index') }}" class="nav-link {{ request()->routeIs('contact_roles.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>{{ __('menu.contact_roles') }}</p>
                    </a>
                </li>

                <li class="nav-header text-uppercase">{{ __('menu.accounting') }}</li>

                <li class="nav-item">
                    <a href="{{ url('/admin/invoices') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>{{ __('menu.invoices') }}</p>
                    </a>
                </li>

                <li class="nav-header text-uppercase">{{ __('menu.settings') }}</li>

                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>{{ __('menu.settings') }}</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
