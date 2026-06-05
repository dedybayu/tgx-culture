<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TGX Culture - Katalog Budaya Trenggalek')</title>
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
<body class="min-h-screen flex flex-col selection:bg-rose-500 selection:text-white">

    <!-- Header Navigation -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo Section -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <!-- Trenggalek Styled Logo SVG -->
                <div class="w-11 h-11 bg-emerald-50 rounded-xl border border-emerald-500/20 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-lg font-bold tracking-tight text-slate-800 leading-tight">TGX</span>
                    <span class="block text-xs font-semibold text-emerald-600 tracking-widest uppercase -mt-0.5">CULTURE</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors duration-200">Beranda</a>
                <a href="{{ route('jelajah') }}" class="hover:text-emerald-600 transition-colors duration-200">Katalog Budaya</a>
                <a href="#" class="hover:text-emerald-600 transition-colors duration-200">Tentang Kami</a>
            </nav>

            <!-- Action Button -->
            <div class="flex items-center gap-3">
                <a href="#" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-slate-900 rounded-xl hover:bg-slate-800 active:bg-slate-950 transition-all duration-200 shadow-sm">
                    Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                    </div>
                    <span class="text-white font-bold text-lg tracking-tight">TGX <span class="text-emerald-500">CULTURE</span></span>
                </div>
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} Dinas Kebudayaan dan Pariwisata Kabupaten Trenggalek. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
