<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Kategori::paginate(10);
        return view('admin.kategori.index', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:m_kategori,nama_kategori'],
            'path_gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('path_gambar')) {
            $file = $request->file('path_gambar');
            $filename = time() . '_' . Str::slug($request->nama_kategori) . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            if (!file_exists(public_path('uploads/kategori'))) {
                mkdir(public_path('uploads/kategori'), 0755, true);
            }
            
            $file->move(public_path('uploads/kategori'), $filename);
            $path = 'uploads/kategori/' . $filename;
        } else {
            // Assign a default placeholder path based on slug
            $path = 'kategori/' . Str::slug($request->nama_kategori) . '.jpg';
        }

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'path_gambar' => $path,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori "' . $request->nama_kategori . '" berhasil ditambahkan.');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:m_kategori,nama_kategori,' . $id . ',kategori_id'],
            'path_gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $path = $kategori->path_gambar;
        if ($request->hasFile('path_gambar')) {
            // Delete old file if it exists in uploads/kategori
            if ($kategori->path_gambar && Str::startsWith($kategori->path_gambar, 'uploads/') && file_exists(public_path($kategori->path_gambar))) {
                @unlink(public_path($kategori->path_gambar));
            }

            $file = $request->file('path_gambar');
            $filename = time() . '_' . Str::slug($request->nama_kategori) . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            if (!file_exists(public_path('uploads/kategori'))) {
                mkdir(public_path('uploads/kategori'), 0755, true);
            }
            
            $file->move(public_path('uploads/kategori'), $filename);
            $path = 'uploads/kategori/' . $filename;
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'path_gambar' => $path,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Prevent deletion if category is in use by catalogs
        if ($kategori->katalog()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih memiliki katalog terhubung.');
        }

        // Delete image file if exists in uploads/kategori
        if ($kategori->path_gambar && Str::startsWith($kategori->path_gambar, 'uploads/') && file_exists(public_path($kategori->path_gambar))) {
            @unlink(public_path($kategori->path_gambar));
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }
}
