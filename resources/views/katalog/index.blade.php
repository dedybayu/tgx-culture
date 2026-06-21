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
                <a href="{{ route('admin.katalog.create') }}"
                    class="inline-flex items-center gap-2 px-4.5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Katalog Baru
                </a>
            </div>
        </div>

        <!-- Catalog Container (Responsive Views) -->
        <div class="space-y-4">
            <!-- Desktop Table View -->
            <div class="hidden md:block bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-sm font-bold text-slate-800">Daftar Katalog Budaya</span>
                    <span
                        class="bg-slate-50 border border-slate-200 text-slate-500 text-xs px-2.5 py-0.5 rounded-full font-medium">{{ $katalogs->total() }}
                        Item</span>
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
                                    <td class="px-6 py-4 font-medium text-slate-500">{{ $katalogs->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-800">{{ $k->judul }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
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
                                            <a href="{{ route('admin.katalog.edit', $k->katalog_id) }}"
                                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors flex items-center justify-center"
                                                title="Ubah">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button
                                                onclick="openDeleteModal('{{ route('admin.katalog.destroy', $k->katalog_id) }}')"
                                                type="button"
                                                class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                title="Hapus">
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
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4">
                <div
                    class="bg-slate-100/50 border border-slate-200/60 rounded-xl px-4 py-2.5 flex items-center justify-between text-xs font-bold text-slate-700">
                    <span>Daftar Katalog Budaya</span>
                    <span class="bg-slate-200 text-slate-600 px-2 py-0.5 rounded-full">{{ $katalogs->total() }} Item</span>
                </div>

                @forelse($katalogs as $k)
                    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm space-y-4">
                        <div class="space-y-1">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                {{ $k->kategori ? $k->kategori->nama_kategori : '-' }}
                            </span>
                            <h3 class="text-base font-bold text-slate-800 leading-snug">{{ $k->judul }}</h3>
                            <p class="text-xs text-slate-500">Pencipta: <span
                                    class="font-medium text-slate-700">{{ $k->pencipta }}</span></p>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs text-slate-600 bg-slate-50 p-3 rounded-xl">
                            <div>
                                <span
                                    class="block text-[9px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Tipe</span>
                                <span class="font-bold text-slate-700">{{ $k->tipe }}</span>
                            </div>
                            <div>
                                <span
                                    class="block text-[9px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Format</span>
                                <span class="font-bold text-slate-700">{{ $k->format }}</span>
                            </div>
                            <div class="col-span-2 mt-1 pt-1.5 border-t border-slate-200/40">
                                <span
                                    class="block text-[9px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Lokasi</span>
                                <span class="font-semibold text-slate-700 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-slate-400 text-[10px]"></i>
                                    {{ $k->lokasi }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                            <a href="{{ route('admin.katalog.show', $k->katalog_id) }}"
                                class="inline-flex items-center justify-center gap-1 px-3 py-2 bg-slate-50 hover:bg-slate-100 text-emerald-600 text-xs font-bold rounded-xl transition-all border border-slate-100">
                                <i class="fa-solid fa-eye text-[10px]"></i>
                                Detail
                            </a>
                            <a href="{{ route('admin.katalog.edit', $k->katalog_id) }}"
                                class="inline-flex items-center justify-center gap-1 px-3 py-2 bg-slate-50 hover:bg-slate-100 text-indigo-600 text-xs font-bold rounded-xl transition-all border border-slate-100">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                Ubah
                            </a>
                            <button onclick="openDeleteModal('{{ route('admin.katalog.destroy', $k->katalog_id) }}')"
                                type="button"
                                class="inline-flex items-center justify-center gap-1 px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition-all border border-rose-100">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 text-center text-slate-400 text-sm">
                        Belum ada data katalog budaya.
                    </div>
                @endforelse
            </div>

            <!-- Pagination (Shared) -->
            @if ($katalogs->hasPages())
                <div class="px-6 py-4 border border-slate-100 bg-white rounded-2xl shadow-sm">
                    {{ $katalogs->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative w-full max-w-sm transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100 text-center">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Katalog</h3>
                <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus item katalog ini? Tindakan ini
                    tidak dapat dibatalkan.</p>
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl transition-all">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(actionUrl) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
