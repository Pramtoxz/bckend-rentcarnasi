<aside class="navbar navbar-vertical navbar-expand-lg" >
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('dashboard') }}">
                Rent Car Nasi
            </a>
        </h1>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-home fs-2"></i>
                        </span>
                        <span class="nav-link-title">
                            Home
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer-verification.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-user-check fs-2"></i>
                        </span>
                        <span class="nav-link-title">
                            Verifikasi Customer
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); confirmLogout();">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-logout fs-2"></i>
                        </span>
                        <span class="nav-link-title">
                            Logout
                        </span>
                    </a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </ul>
        </div>
    </div>
</aside>