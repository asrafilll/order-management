<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a
        href="{{ url('/') }}"
        class="brand-link"
    >
        <img
            src="{{ url('/themes') }}/img/logo.png"
            alt="{{ Config::get('app.name') }}"
            class="brand-image img-circle elevation-3"
            style="opacity: .8"
        >
        <span class="brand-text font-weight-light">{{ Config::get('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{ url('/themes') }}/img/user-160x160.jpg"
                    class="img-circle"
                    alt="{{ Auth::user()->name }}"
                >
            </div>
            <div class="info">
                <a
                    href="#"
                    class="d-block"
                >{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul
                class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false"
            >
                @foreach (Config::get('menu') as $menu)
                    @if (!isset($menu['can']) || Auth::user()->can($menu['can']))
                        <x-nav-item
                            path="{{ route($menu['route_name']) }}"
                            groupPath="{{ $menu['group_name'] }}"
                        >
                            <i class="nav-icon {{ $menu['icon'] }}"></i>
                            <p>{{ $menu['name'] }}</p>
                        </x-nav-item>
                    @endif
                @endforeach
                <li class="nav-header"></li>
                <li class="nav-item">
                    <a
                        href="#"
                        class="nav-link text-danger"
                        data-toggle="modal"
                        data-target="#signout"
                    >
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>{{ __('Sign Out') }}</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
