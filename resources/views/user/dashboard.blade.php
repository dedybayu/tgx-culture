@extends('layouts.dashboard')

@section('title', 'Dashboard - TGX Culture')
@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome banner -->
    <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 overflow-hidden shadow-lg border border-slate-800">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-4">
                <i class="fa-solid fa-user-check mr-1.5"></i> Mode User
            </span>
            <h2 class="text-3xl font-extrabold text-white tracking-tight leading-tight mb-2">Halo, {{ auth()->user()->nama }}!</h2>
            <p class="text-slate-300 text-sm leading-relaxed">
                Selamat datang di panel user TGX Culture. Anda memiliki hak akses untuk mengelola data katalog budaya yang tersedia.
            </p>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Stat Card: Total Katalog Dikelola -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between group hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Katalog Dikelola Anda</span>
                <span class="text-3xl font-bold text-slate-800 block">{{ $totalKatalog }}</span>
            </div>
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500">
                <i class="fa-solid fa-book-open text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Info Section / Next Steps -->
    <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Aksi Cepat</h3>
        <div>
            <a href="{{ route('admin.katalog.index') }}" class="group flex items-center justify-between p-5 border border-slate-100 rounded-2xl hover:border-indigo-200 hover:bg-indigo-50/10 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-book-open text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 group-hover:text-indigo-700 transition-colors">Kelola Katalog</h4>
                        <p class="text-xs text-slate-400 mt-1">Ubah atau tambahkan item katalog baru untuk dipublikasikan.</p>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-right text-slate-300 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</div>
@endsection
