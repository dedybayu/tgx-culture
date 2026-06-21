<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\MediaKatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaKatalogController extends Controller
{
    /**
     * Display a listing of catalog media.
     */
    // public function index($katalog_id)
    // {
    //     $katalog = Katalog::findOrFail($katalog_id);

    //     // Authorize that the catalog belongs to the logged-in user
    //     if ($katalog->user_id !== auth()->id()) {
    //         abort(403, 'Anda tidak memiliki hak akses untuk melihat gambar katalog ini.');
    //     }

    //     $mediaKatalogs = $katalog->mediaKatalogs;

    //     return view('katalog.gambar', compact('katalog', 'mediaKatalogs'));
    // }

    /**
     * Store a newly created catalog media in storage.
     */
    public function store(Request $request, $katalog_id)
    {
        $katalog = Katalog::findOrFail($katalog_id);

        // Authorize ownership
        if ($katalog->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambahkan gambar ke katalog ini.');
        }

        $request->validate([
            'type' => ['required', 'in:image,video,youtube'],
            'file' => ['required_if:type,image,video', 'file', 'max:10240'],
            'path_link' => ['required_if:type,youtube', 'nullable', 'string', 'url', 'max:255'],
        ]);

        $path_link = '';
        if ($request->type === 'youtube') {
            $path_link = $request->path_link;
        } else {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . Str::slug($katalog->judul) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                if (!file_exists(public_path('uploads/katalog'))) {
                    mkdir(public_path('uploads/katalog'), 0755, true);
                }
                
                $file->move(public_path('uploads/katalog'), $filename);
                $path_link = 'uploads/katalog/' . $filename;
            }
        }

        $katalog->mediaKatalogs()->create([
            'type' => $request->type,
            'path_link' => $path_link,
        ]);

        return redirect()->back()->with('success', 'Media katalog berhasil ditambahkan.');
    }

    /**
     * Remove the specified catalog media from storage.
     */
    public function destroy($katalog_id, $id)
    {
        $katalog = Katalog::findOrFail($katalog_id);

        // Authorize ownership
        if ($katalog->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus gambar dari katalog ini.');
        }

        $mediaKatalog = $katalog->mediaKatalogs()->findOrFail($id);

        // Delete file if exists on server
        if (in_array($mediaKatalog->type, ['image', 'video']) && Str::startsWith($mediaKatalog->path_link, 'uploads/') && file_exists(public_path($mediaKatalog->path_link))) {
            @unlink(public_path($mediaKatalog->path_link));
        }

        $mediaKatalog->delete();

        return redirect()->back()->with('success', 'Media katalog berhasil dihapus.');
    }
}
