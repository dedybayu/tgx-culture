@extends('layouts.dashboard')

@section('title', 'Manajemen Katalog - TGX Culture')
@section('page_title', 'Manajemen Katalog')

@section('content')
<div class="space-y-6">
    <!-- Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Kelola koleksi warisan budaya Kabupaten Trenggalek yang dipublikasikan.</p>
        </div>
        <div>
            <button onclick="alert('Fitur Tambah Katalog akan segera hadir!')" class="inline-flex items-center gap-2 px-4.5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                <i class="fa-solid fa-plus"></i>
                Tambah Katalog Baru
            </button>
        </div>
    </div>

    <!-- Catalog Table Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <span class="text-sm font-bold text-slate-800">Daftar Katalog Budaya</span>
            <span class="bg-slate-50 border border-slate-200 text-slate-500 text-xs px-2.5 py-0.5 rounded-full font-medium">{{ $katalogs->total() }} Item</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Pencipta</th>
                        <th class="px-6 py-4">Tipe / Format</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($katalogs as $index => $k)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-500">{{ $katalogs->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800">{{ $k->judul }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                {{ $k->kategori ? $k->kategori->nama_kategori : '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $k->pencipta }}
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            <span class="block font-medium text-slate-700">{{ $k->tipe }}</span>
                            <span class="block text-xs text-slate-400">{{ $k->format }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>
                            {{ $k->lokasi }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex gap-2 justify-center">
                                <a href="{{ route('admin.katalog.show', $k->katalog_id) }}" 
                                    class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors flex items-center justify-center" 
                                    title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button onclick="alert('Fitur Edit Katalog segera hadir!')" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Ubah">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="alert('Fitur Hapus Katalog segera hadir!')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                            Belum ada data katalog budaya.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($katalogs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $katalogs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
