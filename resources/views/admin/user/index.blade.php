@extends('layouts.dashboard')

@section('title', 'Manajemen User - TGX Culture')
@section('page_title', 'Manajemen User')

@section('content')
<div class="space-y-6">
    <!-- Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Kelola akun administrator dan petugas sistem TGX Culture.</p>
        </div>
        <div>
            <button onclick="alert('Fitur Tambah User akan segera hadir!')" class="inline-flex items-center gap-2 px-4.5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                <i class="fa-solid fa-plus"></i>
                Tambah User Baru
            </button>
        </div>
    </div>

    <!-- User Table Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <span class="text-sm font-bold text-slate-800">Daftar Pengguna</span>
            <span class="bg-slate-50 border border-slate-200 text-slate-500 text-xs px-2.5 py-0.5 rounded-full font-medium">{{ $users->total() }} Item</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Hak Akses / Role</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($users as $index => $u)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-500">{{ $users->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800">{{ $u->nama }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-slate-600">{{ $u->username }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($u->is_admin)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <i class="fa-solid fa-shield-halved mr-1 text-[10px]"></i>
                                    Administrator
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    <i class="fa-solid fa-user-gear mr-1 text-[10px]"></i>
                                    Petugas
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex gap-2 justify-center">
                                <button onclick="alert('Fitur Edit User segera hadir!')" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Ubah">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                @if($u->username === 'superadmin')
                                    <button onclick="alert('Super Admin tidak boleh dihapus!')" class="p-2 text-slate-300 cursor-not-allowed rounded-lg" title="Hapus (Dinonaktifkan)">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @else
                                    <button onclick="alert('Fitur Hapus User segera hadir!')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                            Belum ada data pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
