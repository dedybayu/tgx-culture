<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KatalogController extends Controller
{
    /**
     * Display a listing of catalogs.
     */
    public function index()
    {
        $katalogs = Katalog::where('user_id', auth()->id())
            ->with(['kategori', 'user'])
            ->paginate(10);
        return view('katalog.index', compact('katalogs'));
    }

    /**
     * Show the form for creating a new catalog.
     */
    public function create()
    {
        $categories = Kategori::all();
        return view('katalog.create', compact('categories'));
    }

    /**
     * Store a newly created catalog.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => ['required', 'exists:m_kategori,kategori_id'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'pencipta' => ['nullable', 'string', 'max:255'],
            'subjek' => ['nullable', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'kontribusi' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['nullable', 'string', 'max:255'],
            'tipe' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:255'],
            'identitas' => ['nullable', 'string', 'max:255'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'bahasa' => ['nullable', 'string', 'max:255'],
            'hubungan' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'hak_cipta' => ['nullable', 'string', 'max:255'],
            'path_gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $katalog = Katalog::create([
            'kategori_id' => $request->kategori_id,
            'user_id' => auth()->id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'pencipta' => $request->pencipta,
            'subjek' => $request->subjek,
            'penerbit' => $request->penerbit,
            'kontribusi' => $request->kontribusi,
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'format' => $request->input('format'),
            'identitas' => $request->identitas,
            'sumber' => $request->sumber,
            'bahasa' => $request->bahasa,
            'hubungan' => $request->hubungan,
            'lokasi' => $request->lokasi,
            'hak_cipta' => $request->hak_cipta,
        ]);

        if ($request->hasFile('path_gambar')) {
            $file = $request->file('path_gambar');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/katalog'))) {
                mkdir(public_path('uploads/katalog'), 0755, true);
            }
            
            $file->move(public_path('uploads/katalog'), $filename);
            $path = 'uploads/katalog/' . $filename;

            $katalog->mediaKatalogs()->create([
                'type' => 'image',
                'path_link' => $path,
            ]);
        }

        // Process multiple media items
        $mediaItems = $request->input('media', []);
        $mediaFiles = $request->file('media', []);

        foreach ($mediaItems as $index => $item) {
            $type = $item['type'] ?? null;
            if (!$type) continue;

            $path_link = '';
            if ($type === 'youtube') {
                $path_link = $item['link'] ?? '';
            } else {
                $file = $mediaFiles[$index]['file'] ?? null;
                if ($file) {
                    $filename = time() . '_' . Str::slug($katalog->judul) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    if (!file_exists(public_path('uploads/katalog'))) {
                        mkdir(public_path('uploads/katalog'), 0755, true);
                    }
                    
                    $file->move(public_path('uploads/katalog'), $filename);
                    $path_link = 'uploads/katalog/' . $filename;
                }
            }

            if ($path_link) {
                $katalog->mediaKatalogs()->create([
                    'type' => $type,
                    'path_link' => $path_link,
                ]);
            }
        }

        return redirect()->route('admin.katalog.index')
            ->with('success', 'Katalog "' . $request->judul . '" berhasil ditambahkan.');
    }

    /**
     * Display the specified catalog.
     */
    public function show($id)
    {
        $katalog = Katalog::with(['kategori', 'user'])->findOrFail($id);

        // Authorize that the catalog belongs to the logged-in user
        if ($katalog->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat katalog ini.');
        }

        return view('katalog.show', compact('katalog'));
    }

    /**
     * Show the form for editing the specified catalog.
     */
    public function edit($id)
    {
        $katalog = Katalog::findOrFail($id);

        // Authorize owner
        if ($katalog->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah katalog ini.');
        }

        $categories = Kategori::all();
        return view('katalog.edit', compact('katalog', 'categories'));
    }

    /**
     * Update the specified catalog.
     */
    public function update(Request $request, $id)
    {
        $katalog = Katalog::findOrFail($id);

        // Authorize owner
        if ($katalog->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk memperbarui katalog ini.');
        }

        $request->validate([
            'kategori_id' => ['required', 'exists:m_kategori,kategori_id'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'pencipta' => ['nullable', 'string', 'max:255'],
            'subjek' => ['nullable', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'kontribusi' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['nullable', 'string', 'max:255'],
            'tipe' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:255'],
            'identitas' => ['nullable', 'string', 'max:255'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'bahasa' => ['nullable', 'string', 'max:255'],
            'hubungan' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'hak_cipta' => ['nullable', 'string', 'max:255'],
            'path_gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $katalog->update([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'pencipta' => $request->pencipta,
            'subjek' => $request->subjek,
            'penerbit' => $request->penerbit,
            'kontribusi' => $request->kontribusi,
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'format' => $request->input('format'),
            'identitas' => $request->identitas,
            'sumber' => $request->sumber,
            'bahasa' => $request->bahasa,
            'hubungan' => $request->hubungan,
            'lokasi' => $request->lokasi,
            'hak_cipta' => $request->hak_cipta,
        ]);

        // Handle deleted media items
        $deletedMediaIds = $request->input('deleted_media', []);
        if (!empty($deletedMediaIds)) {
            $mediaToDelete = $katalog->mediaKatalogs()->whereIn('media_katalog_id', $deletedMediaIds)->get();
            foreach ($mediaToDelete as $media) {
                if (in_array($media->type, ['image', 'video']) && Str::startsWith($media->path_link, 'uploads/') && file_exists(public_path($media->path_link))) {
                    @unlink(public_path($media->path_link));
                }
                $media->delete();
            }
        }

        // Handle updated existing media items
        $existingMediaData = $request->input('media_existing', []);
        $existingMediaFiles = $request->file('media_existing_files', []);
        foreach ($existingMediaData as $mediaId => $data) {
            $media = $katalog->mediaKatalogs()->find($mediaId);
            if ($media) {
                $type = $data['type'] ?? $media->type;
                $path_link = $media->path_link;
                
                if ($type === 'youtube') {
                    $path_link = $data['link'] ?? '';
                    // delete old file if it was a local file
                    if (in_array($media->type, ['image', 'video']) && Str::startsWith($media->path_link, 'uploads/') && file_exists(public_path($media->path_link))) {
                        @unlink(public_path($media->path_link));
                    }
                } else {
                    $file = $existingMediaFiles[$mediaId] ?? null;
                    if ($file) {
                        // delete old file
                        if (in_array($media->type, ['image', 'video']) && Str::startsWith($media->path_link, 'uploads/') && file_exists(public_path($media->path_link))) {
                            @unlink(public_path($media->path_link));
                        }
                        
                        $filename = time() . '_' . Str::slug($katalog->judul) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/katalog'), $filename);
                        $path_link = 'uploads/katalog/' . $filename;
                    }
                }
                
                $media->update([
                    'type' => $type,
                    'path_link' => $path_link
                ]);
            }
        }

        if ($request->hasFile('path_gambar')) {
            $firstGambar = $katalog->mediaKatalogs()->where('type', 'image')->first();
            if ($firstGambar) {
                if (Str::startsWith($firstGambar->path_link, 'uploads/') && file_exists(public_path($firstGambar->path_link))) {
                    @unlink(public_path($firstGambar->path_link));
                }
            }

            $file = $request->file('path_gambar');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/katalog'))) {
                mkdir(public_path('uploads/katalog'), 0755, true);
            }
            
            $file->move(public_path('uploads/katalog'), $filename);
            $path = 'uploads/katalog/' . $filename;

            if ($firstGambar) {
                $firstGambar->update(['path_link' => $path]);
            } else {
                $katalog->mediaKatalogs()->create([
                    'type' => 'image',
                    'path_link' => $path,
                ]);
            }
        }

        // Process multiple new media items
        $mediaItems = $request->input('media', []);
        $mediaFiles = $request->file('media', []);

        foreach ($mediaItems as $index => $item) {
            $type = $item['type'] ?? null;
            if (!$type) continue;

            $path_link = '';
            if ($type === 'youtube') {
                $path_link = $item['link'] ?? '';
            } else {
                $file = $mediaFiles[$index]['file'] ?? null;
                if ($file) {
                    $filename = time() . '_' . Str::slug($katalog->judul) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    if (!file_exists(public_path('uploads/katalog'))) {
                        mkdir(public_path('uploads/katalog'), 0755, true);
                    }
                    
                    $file->move(public_path('uploads/katalog'), $filename);
                    $path_link = 'uploads/katalog/' . $filename;
                }
            }

            if ($path_link) {
                $katalog->mediaKatalogs()->create([
                    'type' => $type,
                    'path_link' => $path_link,
                ]);
            }
        }

        return redirect()->route('admin.katalog.index')
            ->with('success', 'Katalog berhasil diperbarui.');
    }

    /**
     * Remove the specified catalog.
     */
    public function destroy($id)
    {
        $katalog = Katalog::findOrFail($id);

        // Authorize owner
        if ($katalog->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus katalog ini.');
        }

        // Delete all physical files of associated media
        foreach ($katalog->mediaKatalogs as $gambar) {
            if (in_array($gambar->type, ['image', 'video']) && Str::startsWith($gambar->path_link, 'uploads/') && file_exists(public_path($gambar->path_link))) {
                @unlink(public_path($gambar->path_link));
            }
        }

        $katalog->delete();

        return redirect()->route('admin.katalog.index')
            ->with('success', 'Katalog "' . $katalog->judul . '" berhasil dihapus.');
    }
}
