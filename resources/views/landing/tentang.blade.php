@extends('layouts.public')

@section('title', 'TGX Culture - Tentang Kami')

@section('content')
    <!-- Simpler and Elegant About Us Section -->
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 flex flex-col items-center justify-center min-h-[60vh]">
        <!-- Badge -->
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 mb-6">
            Profil Singkat
        </span>

        <!-- Clean Title -->
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight leading-tight text-center mb-8">
            Tentang <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">TGX
                Culture</span>
        </h1>

        <!-- Minimal Profile Card -->
        <div
            class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/50 p-8 sm:p-10 text-center relative overflow-hidden">
            <!-- Decorative subtle background blur inside card -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-100/30 rounded-full blur-2xl"></div>

            <p class="text-slate-600 leading-relaxed text-base sm:text-lg">
                <strong>TGX Culture</strong> adalah platform katalog digital resmi yang dirancang khusus untuk
                mempublikasikan, mendokumentasikan, dan melestarikan warisan budaya luhur yang tersebar di wilayah Kabupaten
                Trenggalek. Melalui inventarisasi digital yang terstruktur, kami berkomitmen untuk melestarikan nilai budaya
                lokal agar tetap hidup dan dapat diakses dengan mudah oleh generasi mendatang.
            </p>
        </div>
    </section>
@endsection
