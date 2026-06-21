@extends('layouts.public')

@section('title', 'TGX Culture - Jelajah Katalog Budaya')

@section('content')


<!-- Hero / Welcome & Search Section -->
<section class="relative bg-gradient-to-b from-emerald-50/50 to-white pt-12 pb-10 overflow-hidden">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-200/15 rounded-full blur-3xl -z-10"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-2">
            Selamat Datang Di Katalog Budaya <br>
            <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">Lokal Kabupaten Trenggalek</span>
        </h1>
        <p class="text-sm text-slate-500 max-w-lg mx-auto mb-6">
            Gunakan filter pencarian di bawah untuk menemukan katalog objek budaya spesifik.
        </p>

        <!-- Search & Filter Form -->
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('jelajah') }}" method="GET" class="flex flex-col md:flex-row gap-3 p-2 bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-100 transition-all duration-300">
                <!-- Text Search Input -->
                <div class="relative flex-grow md:w-2/5">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukan Kata Kunci..." class="w-full pl-10 pr-4 py-3 bg-transparent text-slate-800 placeholder-slate-400 outline-none text-sm rounded-xl">
                </div>

                <!-- Vertical divider for desktop -->
                <div class="hidden md:block w-px bg-slate-200 my-2"></div>

                <!-- Category Selection Dropdown -->
                <div class="relative md:w-2/5 flex items-center">
                    <div class="absolute left-3.5 text-slate-400">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <select name="kategori" class="w-full pl-10 pr-8 py-3 bg-transparent text-slate-700 placeholder-slate-400 outline-none text-sm appearance-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->kategori_id }}" {{ request('kategori') == $cat->kategori_id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <!-- Search Button -->
                <button type="submit" class="px-7 py-3 text-sm font-bold text-white bg-rose-500 hover:bg-rose-600 rounded-xl shadow-md shadow-rose-200 hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                    Cari
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Breadcrumb Area -->
<nav class="bg-slate-50 border-y border-slate-200/60 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs text-slate-500 font-medium flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
        <span class="text-slate-800">Hasil Pencarian</span>
    </div>
</nav>

<!-- Catalog Search Results -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @forelse ($katalogs as $katalog)
            @php
                $categoryName = $katalog->kategori->nama_kategori ?? 'Umum';
                
                $isLocal = function($path) {
                    if (!$path) return false;
                    return !preg_match('/^(http:\/\/|https:\/\/|\/\/)/i', $path);
                };

                $firstMedia = null;
                $hasMedia = false;
                $isBroken = false;
                $mediaPath = null;
                $mediaType = null;
                $ytThumbnail = null;

                if ($katalog->mediaKatalogs && $katalog->mediaKatalogs->isNotEmpty()) {
                    $firstMedia = $katalog->mediaKatalogs->first();
                    $hasMedia = true;
                    $mediaType = $firstMedia->type;
                    
                    if ($mediaType === 'youtube') {
                        $mediaPath = $firstMedia->path_link;
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|win/|user/[^/]+/|embed/|watch\?v=)|youtu\.be/)([^"&?/ ]{11})%i', $mediaPath, $match);
                        $ytId = $match[1] ?? null;
                        if ($ytId) {
                            $ytThumbnail = "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg";
                        }
                    } else {
                        $exists = !$isLocal($firstMedia->path_link) || file_exists(public_path($firstMedia->path_link));
                        if ($exists) {
                            $mediaPath = asset($firstMedia->path_link);
                        } else {
                            $isBroken = true;
                            $mediaPath = $firstMedia->path_link;
                        }
                    }
                }
            @endphp
            <!-- Catalog Card (Vertical/Row layout) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 p-5 sm:p-6 flex flex-col sm:flex-row gap-6 items-start">
                
                <!-- Image Box on the left -->
                <div class="w-full sm:w-44 h-44 rounded-xl overflow-hidden bg-slate-50 relative border border-slate-100 flex-shrink-0 shadow-inner flex items-center justify-center">
                    @if(!$hasMedia || $isBroken)
                        <img src="{{ asset('assets/no-image.png') }}" alt="{{ $katalog->judul }}" class="w-full h-full object-cover" loading="lazy">
                    @elseif($mediaType === 'youtube' && $ytThumbnail)
                        <img src="{{ $ytThumbnail }}" alt="{{ $katalog->judul }}" class="w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center text-white text-lg">
                            <i class="fa-brands fa-youtube"></i>
                        </div>
                    @elseif($mediaType === 'video')
                        <video src="{{ $mediaPath }}" class="w-full h-full object-cover" muted></video>
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center text-white text-lg">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    @else
                        <img src="{{ $mediaPath }}" alt="{{ $katalog->judul }}" class="w-full h-full object-cover" loading="lazy">
                    @endif

                    <span class="absolute top-2.5 left-2.5 bg-emerald-600 text-white px-2.5 py-0.5 rounded-lg text-[10px] font-bold tracking-wide shadow-sm">
                        {{ $categoryName }}
                    </span>
                </div>

                <!-- Info Box on the right -->
                <div class="flex-grow w-full">
                    <div class="space-y-2.5">
                        <!-- Judul -->
                        <div class="flex flex-col sm:flex-row sm:items-baseline border-b border-slate-50 pb-2">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-24">Judul</span>
                            <span class="hidden sm:inline text-slate-400 mr-2">:</span>
                            <h2 class="text-base font-bold text-slate-800 flex-grow line-clamp-1" title="{{ $katalog->judul }}">{{ $katalog->judul }}</h2>
                        </div>

                        <!-- Pencipta -->
                        <div class="flex flex-col sm:flex-row sm:items-baseline">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-24">Pencipta</span>
                            <span class="hidden sm:inline text-slate-400 mr-2">:</span>
                            <span class="text-xs text-slate-700 font-medium line-clamp-1">{{ $katalog->pencipta }}</span>
                        </div>

                        <!-- Subjek -->
                        <div class="flex flex-col sm:flex-row sm:items-baseline">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-24">Subjek</span>
                            <span class="hidden sm:inline text-slate-400 mr-2">:</span>
                            <span class="text-xs text-slate-700 font-medium line-clamp-1">{{ $katalog->subjek }}</span>
                        </div>

                        <!-- Tipe -->
                        <div class="flex flex-col sm:flex-row sm:items-baseline">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-24">Tipe</span>
                            <span class="hidden sm:inline text-slate-400 mr-2">:</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">
                                {{ $katalog->tipe }}
                            </span>
                        </div>
                    </div>

                    <!-- Short description / footer action -->
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-[10px] text-slate-400 flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i>
                            {{ $katalog->created_at ? $katalog->created_at->diffForHumans() : '-' }}
                        </p>
                        <a href="{{ route('jelajah.show', $katalog->katalog_id) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-all">
                            Detail
                            <i class="fa-solid fa-arrow-right text-[8px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-box-open text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-700">Katalog Tidak Ditemukan</h3>
                <p class="text-sm text-slate-500 mt-1">Belum ada objek budaya yang sesuai dengan pencarian Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('jelajah') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition-all">
                        Reset Pencarian
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination Section -->
    @if ($katalogs->hasPages())
        <div class="mt-12 flex justify-center">
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1">
                {{-- Previous Page Link --}}
                @if ($katalogs->onFirstPage())
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed text-xs font-bold">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $katalogs->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors text-xs font-bold">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($katalogs->links()->elements[0] ?? [] as $page => $url)
                    @if ($page == $katalogs->currentPage())
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-md shadow-emerald-200">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors text-xs font-bold">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($katalogs->hasMorePages())
                    <a href="{{ $katalogs->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors text-xs font-bold">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed text-xs font-bold">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif
            </nav>
        </div>
    @endif
</section>
@endsection
