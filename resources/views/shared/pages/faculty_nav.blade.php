
<aside class="main-sidebar sidebar-dark-navy elevation-4" style="height: 100vh">

    <!-- System title and logo -->
    {{-- <a href="{{ route('dashboard') }}" class="brand-link"> --}}
    <a href="" class="brand-link text-center">
        {{-- <img src="{{ asset('public/images/pricon_logo2.png') }}" --}}
        <img src=""
            class="brand-image img-circle elevation-3"
            style="opacity: .8">

        {{-- <span class="brand-text font-weight-light font-size"><h5>iShare</h5></span> --}}
        <img src="{{ asset('/images/img/ishare_black.png') }}" style="width: 100px" alt="">
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
                <li class="nav-header font-weight-bold">&nbsp;RESEARCH</li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('library') }}" class="nav-link">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <p>Library</p>
                    </a>
                </li>
                
                <li class="nav-header font-weight-bold">&nbsp;COORDINATOR</li>
                {{-- <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <p>Section</p>
                    </a>
                </li> --}}
                <li class="nav-item has-treeview">
                    <a href="{{ route('topics') }}" class="nav-link">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <p>Topics/Titles</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div><!-- Sidebar -->
</aside>