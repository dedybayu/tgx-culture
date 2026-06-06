<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Katalog;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with overview statistics.
     */
    public function admin()
    {
        $totalKategori = Kategori::count();
        $totalKatalog = Katalog::where('user_id', auth()->id())->count();
        $totalUser = User::count();
        return view('admin.dashboard', compact('totalKategori', 'totalKatalog', 'totalUser'));
    }

    /**
     * Show the user dashboard with personal statistics.
     */
    public function user()
    {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        $totalKatalog = Katalog::where('user_id', auth()->id())->count();
        return view('user.dashboard', compact('totalKatalog'));
    }
}
