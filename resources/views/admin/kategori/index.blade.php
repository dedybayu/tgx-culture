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
            <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4.5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                <i class="fa-solid fa-plus"></i>
                Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Error/Validation alert -->
    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-xl p-4 text-sm flex items-start gap-3">
            <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-500"></i>
            <div>
                <span class="font-semibold block mb-1">Gagal menyimpan data:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

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
                        <th class="px-6 py-4">Gambar</th>
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
                            <div class="w-12 h-12 rounded-lg overflow-hidden border border-slate-100 bg-slate-50 flex items-center justify-center">
                                @php
                                    $localFileExists = $k->path_gambar && file_exists(public_path($k->path_gambar));
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
                                    $imgUrl = $localFileExists ? asset($k->path_gambar) : ($fallbackImages[$k->nama_kategori] ?? 'https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?q=80&w=600&auto=format&fit=crop');
                                @endphp
                                <img src="{{ $imgUrl }}" alt="{{ $k->nama_kategori }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800">{{ $k->nama_kategori }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-slate-50 px-2 py-1 rounded border border-slate-100 text-slate-600">{{ $k->path_gambar }}</code>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex gap-2 justify-center">
                                <button onclick="openEditModal(this)" 
                                    class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" 
                                    title="Ubah"
                                    data-id="{{ $k->kategori_id }}"
                                    data-nama="{{ $k->nama_kategori }}"
                                    data-gambar="{{ $imgUrl }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="openDeleteModal('{{ route('admin.kategori.destroy', $k->kategori_id) }}')" type="button" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">
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

<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAddModal()"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Kategori</h3>
            <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Gambar (Opsional)</label>
                    <input type="file" name="path_gambar" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800">
                </div>
                <div class="pt-4 flex justify-end gap-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Ubah Kategori</h3>
            <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kategori</label>
                    <input type="text" id="editNama" name="nama_kategori" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gambar Saat Ini</label>
                    <div class="w-24 h-24 rounded-lg overflow-hidden border border-slate-100 mb-2">
                        <img id="editImagePreview" src="" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ganti Gambar (Opsional)</label>
                    <input type="file" name="path_gambar" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800">
                </div>
                <div class="pt-4 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-sm transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100 text-center">
            <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-trash-can text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Kategori</h3>
            <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus kategori ini? Semua katalog yang terhubung akan kehilangan kategorinya.</p>
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl transition-all">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
    function openEditModal(btn) {
        const id = btn.dataset.id;
        const nama = btn.dataset.nama;
        const gambar = btn.dataset.gambar;

        document.getElementById('editForm').action = `/admin/kategori/${id}`;
        document.getElementById('editNama').value = nama;
        document.getElementById('editImagePreview').src = gambar;

        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    function openDeleteModal(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
