<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a
        href="{{ url('/') }}"
        class="brand-link"
    >
        <img
            src="{{ url('/themes') }}/img/AdminLTELogo.png"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8"
        >
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{ url('/themes') }}/img/user2-160x160.jpg"
                    class="img-circle elevation-2"
                    alt="User Image"
                >
            </div>
            <div class="info">
                <a
                    href="#"
                    class="d-block"
                >Alexander Pierce</a>
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
                <x-nav-item
                    path="{{ route('users.index') }}"
                    groupPath="users"
                >
                    <i class="nav-icon fas fa-users"></i>
                    <p>Users Management</p>
                </x-nav-item>
                <li class="nav-header"></li>
                <li class="nav-item">
                    <form
                        action="{{ route('auth.login.destroy') }}"
                        method="POST"
                        style="display: none;"
                    >
                        @csrf
                        @method('DELETE')
                        <input
                            type="submit"
                            id="signout"
                        >
                    </form>
                    <a
                        href="#"
                        class="nav-link text-danger"
                        onclick="document.getElementById('signout').click()"
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
