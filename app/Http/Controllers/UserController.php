<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:m_user,username'],
            'password' => ['required', 'string', 'min:6'],
            'is_admin' => ['required', 'boolean'],
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_admin' => (bool) $request->is_admin,
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User "' . $request->nama . '" berhasil ditambahkan.');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:m_user,username,' . $id . ',user_id'],
            'password' => ['nullable', 'string', 'min:6'],
            'is_admin' => ['required', 'boolean'],
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'is_admin' => (bool) $request->is_admin,
        ];

        // Do not allow changing own admin status to non-admin
        if ($user->user_id === auth()->id() && !$data['is_admin']) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Anda tidak dapat menghapus hak akses administrator Anda sendiri.');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting superadmin
        if ($user->username === 'superadmin') {
            return redirect()->route('admin.user.index')
                ->with('error', 'Akun "superadmin" utama tidak boleh dihapus.');
        }

        // Prevent deleting own account
        if ($user->user_id === auth()->id()) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User "' . $user->nama . '" berhasil dihapus.');
    }

    /**
     * Show the profile page of the authenticated user.
     */
    public function showProfile()
    {
        $user = auth()->user();
        return view('profile.profile', compact('user'));
    }

    /**
     * Update the authenticated user's profile details.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:m_user,username,' . $user->user_id . ',user_id'],
        ]);

        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
        ]);

        return redirect()->route('profile')
            ->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile')
                ->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok dengan data kami.'])
                ->with('error', 'Gagal memperbarui kata sandi. Kata sandi saat ini salah.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')
            ->with('success', 'Kata sandi Anda berhasil diperbarui.');
    }
}
