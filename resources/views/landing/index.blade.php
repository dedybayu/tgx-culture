@extends('layouts.public')

@section('title', 'TGX Culture - Katalog Budaya Trenggalek')

@section('content')
@php
    // Mapping of category names to beautiful high-quality Unsplash image URLs as fallbacks
    $fallbackImages = [
        'Manuskrip' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop',
        'Tradisi Lisan' => 'https://images.unsplash.com/photo-1503095396549-807759245b35?q=80&w=600&auto=format&fit=crop',
        'Adat Istiadat' => 'https://images.unsplash.com/photo-1532375810709-75b1da00537c?q=80&w=600&auto=format&fit=crop',
        'Ritus' => 'https://images.unsplash.com/photo-1608976328267-e673d3ec06ce?q=80&w=600&auto=format&fit=crop',
        'Pengetahuan Tradisional' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=600&auto=format&fit=crop',
        'Teknologi Tradisional' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=600&auto=format&fit=crop',
        'Seni' => 'https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?q=80&w=600&auto=format&fit=crop',
        'Bahasa' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=600&auto=format&fit=crop',
        'Permainan Rakyat' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=600&auto=format&fit=crop',
        'Olahraga Tradisional' => 'https://images.unsplash.com/photo-1555597673-b21d5c935865?q=80&w=600&auto=format&fit=crop',
        'Cagar Budaya' => 'https://images.unsplash.com/photo-1590075865003-e48277faa558?q=80&w=600&auto=format&fit=crop',
    ];
@endphp

<!-- Hero / Welcome & Search Section -->
<section class="relative bg-gradient-to-b from-emerald-50/50 to-white pt-16 pb-12 overflow-hidden">
    <!-- Subtle Decorative Background Blurs -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-200/20 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-rose-200/10 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Badge -->
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 mb-6 animate-fade-in">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-ping"></span>
            Pelestarian Warisan Budaya
        </span>

        <!-- Title -->
        <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-3">
            Selamat Datang Di Katalog Budaya <br>
            <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">Lokal Kabupaten Trenggalek</span>
        </h1>
        
        <p class="text-base text-slate-500 max-w-xl mx-auto mb-8">
            Telusuri dan jelajahi kekayaan adat istiadat, seni, ritus, sejarah, dan warisan budaya adiluhung Kabupaten Trenggalek.
        </p>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto">
            <form id="search-form" action="{{ route('jelajah') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 p-2 bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-100 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-100 transition-all duration-300">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                    </div>
                    <input type="text" id="search-input" name="search" placeholder="Masukan Kata Kunci..." class="w-full pl-10 pr-4 py-3 bg-transparent text-slate-800 placeholder-slate-400 outline-none text-sm rounded-xl">
                </div>
                <button type="submit" class="px-7 py-3 text-sm font-bold text-white bg-rose-500 hover:bg-rose-600 rounded-xl shadow-md shadow-rose-200 hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                    Cari
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Section Bar: Objek Budaya Berdasarkan Kategori -->
<section class="bg-slate-100/80 border-y border-slate-200/60 sticky top-20 z-40 backdrop-blur-md py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2.5">
                <span class="w-1.5 h-6 bg-emerald-600 rounded-full"></span>
                Objek Budaya Berdasarkan Kategori
            </h2>
            <span class="text-xs font-semibold text-slate-500 bg-slate-200/60 px-2.5 py-1 rounded-md">
                <span id="category-count">{{ $categories->count() }}</span> Kategori
            </span>
        </div>
    </div>
</section>

<!-- Grid Kategori -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div id="category-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse ($categories as $category)
            @php
                // Get fallback image or use path_gambar if exists
                $imageSrc = $fallbackImages[$category->nama_kategori] ?? 'https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?q=80&w=600&auto=format&fit=crop';
            @endphp
            <a href="{{ route('jelajah', ['kategori' => $category->kategori_id]) }}" class="category-card group relative flex flex-col items-center bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 p-4" data-name="{{ strtolower($category->nama_kategori) }}">
                <!-- Image Container with fixed Aspect Ratio -->
                <div class="w-full aspect-[4/5] rounded-xl overflow-hidden bg-slate-50 relative border border-slate-100 shadow-inner">
                    <!-- Photo Display / Placeholder -->
                    <img src="{{ $imageSrc }}" 
                         alt="{{ $category->nama_kategori }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         loading="lazy">
                    
                    <!-- Subtle Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/30 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>

                    <!-- Category Badge count placeholder / tag -->
                    <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-[10px] font-bold text-slate-800 shadow-sm border border-slate-100/50">
                        {{ $category->katalog ? $category->katalog->count() : 0 }} Objek
                    </span>
                </div>

                <!-- Floating Label overlapping the bottom of the image -->
                <div class="relative z-10 -mt-6 w-[85%] bg-white border border-slate-200/80 shadow-md group-hover:shadow-lg rounded-xl py-3 px-4 text-center transition-all duration-300 transform group-hover:-translate-y-1">
                    <h3 class="font-bold text-slate-800 text-sm tracking-tight group-hover:text-emerald-600 transition-colors duration-200">
                        {{ $category->nama_kategori }}
                    </h3>
                </div>
            </a>
        @empty
            <div class="col-span-full py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-700">Belum Ada Kategori</h3>
                <p class="text-sm text-slate-500 mt-1">Gunakan seeder untuk mengisi data awal kategori warisan budaya.</p>
            </div>
        @endforelse

        <!-- No Results Message -->
        <div id="no-results" class="hidden col-span-full py-16 text-center">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-magnifying-glass text-2xl animate-bounce"></i>
            </div>
            <h3 class="text-base font-bold text-slate-700">Kategori Tidak Ditemukan</h3>
            <p class="text-sm text-slate-500 mt-1">Coba masukkan kata kunci pencarian yang berbeda.</p>
        </div>
    </div>
</section>

<!-- Frontend Search Filter Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchForm = document.getElementById('search-form');
        const categoryCards = document.querySelectorAll('.category-card');
        const noResults = document.getElementById('no-results');
        const categoryCount = document.getElementById('category-count');

        function filterCategories() {
            const query = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            categoryCards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(query)) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Update visible category count indicator
            categoryCount.textContent = visibleCount;

            // Show or hide "No Results" message
            if (visibleCount === 0 && categoryCards.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Real-time filtering as the user types
        searchInput.addEventListener('input', filterCategories);
    });
</script>
@endsection
