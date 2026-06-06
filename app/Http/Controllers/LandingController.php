<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Katalog;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $categories = Kategori::all();
        return view('landing.index', compact('categories'));
    }

    public function jelajah(Request $request)
    {
        $categories = Kategori::all();

        $query = Katalog::query()->with('kategori');

        // Filter by search keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('pencipta', 'like', '%' . $search . '%')
                  ->orWhere('subjek', 'like', '%' . $search . '%')
                  ->orWhere('tipe', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter by category selection
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Paginate
        $katalogs = $query->paginate(10)->withQueryString();

        return view('landing.jelajah', compact('categories', 'katalogs'));
    }

    public function tentang()
    {
        return view('landing.tentang');
    }

    public function show($id)
    {
        $katalog = Katalog::with(['kategori', 'user'])->findOrFail($id);
        return view('landing.show', compact('katalog'));
    }
}
