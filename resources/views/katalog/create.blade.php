@extends('layouts.dashboard')

@section('title', 'Tambah Katalog Baru - TGX Culture')
@section('page_title', 'Tambah Katalog Baru')

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
                <span class="font-semibold block mb-1">Gagal menyimpan katalog:</span>
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
        <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Katalog</label>
                    <input type="text" name="judul" required value="{{ old('judul') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Budaya</label>
                    <select name="kategori_id" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->kategori_id }}" {{ old('kategori_id') == $category->kategori_id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pencipta -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pencipta / Asal Usul</label>
                    <input type="text" name="pencipta" required value="{{ old('pencipta') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Subjek -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Subjek / Topik</label>
                    <input type="text" name="subjek" required value="{{ old('subjek') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Penerbit -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penerbit</label>
                    <input type="text" name="penerbit" required value="{{ old('penerbit') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Kontribusi -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pihak Berkontribusi</label>
                    <input type="text" name="kontribusi" required value="{{ old('kontribusi') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Pencatatan / Temuan</label>
                    <input type="text" name="tanggal" required value="{{ old('tanggal') }}" placeholder="Contoh: 12 Desember 2026 atau 2026-06-21" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Tipe -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe (Fisik / Non-Fisik)</label>
                    <input type="text" name="tipe" required value="{{ old('tipe', 'Fisik') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Format -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Format Media</label>
                    <input type="text" name="format" required value="{{ old('format') }}" placeholder="Contoh: Buku, Teks, Audio, Tari" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Identitas -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Identitas / Registrasi</label>
                    <input type="text" name="identitas" required value="{{ old('identitas') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Sumber -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sumber Data</label>
                    <input type="text" name="sumber" required value="{{ old('sumber') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Bahasa -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bahasa</label>
                    <input type="text" name="bahasa" required value="{{ old('bahasa', 'Indonesia') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Hubungan -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hubungan Keterkaitan</label>
                    <input type="text" name="hubungan" required value="{{ old('hubungan', '-') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Lokasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Lokasi Asal / Temuan</label>
                    <input type="text" name="lokasi" required value="{{ old('lokasi') }}" placeholder="Contoh: Kec. Watulimo" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Hak Cipta -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keterangan Hak Cipta</label>
                    <input type="text" name="hak_cipta" required value="{{ old('hak_cipta', 'Milik Publik / Disparbud Trenggalek') }}" class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Unggah Gambar Katalog (Opsional)</label>
                    <input type="file" name="path_gambar" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800">
                </div>
            </div>

            <!-- Galeri Media Tambahan -->
            <div class="border-t border-slate-100 pt-6">
                <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4">Media & Galeri Tambahan</h4>
                <div id="media-wrapper" class="space-y-4">
                    <!-- Dynamic rows will be inserted here -->
                </div>
                <button type="button" id="add-media-btn" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">
                    <i class="fa-solid fa-plus"></i> Tambah Media Baru
                </button>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Lengkap</label>
                <textarea name="deskripsi" rows="4" required class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('deskripsi') }}</textarea>
            </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('media-wrapper');
    const addBtn = document.getElementById('add-media-btn');
    let index = 0;

    function createMediaRow() {
        const div = document.createElement('div');
        div.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 p-4 rounded-2xl border border-slate-100 relative';
        div.innerHTML = `
            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tipe Media</label>
                <select name="media[${index}][type]" class="media-type-select block w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="image">Gambar (Upload)</option>
                    <option value="video">Video (Upload)</option>
                    <option value="youtube">YouTube (Link URL)</option>
                </select>
            </div>
            <div class="md:col-span-8 input-container">
                <div class="file-input-wrapper">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Unggah Berkas</label>
                    <input type="file" name="media[${index}][file]" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800">
                </div>
                <div class="link-input-wrapper hidden">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Link YouTube URL</label>
                    <input type="url" name="media[${index}][link]" placeholder="Contoh: https://www.youtube.com/watch?v=..." class="block w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
            <div class="md:col-span-1 text-right md:text-center mt-2 md:mt-6">
                <button type="button" class="remove-media-btn text-rose-600 hover:text-rose-800 transition-colors">
                    <i class="fa-solid fa-trash-can text-lg"></i>
                </button>
            </div>
        `;

        const typeSelect = div.querySelector('.media-type-select');
        const fileInputWrapper = div.querySelector('.file-input-wrapper');
        const fileInput = div.querySelector('input[type="file"]');
        const linkInputWrapper = div.querySelector('.link-input-wrapper');
        const removeBtn = div.querySelector('.remove-media-btn');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'youtube') {
                fileInputWrapper.classList.add('hidden');
                linkInputWrapper.classList.remove('hidden');
                fileInput.value = '';
            } else {
                fileInputWrapper.classList.remove('hidden');
                linkInputWrapper.classList.add('hidden');
                if (this.value === 'video') {
                    fileInput.setAttribute('accept', 'video/*');
                } else {
                    fileInput.setAttribute('accept', 'image/*');
                }
            }
        });

        removeBtn.addEventListener('click', function() {
            div.remove();
        });

        wrapper.appendChild(div);
        index++;
    }

    addBtn.addEventListener('click', createMediaRow);
});
</script>

            <!-- Action buttons -->
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.katalog.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all">Simpan Katalog</button>
            </div>
        </form>
    </div>
</div>
@endsection
