<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

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
}
