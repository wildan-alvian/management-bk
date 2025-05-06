<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Alfa Slab One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus Jakarta Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh Sans&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

                @if(in_array(Auth::user()->role, ['Super Admin', 'Admin']))
                <a href="{{ route('admin.index') }}" 
                class="nav-link mb-2 {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill me-5"></i> 
                    <span>Data Admin</span>
                </a>
                @endif

                @if(in_array(Auth::user()->role, ['Super Admin', 'Admin', 'Guidance Counselor']))
                <a href="{{ route('counselors.index') }}" 
                class="nav-link mb-2 {{ request()->routeIs('counselors.index') ? 'active' : '' }}">
                    <i class="bi bi-person-vcard-fill me-5"></i> 
                    <span>Data Guru BK</span>
                </a>
                @endif

                @if(in_array(Auth::user()->role, ['Super Admin', 'Admin', 'Guidance Counselor', 'Student', 'Student Parent']))
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
        @yield('content')
    </div>
</body>
</html>
