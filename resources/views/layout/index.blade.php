<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .pagination ~ p,
        .pagination-info {
            display: none !important;
        }
    </style>
    
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Alfa Slab One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus Jakarta Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh Sans&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        body { display: flex; margin: 0; }
        .sidebar {
            width: 310px;
            background-color: #546447;
            color: white;
            min-height: 100vh;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            margin: 10px 15;
            padding: 10px 15px;
            border-radius: 20px;
            width: 270px;
            font-family: 'Plus Jakarta Sans';
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
        background-color: #6e7f5c;
        color: #b2c2bd;
        }
        .sidebar a.active {
            background-color: #9fc9b0;
            color: #546447;
            font-weight: bold;
        }
        .content {
            flex: 1;
            padding: 30px;
            background: #f8f9fa;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .sidebar .d-flex.align-items-center.mb-5.ps-3 {
            margin-bottom: 10px;  
        }
        
        
        .sidebar hr {
            margin-top: 10px;  /* Menyesuaikan jarak garis dengan teks di atasnya */
            margin-bottom: 15px; /* Menambahkan sedikit jarak bawah agar tidak terlalu mepet */
            border: none;
            border-top: 4px solid white;
        }

    </style>
    
    <style>
        .btn-orange {
            background-color: #FF7300;
            border-color: #FF7300;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
    
        .btn-orange:hover {
            background-color: #e86500;
            border-color: #e86500;
            transform: scale(1.05);
        }
    </style>   

    <style>
        .btn-glow {
            background-color: #d2d0d0e9;
            color: #000000;
            border: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    
        .btn-glow:hover {
            background-color: #7a7a7a;
            color: #000000;
            box-shadow: 0 6px 16px rgba(255, 255, 255, 0.5);
            transform: scale(1.03);
        }
    </style>     

<style>
    /* Mengatur animasi smooth pada dropdown */
        .dropdown-menu {
            animation: fadeInDown 0.3s ease-in-out;
            border-radius: 12px;
            min-width: 180px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }

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

        /* Mengatur animasi khusus pada dropdown yang menggunakan class .dropdown-animated */
        .dropdown-menu.dropdown-animated {
            opacity: 0;
            transform: translateY(10px);
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .dropdown-menu.dropdown-animated.show {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
            pointer-events: auto;
        }

</style>


</head>
<body>
    <div class="sidebar">
        <div class="d-flex flex-column align-items-start mb-5">
            <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('asset/images/dapuda.png') }}" width="55" height="55" class="me-2">
                <h4 class="fs-2 m-0" style="font-family: 'Alfa Slab One';">
                    <span style="color:#D3F1DF">Counsel</span><span style="color:#F9CB43">Link</span>
                </h4>
            </div>    
            <div class="d-flex align-items-center mb-3 ps-3" style="font-family: 'Plus Jakarta Sans';">
                <i class="bi bi-bell-fill fs-5 me-5 text-white opacity-50"></i>
                <span class="text-white opacity-50">5 Notifikasi Baru</span>
            </div>        
            <hr class="w-100" style="border: none; border-top: 4px solid white; margin: 0 0 20px 0;">
            
            <nav class="nav flex-column">
                <a href="#" class="nav-link text-white mb-2" style="font-family: 'Plus Jakarta Sans';">
                    <i class="bi bi-grid me-5 text-white opacity-100"></i> <span class="text-white opacity-100">Dashboard</span>
                </a>

                @if(Auth::user()->hasRole('Super Admin'))
                <a href="{{ route('roles.index') }}" 
                class="nav-link mb-2 {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock-fill me-5"></i> 
                    <span>Data Roles</span>
                </a>
                @endif

                @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin']))
                <a href="{{ route('admin.index') }}" 
                class="nav-link mb-2 {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill me-5"></i> 
                    <span>Data Admin</span>
                </a>
                @endif

                @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
                <a href="{{ route('counselors.index') }}" 
                class="nav-link mb-2 {{ request()->routeIs('counselors.index') ? 'active' : '' }}">
                    <i class="bi bi-person-vcard-fill me-5"></i> 
                    <span>Data Guru BK</span>
                </a>
                @endif

                @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor', 'Student', 'Student Parents']))
                <a href="{{ route('students.index') }}" 
                class="nav-link mb-2 {{ request()->routeIs('students.index') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-5"></i>
                    <span>Data Siswa</span>
                </a>
                <a href="{{ route('counseling.index') }}" 
                class="nav-link mb-2 {{ request()->routeIs('counseling.index') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-richtext-fill me-5"></i> 
                    <span>Data Konseling</span>
                </a>
                @endif
            </nav>
        </div>
    </div> 

    <div class="content">
        <div class="container mt-5" style="font-family: 'Kumbh Sans';">
            <div class="container mt-5">
        
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" style="gap: 1rem;" href="#" role="button" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('asset/images/profile.png') }}" alt="Foto Profil" class="rounded-circle me-2" width="45" height="45">
                            <div class="text-start">
                                <h5 class="mb-0 fw-bold text-dark">{{ Auth::user()->nama_lengkap ?? 'M. Wildan Alvian Prastya' }}</h5>
                                <small class="text-muted">{{ Auth::user()->role }}</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-animated" aria-labelledby="dropdownProfile">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.edit', Auth::user()->id) }}">
                                    <i class="bi bi-pencil-square"></i> Edit Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>            
                </div>
        @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
