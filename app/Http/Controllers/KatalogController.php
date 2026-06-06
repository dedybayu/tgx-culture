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
            'deskripsi' => ['required', 'string'],
            'pencipta' => ['required', 'string', 'max:255'],
            'subjek' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'kontribusi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'tipe' => ['required', 'string', 'max:255'],
            'format' => ['required', 'string', 'max:255'],
            'identitas' => ['required', 'string', 'max:255'],
            'sumber' => ['required', 'string', 'max:255'],
            'bahasa' => ['required', 'string', 'max:255'],
            'hubungan' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'hak_cipta' => ['required', 'string', 'max:255'],
            'path_gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $path = 'katalog/default.jpg';
        if ($request->hasFile('path_gambar')) {
            $file = $request->file('path_gambar');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/katalog'))) {
                mkdir(public_path('uploads/katalog'), 0755, true);
            }
            
            $file->move(public_path('uploads/katalog'), $filename);
            $path = 'uploads/katalog/' . $filename;
        }

        Katalog::create([
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
            'path_gambar' => $path,
        ]);

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
            'deskripsi' => ['required', 'string'],
            'pencipta' => ['required', 'string', 'max:255'],
            'subjek' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'kontribusi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'tipe' => ['required', 'string', 'max:255'],
            'format' => ['required', 'string', 'max:255'],
            'identitas' => ['required', 'string', 'max:255'],
            'sumber' => ['required', 'string', 'max:255'],
            'bahasa' => ['required', 'string', 'max:255'],
            'hubungan' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'hak_cipta' => ['required', 'string', 'max:255'],
            'path_gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $path = $katalog->path_gambar;
        if ($request->hasFile('path_gambar')) {
            // Delete old file if exists in uploads/katalog
            if ($katalog->path_gambar && Str::startsWith($katalog->path_gambar, 'uploads/') && file_exists(public_path($katalog->path_gambar))) {
                @unlink(public_path($katalog->path_gambar));
            }

            $file = $request->file('path_gambar');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/katalog'))) {
                mkdir(public_path('uploads/katalog'), 0755, true);
            }
            
            $file->move(public_path('uploads/katalog'), $filename);
            $path = 'uploads/katalog/' . $filename;
        }

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
            'path_gambar' => $path,
        ]);

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

        // Delete image file if exists
        if ($katalog->path_gambar && Str::startsWith($katalog->path_gambar, 'uploads/') && file_exists(public_path($katalog->path_gambar))) {
            @unlink(public_path($katalog->path_gambar));
        }

        $katalog->delete();

        return redirect()->route('admin.katalog.index')
            ->with('success', 'Katalog "' . $katalog->judul . '" berhasil dihapus.');
    }
}
