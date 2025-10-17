<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary-color: #5A6C57;
            --primary-light: #7a8e77;
            --primary-dark: #3f4d3d;
            --accent-color: #F9CB43;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --bg-light: #f8f9fa;
            --bg-white: #ffffff;
            --sidebar-bg: #f0f4f1;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --transition-base: all 0.3s ease;
            --font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Global Font Settings */
        html, body {
            font-family: var(--font-family);
        }

        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: var(--font-family);
        }

        /* Modal Font Settings */
        .modal-title,
        .modal-body,
        .modal-footer {
            font-family: var(--font-family);
        }

        /* Form Font Settings */
        input,
        select,
        textarea,
        .form-control,
        .form-select,
        .form-label,
        .form-check-label {
            font-family: var(--font-family);
        }

        /* Button Font Settings */
        .btn,
        .dropdown-item {
            font-family: var(--font-family);
        }

        /* Table Font Settings */
        .table,
        .table th,
        .table td {
            font-family: var(--font-family);
        }

        /* Alert Font Settings */
        .alert {
            font-family: var(--font-family);
        }

        /* Badge Font Settings */
        .badge {
            font-family: var(--font-family);
        }

        /* Card Font Settings */
        .card-title,
        .card-text,
        .card-header,
        .card-footer {
            font-family: var(--font-family);
        }

        /* Pagination Font Settings */
        .pagination,
        .page-link {
            font-family: var(--font-family);
        }

        /* Custom Classes Font Settings */
        .fw-medium {
            font-weight: 500;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        /* Typography Styles */
        .page-title {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .text-muted {
            color: var(--text-secondary) !important;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background-color: #F5F5F0; 
            box-shadow: var(--shadow-md);
            padding: 1.5rem;
            transition: var(--transition-base);
            z-index: 1000;
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 0.5rem 1rem;
            margin-bottom: 2rem;
        }

        .nav-link {
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            transition: var(--transition-base);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .nav-link:hover {
            background-color: var(--bg-light);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: var(--bg-white);
        }

        .nav-link i {
            font-size: 1.25rem;
        }

        /* Content Area */
        .content {
            flex: 1;
            margin-left: 280px;
            padding: 1rem;
            transition: var(--transition-base);
            overflow: auto;
        }

        /* Card Styles */
        .card {
            background: var(--bg-white);
            border: none;
            border-radius: 1rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-base);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background-color: var(--bg-white);
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Button Styles */
        .btn {
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: var(--transition-base);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn i {
            font-size: 1.1em;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--bg-white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            color: var(--bg-white);
        }

        .btn-secondary {
            background-color: #e2e8f0;
            border-color: #e2e8f0;
            color: var(--text-secondary);
        }

        .btn-secondary:hover {
            background-color: #cbd5e1;
            border-color: #cbd5e1;
            color: var(--text-primary);
        }

        /* Action Buttons */
        .btn-add {
            background-color: var(--primary-color);
            color: var(--bg-white);
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(90, 108, 87, 0.1);
        }

        .btn-add:hover {
            background-color: var(--primary-dark);
            color: var(--bg-white);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(90, 108, 87, 0.2);
        }

        .btn-edit {
            background-color: #f0b429;
            border-color: #f0b429;
            color: var(--bg-white);
        }

        .btn-edit:hover {
            background-color: #d69e2e;
            border-color: #d69e2e;
            color: var(--bg-white);
        }

        .btn-delete {
            background-color: #e53e3e;
            border-color: #e53e3e;
            color: var(--bg-white);
        }

        .btn-delete:hover {
            background-color: #c53030;
            border-color: #c53030;
            color: var(--bg-white);
        }

        /* Button Groups */
        .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        .btn-group .btn {
            padding: 0.5rem 1rem;
        }

        /* Small Buttons */
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Large Buttons */
        .btn-lg {
            padding: 0.875rem 1.75rem;
            font-size: 1.125rem;
        }

        /* Table Styles */
        .table-responsive {
            min-height: 60vh;
            background-color: var(--bg-white);
            border-radius: 0.75rem;
            box-shadow: var(--shadow-sm);
            padding: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--bg-light);
            border-bottom: 2px solid #e2e8f0;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .table tbody {
            min-height: 300px;
        }

        .table tbody tr {
            transition: var(--transition-base);
        }

        .table tbody tr:hover {
            background-color: #f7fafc;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
            color: var(--text-secondary);
        }

        /* Empty state styling */
        .table tbody tr td[colspan] {
            padding: 3rem 1rem;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .table tbody tr td[colspan]::before {
            content: '';
            display: block;
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%234a5568'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4'%3E%3C/path%3E%3C/svg%3E");
            opacity: 0.5;
        }

        /* Pagination */
        .pagination {
            gap: 0.25rem;
            margin-top: 1.5rem;
        }

        .page-link {
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            color: var(--text-secondary);
            transition: var(--transition-base);
            margin: 0 0.125rem;
        }

        .page-link:hover {
            background-color: var(--primary-light);
            color: var(--bg-white);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            color: var(--bg-white);
        }

        .page-item.disabled .page-link {
            background-color: #e2e8f0;
            color: #a0aec0;
        }

        /* Form Controls */
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            transition: var(--transition-base);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(90, 108, 87, 0.1);
        }

        .form-label {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: 0.75rem;
            padding: 0.5rem;
            animation: fadeInDown 0.3s ease;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: var(--transition-base);
            color: var(--text-secondary);
        }

        .dropdown-item:hover {
            background-color: var(--bg-light);
            color: var(--primary-color);
        }

        .dropdown-divider {
            border-color: #e2e8f0;
            margin: 0.5rem 0;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #def7ec;
            color: #03543f;
        }

        .alert-danger {
            background-color: #fde8e8;
            color: #9b1c1c;
        }

        .alert-warning {
            background-color: #feecdc;
            color: #9c4221;
        }

        .alert-info {
            background-color: #e1effe;
            color: #1e429f;
        }

        /* Badge Styles */
        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 0.375rem;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hide pagination info */
        .pagination ~ p,
        .pagination-info {
            display: none !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .content {
                margin-left: 0;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .table-responsive {
                border-radius: 0.75rem;
                box-shadow: var(--shadow-sm);
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand d-flex align-items-center">
            <img src="{{ asset('asset/images/dapuda.png') }}" width="45" height="45" class="me-2">
            <h4 class="m-0" style="font-family: 'Alfa Slab One';">
                <span style="color: var(--primary-color)">Counsel</span><span style="color: var(--accent-color)">Link</span>
            </h4>
        </div>

        <div class="profile-section mb-4">
            <div class="d-flex align-items-center">
                <img src="{{ asset('asset/images/profile.png') }}" alt="Profile" class="rounded-circle" width="40" height="40">
                <div class="profile-info ms-3">
                    <h5 class="fw-semibold">{{ Auth::user()->name ?? 'Nama' }}</h5>
                    <small>{{ Auth::user()->role }}</small>
                </div>
            </div>
        </div>

        <nav class="nav flex-column">
            @php
                $notificationHref = Auth::user()->hasAnyRole(['Guidance Counselor', 'Student', 'Student Parents']) ?
                    route('notifications.index', ['type' => Auth::user()->role]) : route('notifications.index');
            @endphp

            <a href="{{ $notificationHref }}" class="nav-link">
                <i class="bi bi-bell"></i>
                <span>Notifikasi</span>
                @if($unreadCountBadge > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{$unreadCountBadge}}</span>
                @endif
            </a>

            <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Beranda</span>
            </a>

            @if(Auth::user()->hasRole('Super Admin'))
            <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i>
                <span>Data Roles</span>
            </a>
            @endif

            @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin']))
            <a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>Data Admin</span>
            </a>
            @endif

            @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
            <a href="{{ route('counselors.index') }}" class="nav-link {{ request()->routeIs('counselors.index') ? 'active' : '' }}">
                <i class="bi bi-person-vcard"></i>
                <span>Data Guru BK</span>
            </a>
            @endif

            @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor', 'Student', 'Student Parents']))
            <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Data Siswa</span>
            </a>
            <a href="{{ route('student-parents.index') }}" class="nav-link {{ request()->routeIs('student-parents.index') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Data Wali Murid</span>
            </a>
            <a href="{{ route('counseling.index') }}" class="nav-link {{ request()->routeIs('counseling.index') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Data Konseling</span>
            </a>
            <a href="{{ route('presensi.index') }}" class="nav-link {{ request()->routeIs('presensi.index') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i>
                <span>Absensi</span>
            </a>
            @endif
        </nav>

        <div class="mt-auto">
            <hr>
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-gear"></i>
                    <span>Pengaturan</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- <li>
                        <a class="dropdown-item" href="{{ route('admin.edit', Auth::user()->id) }}">
                            <i class="bi bi-person me-2"></i> Edit Profile
                        </a>
                    </li> -->
                    <li>
                        <a class="dropdown-item" href="{{ route('password.change') }}">
                            <i class="bi bi-key me-2"></i> Ganti Kata Sandi
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function addMenuBtn() {
                if (window.innerWidth <= 768 && !document.getElementById('mobileMenuBtn')) {
                    const menuBtn = document.createElement('button');
                    menuBtn.id = 'mobileMenuBtn';
                    menuBtn.className = 'btn btn-primary position-fixed top-0 end-0 m-3 d-md-none';
                    menuBtn.innerHTML = '<i class="bi bi-list"></i>';
                    menuBtn.style.zIndex = "1100";
                    menuBtn.onclick = () => document.querySelector('.sidebar').classList.toggle('show');
                    document.body.appendChild(menuBtn);
                } else if (window.innerWidth > 768 && document.getElementById('mobileMenuBtn')) {
                    document.getElementById('mobileMenuBtn').remove();
                    document.querySelector('.sidebar').classList.remove('show');
                }
            }
            addMenuBtn();
            window.addEventListener('resize', addMenuBtn);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.sidebar');
            const toggleButton = document.getElementById('toggleSidebar');

            // Only attach handlers if elements exist to avoid runtime errors that stop other JS (like Bootstrap dropdown)
            if (sidebar && toggleButton) {
                toggleButton.addEventListener('click', function () {
                    sidebar.classList.toggle('show');
                });

                document.addEventListener('click', function (e) {
                    const isClickInsideSidebar = sidebar.contains(e.target);
                    const isClickOnToggle = toggleButton.contains(e.target);

                    if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
