@extends('layouts.dashboard')

@section('title', 'Profil Saya - TGX Culture')
@section('page_title', 'Profil Saya')

@section('content')
<div class="space-y-6">

    <!-- Error/Validation alert specifically for forms -->
    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 text-sm flex items-start gap-3">
            <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-500"></i>
            <div>
                <span class="font-semibold block mb-1">Gagal memperbarui data:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Left Info Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm text-center relative overflow-hidden">
                <!-- Background decoration -->
                <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-r from-emerald-500 to-teal-600"></div>
                
                <div class="relative pt-8 pb-4">
                    <!-- Avatar Initials -->
                    <div class="w-24 h-24 bg-slate-900 border-4 border-white text-white font-bold text-3xl flex items-center justify-center rounded-2xl mx-auto shadow-md">
                        {{ substr($user->nama, 0, 1) }}
                    </div>
                    
                    <h3 class="mt-4 text-xl font-bold text-slate-800">{{ $user->nama }}</h3>
                    <p class="text-sm text-slate-500 mb-3">@Htmlspecialchars($user->username)</p>
                    
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_admin ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                        <i class="fa-solid {{ $user->is_admin ? 'fa-user-shield' : 'fa-user' }} mr-1.5"></i>
                        {{ $user->is_admin ? 'Administrator' : 'User' }}
                    </span>
                </div>

                <div class="border-t border-slate-100 pt-4 mt-2 text-left space-y-3 text-sm">
                    <div class="flex justify-between items-center text-slate-500">
                        <span>Status Akun</span>
                        <span class="font-medium text-emerald-600 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Aktif
                        </span>
                    </div>
                    @if($user->created_at)
                    <div class="flex justify-between items-center text-slate-500">
                        <span>Tanggal Terdaftar</span>
                        <span class="font-medium text-slate-800">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Forms Right Area -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Edit Profile Form -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-user-pen text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Ubah Informasi Profil</h3>
                        <p class="text-xs text-slate-500">Perbarui nama lengkap dan username Anda</p>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" required value="{{ old('nama', $user->nama) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('nama')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username</label>
                        <input type="text" name="username" required value="{{ old('username', $user->username) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('username')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-lock text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Ubah Kata Sandi</h3>
                        <p class="text-xs text-slate-500">Gunakan kata sandi yang kuat untuk menjaga keamanan akun Anda</p>
                    </div>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('current_password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kata Sandi Baru</label>
                        <input type="password" name="password" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-slate-950 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-2">
                            <i class="fa-solid fa-key"></i>
                            <span>Perbarui Kata Sandi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
