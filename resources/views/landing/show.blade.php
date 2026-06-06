@extends('layouts.public')

@section('title', $katalog->judul . ' - TGX Culture')

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

    $kategoriNama = $katalog->kategori ? $katalog->kategori->nama_kategori : '-';
    $localFileExists = $katalog->path_gambar && file_exists(public_path($katalog->path_gambar));
    
    // Choose fallback based on category name
    $fallbackUrl = $fallbackImages[$kategoriNama] ?? 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?auto=format&fit=crop&w=600&q=80';
    $imgUrl = $localFileExists ? asset($katalog->path_gambar) : $fallbackUrl;
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
            <div class="w-full aspect-[3/4] bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-inner flex items-center justify-center relative group">
                <img src="{{ $imgUrl }}" alt="{{ $katalog->judul }}" 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-600/90 text-white backdrop-blur-sm border border-emerald-500/20">
                    {{ $kategoriNama }}
                </span>
            </div>
            
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
                        <span class="text-slate-800 font-bold text-sm">{{ $katalog->tanggal ? $katalog->tanggal->format('d F Y') : '-' }}</span>
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
