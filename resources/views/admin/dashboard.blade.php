@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - TGX Culture')
@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome banner -->
    <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 overflow-hidden shadow-lg border border-slate-800">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -top-20 w-80 h-80 bg-rose-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-4">
                <i class="fa-solid fa-crown mr-1.5"></i> Admin Mode
            </span>
            <h2 class="text-3xl font-extrabold text-white tracking-tight leading-tight mb-2">Halo, {{ auth()->user()->nama }}!</h2>
            <p class="text-slate-300 text-sm leading-relaxed">
                Selamat datang di panel admin TGX Culture. Anda memiliki hak akses penuh untuk memantau data kategori, katalog budaya, dan manajemen pengguna sistem.
            </p>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between group hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Kategori Budaya</span>
                <span class="text-3xl font-bold text-slate-800 block">11</span>
                <span class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>Tersinkronisasi</span>
                </span>
            </div>
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-tags text-2xl"></i>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between group hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Katalog</span>
                <span class="text-3xl font-bold text-slate-800 block">22</span>
                <span class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>Tersedia Publik</span>
                </span>
            </div>
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-book-open text-2xl"></i>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between group hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Pengguna</span>
                <span class="text-3xl font-bold text-slate-800 block">2</span>
                <span class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-shield-check"></i>
                    <span>Sistem Terlindungi</span>
                </span>
            </div>
            <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-users text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Info Section / Next Steps -->
    <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Navigasi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('admin.kategori.index') }}" class="group block p-5 border border-slate-100 rounded-2xl hover:border-emerald-200 hover:bg-emerald-50/10 transition-all">
                <i class="fa-solid fa-tags text-emerald-500 text-lg mb-3"></i>
                <h4 class="font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">Kelola Kategori &rarr;</h4>
                <p class="text-xs text-slate-400 mt-1">Ubah atau tambahkan kategori warisan budaya Trenggalek.</p>
            </a>
            <a href="{{ route('admin.katalog.index') }}" class="group block p-5 border border-slate-100 rounded-2xl hover:border-indigo-200 hover:bg-indigo-50/10 transition-all">
                <i class="fa-solid fa-book-open text-indigo-500 text-lg mb-3"></i>
                <h4 class="font-bold text-slate-800 group-hover:text-indigo-700 transition-colors">Kelola Katalog &rarr;</h4>
                <p class="text-xs text-slate-400 mt-1">Kelola data item katalog budaya yang dipublikasikan.</p>
            </a>
            <a href="{{ route('admin.user.index') }}" class="group block p-5 border border-slate-100 rounded-2xl hover:border-rose-200 hover:bg-rose-50/10 transition-all">
                <i class="fa-solid fa-users text-rose-500 text-lg mb-3"></i>
                <h4 class="font-bold text-slate-800 group-hover:text-rose-700 transition-colors">Kelola User &rarr;</h4>
                <p class="text-xs text-slate-400 mt-1">Atur pengguna sistem dan hak akses akun user.</p>
            </a>
        </div>
    </div>
</div>
@endsection
