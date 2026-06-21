@extends('layouts.public')

@section('title', $katalog->judul . ' - TGX Culture')

@section('content')
@php
    $kategoriNama = $katalog->kategori ? $katalog->kategori->nama_kategori : '-';
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header Navigation -->
    <div class="mb-6 pt-4 flex items-center justify-between">
        <a href="{{ route('jelajah') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Jelajah Katalog
        </a>
    </div>

    <!-- Main Detail Wrapper -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-100/50 flex flex-col lg:flex-row gap-8">
        <!-- Left Column: Image & Basic Info -->
        <div class="w-full lg:w-1/3 space-y-6">
            <!-- Active Media Viewer (Slider) -->
            @php
                $isLocal = function($path) {
                    if (!$path) return false;
                    return !preg_match('/^(http:\/\/|https:\/\/|\/\/)/i', $path);
                };

                // Collect all valid media slides
                $slides = [];
                
                // Add cover image if exists in database
                if ($katalog->path_gambar) {
                    $exists = !$isLocal($katalog->path_gambar) || file_exists(public_path($katalog->path_gambar));
                    $slides[] = [
                        'type' => 'image',
                        'path' => $exists ? asset($katalog->path_gambar) : null,
                        'original_path' => $katalog->path_gambar,
                        'is_broken' => !$exists,
                        'is_cover' => true
                    ];
                }
                
                if($katalog->mediaKatalogs && $katalog->mediaKatalogs->isNotEmpty()) {
                    foreach($katalog->mediaKatalogs as $media) {
                        // Skip if it duplicates the cover path
                        if ($katalog->path_gambar && $media->path_link === $katalog->path_gambar) {
                            continue;
                        }
                        
                        $exists = true;
                        if ($media->type !== 'youtube' && $isLocal($media->path_link)) {
                            $exists = file_exists(public_path($media->path_link));
                        }
                        
                        $slides[] = [
                            'type' => $media->type,
                            'path' => $exists ? ($media->type === 'youtube' ? $media->path_link : asset($media->path_link)) : null,
                            'original_path' => $media->path_link,
                            'is_broken' => !$exists,
                            'is_cover' => false
                        ];
                    }
                }
                
                $totalSlides = count($slides);
            @endphp

            @if($totalSlides === 0)
                <div class="w-full aspect-[3/4] bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-inner relative group" id="main-viewer">
                    <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-600/90 text-white backdrop-blur-sm border border-emerald-500/20 z-30">
                        {{ $kategoriNama }}
                    </span>
                    <img src="{{ asset('assets/no-image.png') }}" alt="{{ $katalog->judul }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-full aspect-[3/4] bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-inner relative group" id="main-viewer">
                    <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-600/90 text-white backdrop-blur-sm border border-emerald-500/20 z-30">
                        {{ $kategoriNama }}
                    </span>

                    <!-- Slider Track Wrapper -->
                    <div class="w-full h-full overflow-hidden relative z-10">
                        <div id="slider-track" class="flex w-full h-full transition-transform duration-500 ease-out">
                            @foreach($slides as $index => $slide)
                                <div class="w-full h-full flex-shrink-0 relative slide-item" data-index="{{ $index }}" data-type="{{ $slide['type'] }}">
                                    @if($slide['is_broken'])
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-slate-50 text-slate-400 p-6 text-center border border-dashed border-slate-200 rounded-2xl">
                                            <i class="fa-solid fa-triangle-exclamation text-4xl text-rose-500 mb-2"></i>
                                            <span class="text-xs font-bold text-slate-700 block mb-1">Media Tidak Ditemukan</span>
                                            <span class="text-[10px] text-slate-400 break-all select-all font-mono max-w-full px-2 overflow-hidden text-ellipsis">{{ basename($slide['original_path']) }}</span>
                                        </div>
                                    @elseif($slide['type'] === 'image')
                                        <img src="{{ $slide['path'] }}" alt="{{ $katalog->judul }}" class="w-full h-full object-cover">
                                    @elseif($slide['type'] === 'video')
                                        <video src="{{ $slide['path'] }}" class="w-full h-full object-cover" controls></video>
                                    @elseif($slide['type'] === 'youtube')
                                        @php
                                            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|win/|user/[^/]+/|embed/|watch\?v=)|youtu\.be/)([^"&?/ ]{11})%i', $slide['path'], $match);
                                            $ytId = $match[1] ?? null;
                                        @endphp
                                        @if($ytId)
                                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $ytId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-xs p-4">
                                                <a href="{{ $slide['path'] }}" target="_blank" class="text-emerald-600 font-bold hover:underline">Buka YouTube Link</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Slide Controls -->
                        @if($totalSlides > 1)
                            <button id="prev-slide-btn" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/95 hover:bg-white text-slate-800 shadow-lg flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 z-20 border border-slate-100 hover:scale-105 active:scale-95">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button id="next-slide-btn" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/95 hover:bg-white text-slate-800 shadow-lg flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 z-20 border border-slate-100 hover:scale-105 active:scale-95">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>

                            <!-- Dot Indicators -->
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-1.5 z-20 bg-slate-900/60 px-3 py-1.5 rounded-full backdrop-blur-sm" id="slider-indicators">
                                @for($i = 0; $i < $totalSlides; $i++)
                                    <button class="w-2 h-2 rounded-full transition-all duration-300 indicator-dot {{ $i === 0 ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/70' }}" data-index="{{ $i }}"></button>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Media Gallery Thumbnails -->
                @if($totalSlides > 1)
                    <div class="grid grid-cols-4 gap-2.5">
                        @foreach($slides as $index => $slide)
                            <div class="aspect-square bg-slate-100 rounded-xl overflow-hidden border {{ $index === 0 ? 'border-emerald-500 border-2' : 'border-slate-200' }} cursor-pointer thumbnail-btn relative flex items-center justify-center transition-all duration-200 hover:opacity-90"
                                 data-index="{{ $index }}">
                                @if($slide['is_broken'])
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-rose-50 text-rose-500">
                                        <i class="fa-solid fa-image-slash text-lg"></i>
                                    </div>
                                @elseif($slide['type'] === 'image')
                                    <img src="{{ $slide['path'] }}" class="w-full h-full object-cover">
                                @elseif($slide['type'] === 'video')
                                    <video src="{{ $slide['path'] }}" class="w-full h-full object-cover" muted></video>
                                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center text-white text-xs">
                                        <i class="fa-solid fa-play"></i>
                                    </div>
                                @elseif($slide['type'] === 'youtube')
                                    <div class="w-full h-full flex items-center justify-center text-red-600 bg-slate-50">
                                        <i class="fa-brands fa-youtube text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderTrack = document.getElementById('slider-track');
    const prevBtn = document.getElementById('prev-slide-btn');
    const nextBtn = document.getElementById('next-slide-btn');
    const indicators = document.querySelectorAll('.indicator-dot');
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    const slides = document.querySelectorAll('.slide-item');
    
    let currentIndex = 0;
    const totalSlides = slides.length;

    function goToSlide(index) {
        if (totalSlides <= 1) return;
        
        // Boundaries
        if (index < 0) {
            index = totalSlides - 1;
        } else if (index >= totalSlides) {
            index = 0;
        }
        
        currentIndex = index;
        
        // Move slider track
        sliderTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
        
        // Update indicators
        indicators.forEach((dot, idx) => {
            if (idx === currentIndex) {
                dot.classList.add('bg-white', 'scale-125');
                dot.classList.remove('bg-white/40');
            } else {
                dot.classList.remove('bg-white', 'scale-125');
                dot.classList.add('bg-white/40');
            }
        });
        
        // Update thumbnails highlight
        thumbnails.forEach((thumb) => {
            const idx = parseInt(thumb.getAttribute('data-index'));
            if (idx === currentIndex) {
                thumb.classList.add('border-emerald-500', 'border-2');
                thumb.classList.remove('border-slate-200', 'border');
            } else {
                thumb.classList.remove('border-emerald-500', 'border-2');
                thumb.classList.add('border-slate-200', 'border');
            }
        });

        // Pause/stop media on non-active slides to avoid playing overlapping audios
        slides.forEach((slide, idx) => {
            if (idx !== currentIndex) {
                // Pause HTML5 video
                const video = slide.querySelector('video');
                if (video) {
                    video.pause();
                }
                // Stop YouTube iframe by resetting its src
                const iframe = slide.querySelector('iframe');
                if (iframe) {
                    const src = iframe.src;
                    iframe.src = '';
                    iframe.src = src;
                }
            }
        });
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            goToSlide(currentIndex - 1);
        });
        nextBtn.addEventListener('click', () => {
            goToSlide(currentIndex + 1);
        });
    }

    indicators.forEach(dot => {
        dot.addEventListener('click', () => {
            const idx = parseInt(dot.getAttribute('data-index'));
            goToSlide(idx);
        });
    });

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', () => {
            const idx = parseInt(thumb.getAttribute('data-index'));
            goToSlide(idx);
        });
    });
});
</script>
            
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4.5 space-y-3">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-400 font-medium">User Pengelola</span>
                    <span class="font-bold text-slate-700">{{ $katalog->user ? $katalog->user->nama : 'Umum' }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-400 font-medium">Terakhir Diperbarui</span>
                    <span class="font-bold text-slate-700">{{ $katalog->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Metadata Detail Fields -->
        <div class="w-full lg:w-2/3 flex flex-col justify-between space-y-6">
            <div class="space-y-6">
                <!-- Title & Creator -->
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">{{ $katalog->judul }}</h2>
                    <p class="text-sm font-semibold text-emerald-600 mt-2">Pencipta: {{ $katalog->pencipta }}</p>
                </div>

                <hr class="border-slate-100">

                <!-- Metadata Fields Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-xs">
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Subjek</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->subjek ?? '-' }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Penerbit</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->penerbit ?? '-' }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Kontribusi</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->kontribusi ?? '-' }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Tanggal</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->tanggal ?? '-' }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Tipe</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->tipe }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Format</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->format }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Identitas / No. Registrasi</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->identitas ?? '-' }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Sumber</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->sumber ?? '-' }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Bahasa</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->bahasa ?? '-' }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Hubungan Keterkaitan</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->hubungan ?? '-' }}</span>
                    </div>
                    <div class="border-b border-slate-50 pb-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Lokasi Temuan / Asal</span>
                        <span class="text-slate-800 font-bold text-sm flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-slate-400"></i>
                            {{ $katalog->lokasi ?? '-' }}
                        </span>
                    </div>
                    <div class="border-b border-slate-50 pb-2 sm:col-span-2">
                        <span class="text-slate-400 block font-medium mb-0.5">Hak Cipta</span>
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->hak_cipta ?? '-' }}</span>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Description -->
                <div class="space-y-2">
                    <span class="text-xs text-slate-400 block font-medium">Deskripsi</span>
                    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4.5 rounded-2xl border border-slate-100">
                        {{ $katalog->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
