<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="navbar-nav flex-row order-md-last">
      
      <div class="nav-item dropdown me-2">
    <a class="nav-link" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="ti ti-palette"></i>
        </span>
        <span class="nav-link-title d-md-none d-lg-inline-block">
            Tema
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-end p-2">
        <div class="row g-2" style="width: 300px;">
            
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#206bc4')">
                    <span class="badge bg-blue text-blue-fg w-100 py-2">Blue Purple</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#4299e1')">
                    <span class="badge bg-azure text-azure-fg w-100 py-2">Azure Purple</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#4263eb')">
                    <span class="badge bg-indigo text-indigo-fg w-100 py-2">Mint Pink</span>
                </button>
            </div>

            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#ae3ec9')">
                    <span class="badge bg-purple text-purple-fg w-100 py-2">Pink Sunset</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#d6336c')">
                    <span class="badge bg-pink text-pink-fg w-100 py-2">Peach Aqua</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#d63939')">
                    <span class="badge bg-red text-red-fg w-100 py-2">Coral Pink</span>
                </button>
            </div>

            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#f76707')">
                    <span class="badge bg-orange text-orange-fg w-100 py-2">Orange Cream</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#f59f00')">
                    <span class="badge bg-yellow text-yellow-fg w-100 py-2">Golden Blue</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#74b816')">
                    <span class="badge bg-lime text-lime-fg w-100 py-2">Lime Sky</span>
                </button>
            </div>

            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#2fb344')">
                    <span class="badge bg-green text-green-fg w-100 py-2">Mint Blue</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#0ca678')">
                    <span class="badge bg-teal text-teal-fg w-100 py-2">Sky Pink</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn p-0 border-0 w-100" onclick="window.userClickedColor = true; updateColor('#17a2b8')">
                    <span class="badge bg-cyan text-cyan-fg w-100 py-2">Cyan Purple</span>
                </button>
            </div>

        </div>
    </div>
</div>
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm" style="background-image: url('https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}')"></span>
          <div class="d-none d-xl-block ps-2">
            <div>{{ Auth::user()->name ?? 'Guest' }}</div>
            <div class="mt-1 small text-secondary">Administrator</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="#" class="dropdown-item">
            <i class="ti ti-user me-2"></i>Profile
          </a>
          <a href="#" class="dropdown-item">
            <i class="ti ti-settings me-2"></i>Settings
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); confirmLogout();">
            <i class="ti ti-logout me-2"></i>Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </div>
    
    <div class="collapse navbar-collapse" id="navbar-menu">
      </div>
  </div>
</header>