@extends('layouts.dashboard')

@section('title', 'Ubah Katalog - TGX Culture')
@section('page_title', 'Ubah Katalog')

@section('content')
<div class="space-y-6">
    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.katalog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Katalog
        </a>
    </div>

    <!-- Error/Validation alert -->
    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 text-sm flex items-start gap-3">
            <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-500"></i>
            <div>
                <span class="font-semibold block mb-1">Gagal memperbarui katalog:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form wrapper -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm">
        <form id="editKatalogForm" action="{{ route('admin.katalog.update', $katalog->katalog_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Katalog</label>
                    <input type="text" name="judul" required value="{{ old('judul', $katalog->judul) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Budaya</label>
                    <select name="kategori_id" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->kategori_id }}" {{ old('kategori_id', $katalog->kategori_id) == $category->kategori_id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pencipta -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pencipta / Asal Usul</label>
                    <input type="text" name="pencipta" required value="{{ old('pencipta', $katalog->pencipta) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Subjek -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Subjek / Topik</label>
                    <input type="text" name="subjek" required value="{{ old('subjek', $katalog->subjek) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Penerbit -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penerbit</label>
                    <input type="text" name="penerbit" required value="{{ old('penerbit', $katalog->penerbit) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Kontribusi -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pihak Berkontribusi</label>
                    <input type="text" name="kontribusi" required value="{{ old('kontribusi', $katalog->kontribusi) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Pencatatan / Temuan</label>
                    <input type="date" name="tanggal" required value="{{ old('tanggal', $katalog->tanggal ? $katalog->tanggal->format('Y-m-d') : '') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Tipe -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe (Fisik / Non-Fisik)</label>
                    <input type="text" name="tipe" required value="{{ old('tipe', $katalog->tipe) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Format -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Format Media</label>
                    <input type="text" name="format" required value="{{ old('format', $katalog->format) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Identitas -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Identitas / Registrasi</label>
                    <input type="text" name="identitas" required value="{{ old('identitas', $katalog->identitas) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Sumber -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sumber Data</label>
                    <input type="text" name="sumber" required value="{{ old('sumber', $katalog->sumber) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Bahasa -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bahasa</label>
                    <input type="text" name="bahasa" required value="{{ old('bahasa', $katalog->bahasa) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Hubungan -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hubungan Keterkaitan</label>
                    <input type="text" name="hubungan" required value="{{ old('hubungan', $katalog->hubungan) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Lokasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Lokasi Asal / Temuan</label>
                    <input type="text" name="lokasi" required value="{{ old('lokasi', $katalog->lokasi) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Hak Cipta -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keterangan Hak Cipta</label>
                    <input type="text" name="hak_cipta" required value="{{ old('hak_cipta', $katalog->hak_cipta) }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Gambar -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gambar Saat Ini</label>
                    <div class="w-32 h-32 rounded-lg overflow-hidden border border-slate-100 bg-slate-50 flex items-center justify-center">
                        @php
                            $localFileExists = $katalog->path_gambar && file_exists(public_path($katalog->path_gambar));
                            $imgUrl = $localFileExists ? asset($katalog->path_gambar) : 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?auto=format&fit=crop&w=400&q=80';
                        @endphp
                        <img src="{{ $imgUrl }}" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ganti Gambar (Opsional)</label>
                    <input type="file" name="path_gambar" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800">
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Lengkap</label>
                <textarea name="deskripsi" rows="4" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('deskripsi', $katalog->deskripsi) }}</textarea>
            </div>

            <!-- Action buttons -->
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.katalog.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</a>
                <button onclick="openConfirmSaveModal()" type="button" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Save Changes Modal -->
<div id="confirmSaveModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeConfirmSaveModal()"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-sm transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100 text-center">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-floppy-disk text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">Simpan Perubahan</h3>
            <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin semua data katalog yang Anda masukkan sudah benar dan ingin menyimpannya?</p>
            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeConfirmSaveModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                <button type="button" onclick="document.getElementById('editKatalogForm').submit()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all">Ya, Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openConfirmSaveModal() {
        // Run HTML5 validation check before opening the modal
        const form = document.getElementById('editKatalogForm');
        if (form.checkValidity()) {
            document.getElementById('confirmSaveModal').classList.remove('hidden');
        } else {
            form.reportValidity();
        }
    }
    function closeConfirmSaveModal() {
        document.getElementById('confirmSaveModal').classList.add('hidden');
    }
</script>
@endsection
