
<aside class="main-sidebar sidebar-dark-navy elevation-4" style="height: 100vh">

    <!-- System title and logo -->
    {{-- <a href="{{ route('dashboard') }}" class="brand-link"> --}}
    <a href="" class="brand-link text-center">
        {{-- <img src="{{ asset('public/images/pricon_logo2.png') }}" --}}
        <img src=""
            class="brand-image img-circle elevation-3"
            style="opacity: .8">

        <span class="brand-text font-weight-light font-size"><h5>iShare</h5></span>
    </a> <!-- System title and logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header font-weight-bold">&nbsp;MAIN</li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header font-weight-bold">&nbsp;USER MANAGEMENT</li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-header font-weight-bold">&nbsp;GROUP MANAGEMENT</li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <p>Group</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <p>Title</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div><!-- Sidebar -->
</aside>