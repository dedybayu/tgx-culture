<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use Illuminate\Http\Request;

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
}
