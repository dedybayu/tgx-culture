@extends('layouts.dashboard')

@section('title', 'Manajemen Kategori - TGX Culture')
@section('page_title', 'Manajemen Kategori')

@section('content')
<div class="space-y-6">
    <!-- Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Kelola dan kelompokkan katalog budaya Trenggalek berdasarkan kategori spesifik.</p>
        </div>
        <div>
            <button onclick="alert('Fitur Tambah Kategori akan segera hadir!')" class="inline-flex items-center gap-2 px-4.5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                <i class="fa-solid fa-plus"></i>
                Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Category Table Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <span class="text-sm font-bold text-slate-800">Daftar Kategori</span>
            <span class="bg-slate-50 border border-slate-200 text-slate-500 text-xs px-2.5 py-0.5 rounded-full font-medium">{{ $categories->total() }} Item</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Path Gambar</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($categories as $index => $k)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-500">{{ $categories->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800">{{ $k->nama_kategori }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-slate-50 px-2 py-1 rounded border border-slate-100 text-slate-600">{{ $k->path_gambar }}</code>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex gap-2 justify-center">
                                <button onclick="alert('Fitur Edit Kategori segera hadir!')" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Ubah">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="alert('Fitur Hapus Kategori segera hadir!')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                            Belum ada data kategori.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
