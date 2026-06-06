<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - TGX Culture')</title>
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo-trenggalek.png') }}">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex">

    <!-- Sidebar Backdrop for Mobile -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 hidden md:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 flex flex-col fixed inset-y-0 left-0 z-40 border-r border-slate-800 transition-transform duration-300 -translate-x-full md:translate-x-0">
        <!-- Logo Section -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800/60 bg-slate-950/20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 bg-white rounded-lg p-1">
                    <img src="{{ asset('logo-trenggalek.png') }}" alt="Logo Trenggalek" class="w-full h-full object-contain">
                </div>
                <div>
                    <span class="block text-md font-bold tracking-tight text-white leading-tight">TGX Dashboard</span>
                    <span class="block text-[10px] font-semibold text-emerald-400 tracking-widest uppercase">CULTURE</span>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-grow p-4 space-y-1.5 overflow-y-auto">

            
            @if(auth()->user()->is_admin)
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 mb-2">MENU ADMIN</div>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/15' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line text-lg w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.katalog.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.katalog.index') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/15' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-book-open text-lg w-5 text-center"></i>
                    <span>Manajemen Katalog</span>
                </a>

                <a href="{{ route('admin.kategori.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.kategori.index') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/15' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-tags text-lg w-5 text-center"></i>
                    <span>Manajemen Kategori</span>
                </a>

                <a href="{{ route('admin.user.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.user.index') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/15' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-users text-lg w-5 text-center"></i>
                    <span>Manajemen User</span>
                </a>
            @else
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 mb-2">MENU USER</div>

                <a href="{{ route('user.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/15' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line text-lg w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.katalog.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.katalog.index') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/15' : 'hover:bg-slate-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-book-open text-lg w-5 text-center"></i>
                    <span>Manajemen Katalog</span>
                </a>
            @endif
        </nav>

        <!-- User Information & Logout -->
        <div class="p-4 border-t border-slate-800/60 bg-slate-950/20">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-slate-800 border border-slate-700 text-white font-semibold flex items-center justify-center rounded-xl">
                    {{ substr(auth()->user()->nama, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->nama }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium {{ auth()->user()->is_admin ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-blue-500/10 text-blue-400 border border-blue-500/20' }}">
                        {{ auth()->user()->is_admin ? 'Administrator' : 'User' }}
                    </span>
                </div>
            </div>
            
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <button onclick="openLogoutModal()" type="button" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-rose-400 border border-rose-500/20 bg-rose-500/5 hover:bg-rose-500 hover:text-white transition-all duration-200">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Keluar</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 md:pl-64 flex flex-col min-h-screen">
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="md:hidden p-2 text-slate-500 hover:text-slate-800 focus:outline-none" aria-label="Toggle Sidebar">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-lg sm:text-xl font-bold text-slate-800 tracking-tight">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-globe"></i>
                    <span class="hidden sm:inline">Lihat Situs</span>
                </a>
                <span class="h-5 w-px bg-slate-200"></span>
                <span class="text-[10px] sm:text-xs text-slate-400 font-medium">Hari ini: {{ date('d M Y') }}</span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow p-8">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl p-4 text-sm flex items-start gap-3 mb-6 shadow-sm shadow-emerald-100/30">
                    <i class="fa-solid fa-circle-check mt-0.5 text-emerald-500 text-lg"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-100 text-rose-800 rounded-2xl p-4 text-sm flex items-start gap-3 mb-6 shadow-sm shadow-rose-100/30">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 text-rose-500 text-lg"></i>
                    <div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeLogoutModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-sm transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100 text-center">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-arrow-right-from-bracket text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Konfirmasi Keluar</h3>
                <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin keluar dari sistem TGX Culture?</p>
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeLogoutModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                    <button type="button" onclick="document.getElementById('logoutForm').submit()" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl transition-all">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
        }
        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
        }
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
</body>
</html>
