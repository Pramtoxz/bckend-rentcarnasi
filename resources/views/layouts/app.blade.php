<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>@yield('title', 'Dashboard')</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />
    
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
      :root { 
          --tblr-font-sans-serif: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; 
      }
      
      * {
          font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
      }
      body {
          --tblr-primary: var(--custom-primary-color, #0054a6);
          --tblr-btn-color: #ffffff;
          transition: background-color 0.3s ease;
      }
      
      /* Beautiful 3-Color Gradient Backgrounds */
      .navbar-vertical {
          background: linear-gradient(180deg, 
              var(--gradient-start, #4facfe) 0%, 
              var(--gradient-mid, #667eea) 50%, 
              var(--gradient-end, #f093fb) 100%) !important;
          box-shadow: 2px 0 30px rgba(0,0,0,0.15) !important;
          border: none !important;
          border-right: none !important;
          transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      }
      
      header.navbar {
          background: linear-gradient(135deg, 
              var(--gradient-start, #4facfe) 0%, 
              var(--gradient-mid, #667eea) 50%, 
              var(--gradient-end, #f093fb) 100%) !important;
          box-shadow: 0 4px 30px rgba(0,0,0,0.15) !important;
          border: none !important;
          border-bottom: none !important;
          transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      }
      
      /* Dark Mode with Beautiful 3-Color Gradients */
      [data-bs-theme="dark"] .navbar-vertical {
          background: linear-gradient(180deg, 
              var(--gradient-start, #4facfe) 0%, 
              var(--gradient-mid, #667eea) 50%, 
              var(--gradient-end, #f093fb) 100%) !important;
          opacity: 0.95;
          box-shadow: 2px 0 40px rgba(0,0,0,0.6) !important;
          border: none !important;
      }
      
      [data-bs-theme="dark"] header.navbar {
          background: linear-gradient(135deg, 
              var(--gradient-start, #4facfe) 0%, 
              var(--gradient-mid, #667eea) 50%, 
              var(--gradient-end, #f093fb) 100%) !important;
          opacity: 0.95;
          box-shadow: 0 4px 40px rgba(0,0,0,0.6) !important;
          border: none !important;
      }
      
      [data-bs-theme="dark"] .page-body {
          background: linear-gradient(180deg, #1a1d2e 0%, #16171d 100%);
      }
      
      [data-bs-theme="dark"] .card {
          background: rgba(255, 255, 255, 0.05);
          backdrop-filter: blur(10px);
          border: 1px solid rgba(255, 255, 255, 0.1);
          box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      }
      
      [data-bs-theme="dark"] .page-title,
      [data-bs-theme="dark"] .card-title,
      [data-bs-theme="dark"] .text-muted {
          color: rgba(255, 255, 255, 0.9) !important;
      }
      
      [data-bs-theme="dark"] .table {
          color: rgba(255, 255, 255, 0.9);
      }
      
      /* Beautiful 3-Color Button Gradients */
      .btn-primary {
          background: linear-gradient(135deg, 
              var(--gradient-start, #4facfe) 0%, 
              var(--gradient-mid, #667eea) 50%, 
              var(--gradient-end, #f093fb) 100%) !important;
          border: none !important;
          box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4) !important;
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      }
      
      .btn-primary:hover {
          transform: translateY(-3px) scale(1.02);
          box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6) !important;
      }
      
      .btn-primary:active {
          transform: translateY(-1px) scale(0.98);
      }
      
      /* Dynamic Text Color (will be overridden by JS) */
      .navbar-vertical,
      .navbar-vertical .navbar-brand,
      .navbar-vertical .nav-link,
      .navbar-vertical .nav-link-title,
      .navbar-vertical .nav-link-icon,
      header.navbar,
      header.navbar .nav-link {
          color: var(--navbar-text-color, white) !important;
      }
      
      .navbar-vertical .navbar-brand a {
          color: var(--navbar-text-color, white) !important;
          font-weight: 700;
          text-shadow: 0 2px 10px rgba(0,0,0,0.2);
      }
      
      /* Sidebar Links */
      .navbar-vertical .nav-link {
          transition: all 0.3s ease;
          border-radius: 8px;
          margin: 4px 8px;
      }
      
      .navbar-vertical .nav-link:hover {
          background: rgba(255, 255, 255, 0.2);
          transform: translateX(5px);
      }
      
      .navbar-vertical .nav-link.active {
          background: rgba(255, 255, 255, 0.3);
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
      }
      
      /* Navbar Icons */
      header.navbar .nav-link i {
          color: var(--navbar-text-color, white) !important;
      }
      
      /* Navbar Dropdown */
      header.navbar .dropdown-menu {
          background: white;
      }
      
      header.navbar .dropdown-menu .dropdown-item {
          color: #1e293b !important;
      }
      
      header.navbar .dropdown-menu .dropdown-item:hover {
          background: #f1f5f9;
      }
      
      /* Dark Mode - White Text */
      [data-bs-theme="dark"] .navbar-vertical,
      [data-bs-theme="dark"] .navbar-vertical .navbar-brand,
      [data-bs-theme="dark"] .navbar-vertical .nav-link,
      [data-bs-theme="dark"] .navbar-vertical .nav-link-title,
      [data-bs-theme="dark"] .navbar-vertical .nav-link-icon,
      [data-bs-theme="dark"] header.navbar,
      [data-bs-theme="dark"] header.navbar .nav-link {
          color: white !important;
      }
      
      [data-bs-theme="dark"] .navbar-vertical .navbar-brand a {
          color: white !important;
          text-shadow: 0 2px 10px rgba(0,0,0,0.3);
      }
      
      [data-bs-theme="dark"] .navbar-vertical .nav-link {
          color: rgba(255, 255, 255, 0.9) !important;
      }
      
      [data-bs-theme="dark"] .navbar-vertical .nav-link:hover {
          background: rgba(255, 255, 255, 0.2);
          color: white !important;
      }
      
      [data-bs-theme="dark"] .navbar-vertical .nav-link.active {
          background: rgba(255, 255, 255, 0.25);
          color: white !important;
      }
      
      [data-bs-theme="dark"] header.navbar .nav-link i {
          color: white !important;
      }
      
      [data-bs-theme="dark"] header.navbar .text-secondary {
          color: rgba(255, 255, 255, 0.8) !important;
      }
      
      /* Card Hover Effects */
      .card {
          transition: all 0.3s ease;
          background: white;
      }
      
      .card:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      }
      
      /* Page Title */
      .page-title {
          color: #1e293b;
          font-weight: 700;
      }
      
      .text-muted {
          color: #64748b !important;
      }
      
      /* Smooth Transitions */
      * {
          transition: background-color 0.3s ease, color 0.3s ease;
      }
      
      /* Badge Gradients */
      .badge {
          font-weight: 600;
          padding: 0.5em 0.75em;
      }
      
      .text-primary {
          color: var(--tblr-primary) !important;
      }
      
      /* Color Picker Buttons */
      .dropdown-menu .btn {
          border: none !important;
          padding: 0 !important;
          background: transparent !important;
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      }
      
      .dropdown-menu .btn:hover {
          transform: translateY(-3px) scale(1.05);
      }
      
      .dropdown-menu .btn:active {
          transform: translateY(-1px) scale(0.98);
      }
      
      .dropdown-menu .badge {
          border: none !important;
          border-radius: 16px !important;
          font-size: 0.7rem;
          font-weight: 700;
          letter-spacing: 0.8px;
          text-transform: uppercase;
          padding: 0.75rem 1rem !important;
          box-shadow: 0 4px 15px rgba(0,0,0,0.15);
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          display: block;
          width: 100%;
      }
      
      .dropdown-menu .btn:hover .badge {
          box-shadow: 0 8px 25px rgba(0,0,0,0.25);
      }
      
      /* Gradient Badges */
      .bg-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important; }
      .bg-azure { background: linear-gradient(135deg, #4facfe 0%, #667eea 50%, #f093fb 100%) !important; }
      .bg-indigo { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 50%, #fbc2eb 100%) !important; }
      .bg-purple { background: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #4facfe 100%) !important; }
      .bg-pink { background: linear-gradient(135deg, #fa709a 0%, #fee140 50%, #30cfd0 100%) !important; }
      .bg-red { background: linear-gradient(135deg, #ff9a56 0%, #ff6a88 50%, #fbc2eb 100%) !important; }
      .bg-orange { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 50%, #ff9a9e 100%) !important; }
      .bg-yellow { background: linear-gradient(135deg, #ffd89b 0%, #19547b 50%, #667eea 100%) !important; }
      .bg-lime { background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 50%, #4facfe 100%) !important; }
      .bg-green { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 50%, #a6c1ee 100%) !important; }
      .bg-teal { background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 50%, #fbc2eb 100%) !important; }
      .bg-cyan { background: linear-gradient(135deg, #4facfe 0%, #667eea 50%, #f093fb 100%) !important; }
    </style>
  </head>
  <body id="main-body">
    <div class="page">
      @include('layouts.sidebar')
      
      <div class="page-wrapper">
        
      @include('layouts.navbar') 
        
        <div class="page-body">
          <div class="container-xl">
             @yield('content') 
          </div>
        </div>

        @include('layouts.footer')
        
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Light mode only - no dark mode toggle
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer:1500
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            });
        @endif

        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: "Anda harus login kembali untuk mengakses halaman ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>
  <script>
    // Beautiful 3-color gradients with text color info
    const colorGradients = {
        '#206bc4': { start: '#667eea', mid: '#764ba2', end: '#f093fb', name: 'Blue Purple Pink', textColor: 'white' },
        '#4299e1': { start: '#4facfe', mid: '#667eea', end: '#f093fb', name: 'Azure Purple', textColor: 'white' },
        '#4263eb': { start: '#a8edea', mid: '#fed6e3', end: '#fbc2eb', name: 'Mint Pink', textColor: 'dark' },
        '#ae3ec9': { start: '#f093fb', mid: '#f5576c', end: '#4facfe', name: 'Pink Sunset', textColor: 'white' },
        '#d6336c': { start: '#fa709a', mid: '#fee140', end: '#30cfd0', name: 'Peach Aqua', textColor: 'dark' },
        '#d63939': { start: '#ff9a56', mid: '#ff6a88', end: '#fbc2eb', name: 'Coral Pink', textColor: 'dark' },
        '#f76707': { start: '#ffecd2', mid: '#fcb69f', end: '#ff9a9e', name: 'Orange Cream', textColor: 'dark' },
        '#f59f00': { start: '#ffd89b', mid: '#19547b', end: '#667eea', name: 'Golden Blue', textColor: 'white' },
        '#74b816': { start: '#d4fc79', mid: '#96e6a1', end: '#4facfe', name: 'Lime Sky', textColor: 'dark' },
        '#2fb344': { start: '#84fab0', mid: '#8fd3f4', end: '#a6c1ee', name: 'Mint Blue', textColor: 'dark' },
        '#0ca678': { start: '#a1c4fd', mid: '#c2e9fb', end: '#fbc2eb', name: 'Sky Pink', textColor: 'dark' },
        '#17a2b8': { start: '#4facfe', mid: '#667eea', end: '#f093fb', name: 'Cyan Purple Pink', textColor: 'white' }
    };
    
    function hexToRgb(hex) {
        hex = hex.replace(/^#/, '');
        let bigint = parseInt(hex, 16);
        return ((bigint >> 16) & 255) + ", " + ((bigint >> 8) & 255) + ", " + (bigint & 255);
    }
    
    function updateColor(hex) {
        const root = document.documentElement;
        const gradient = colorGradients[hex] || { start: hex, mid: hex, end: hex, textColor: 'white' };
        
        // Set gradient colors (3 colors for beautiful blend)
        root.style.setProperty('--gradient-start', gradient.start);
        root.style.setProperty('--gradient-mid', gradient.mid);
        root.style.setProperty('--gradient-end', gradient.end);
        root.style.setProperty('--gradient-start-rgb', hexToRgb(gradient.start));
        root.style.setProperty('--gradient-mid-rgb', hexToRgb(gradient.mid));
        root.style.setProperty('--gradient-end-rgb', hexToRgb(gradient.end));
        
        // Set text color based on gradient brightness
        const textColor = gradient.textColor === 'dark' ? '#1e293b' : 'white';
        root.style.setProperty('--navbar-text-color', textColor);
        
        // Apply text color to navbar and sidebar
        applyTextColor(textColor);
        
        // Set primary colors
        const rgb = hexToRgb(hex);
        root.style.setProperty('--tblr-primary', hex);
        root.style.setProperty('--tblr-primary-rgb', rgb);
        root.style.setProperty('--bs-primary', hex);
        root.style.setProperty('--bs-primary-rgb', rgb);
        root.style.setProperty('--tblr-link-color', hex);
        
        // Apply to sidebar and navbar
        const sidebar = document.querySelector('.navbar-vertical');
        if (sidebar) {
            sidebar.setAttribute('data-bs-theme', 'dark');
        }
        
        const topNavbar = document.querySelector('header.navbar');
        if (topNavbar) {
            topNavbar.setAttribute('data-bs-theme', 'dark');
        }
        
        localStorage.setItem('user_primary_color', hex);
        localStorage.setItem('user_text_color', gradient.textColor);
        
        // Show notification only when user clicks
        if (window.userClickedColor) {
            showColorNotification(gradient.name || 'Custom');
            window.userClickedColor = false;
        }
    }
    
    function applyTextColor(color) {
        const elements = [
            '.navbar-vertical',
            '.navbar-vertical .navbar-brand',
            '.navbar-vertical .navbar-brand a',
            '.navbar-vertical .nav-link',
            '.navbar-vertical .nav-link-title',
            '.navbar-vertical .nav-link-icon',
            'header.navbar',
            'header.navbar .nav-link',
            'header.navbar .nav-link i'
        ];
        
        elements.forEach(selector => {
            const els = document.querySelectorAll(selector);
            els.forEach(el => {
                el.style.color = color + ' !important';
            });
        });
        
        // Update text-secondary color
        const secondaryColor = color === 'white' ? 'rgba(255, 255, 255, 0.7)' : 'rgba(30, 41, 59, 0.7)';
        document.querySelectorAll('header.navbar .text-secondary').forEach(el => {
            el.style.color = secondaryColor + ' !important';
        });
    }
    
    function showColorNotification(colorName) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 9999;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = `Tema ${colorName} diterapkan`;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }
    
    document.addEventListener("DOMContentLoaded", function() {
        const savedColor = localStorage.getItem('user_primary_color');
        const savedTextColor = localStorage.getItem('user_text_color');
        
        if (savedColor) {
            updateColor(savedColor);
        } else {
            updateColor('#206bc4');
        }
        
        // Apply saved text color if exists
        if (savedTextColor) {
            const textColor = savedTextColor === 'dark' ? '#1e293b' : 'white';
            applyTextColor(textColor);
        }
        
        // Add animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(400px); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    });
</script>
   </body>
</html>