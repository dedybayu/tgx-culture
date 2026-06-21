@extends('layouts.dashboard')

@section('title', 'Manajemen User - TGX Culture')
@section('page_title', 'Manajemen User')

@section('content')
    <div class="space-y-6">
        <!-- Action Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-slate-500">Kelola akun administrator dan user sistem TGX Culture.</p>
            </div>
            <div>
                <button onclick="openAddModal()"
                    class="inline-flex items-center gap-2 px-4.5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                    <i class="fa-solid fa-plus"></i>
                    Tambah User Baru
                </button>
            </div>
        </div>

        <!-- Error/Validation alert -->
        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-xl p-4 text-sm flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-500"></i>
                <div>
                    <span class="font-semibold block mb-1">Gagal menyimpan data:</span>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- User Table Card -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <span class="text-sm font-bold text-slate-800">Daftar Pengguna</span>
                <span
                    class="bg-slate-50 border border-slate-200 text-slate-500 text-xs px-2.5 py-0.5 rounded-full font-medium">{{ $users->total() }}
                    Item</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Username</th>
                            <th class="px-6 py-4">Hak Akses / Role</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($users as $index => $u)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-500">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800">{{ $u->nama }}
                                        @if ($u->user_id === auth()->id())
                                            <span class="ml-1 text-slate-500">(Anda)</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-600">{{ $u->username }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($u->is_admin)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            <i class="fa-solid fa-shield-halved mr-1 text-[10px]"></i>
                                            Administrator
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                            <i class="fa-solid fa-user-gear mr-1 text-[10px]"></i>
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex gap-2 justify-center">
                                        @if ($u->user_id === auth()->id())
                                            <button
                                                onclick="openWarningModal('Anda tidak dapat mengubah data Anda sendiri dari halaman manajemen user. Silakan ubah melalui menu Profil Saya!')"
                                                type="button"
                                                class="p-2 text-slate-300 hover:bg-slate-50 hover:text-slate-400 rounded-lg transition-colors"
                                                title="Ubah (Dinonaktifkan)">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        @else
                                            <button onclick="openEditModal(this)"
                                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                title="Ubah" data-id="{{ $u->user_id }}" data-nama="{{ $u->nama }}"
                                                data-username="{{ $u->username }}"
                                                data-is_admin="{{ $u->is_admin ? 1 : 0 }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        @endif
                                        @if ($u->username === 'superadmin' || $u->user_id === auth()->id())
                                            <button
                                                onclick="openWarningModal('User ini tidak boleh dihapus karena merupakan akun superadmin atau akun yang sedang Anda gunakan saat ini!')"
                                                type="button"
                                                class="p-2 text-slate-300 hover:bg-slate-50 hover:text-slate-400 rounded-lg transition-colors"
                                                title="Hapus (Dinonaktifkan)">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        @else
                                            <button
                                                onclick="openDeleteModal('{{ route('admin.user.destroy', $u->user_id) }}')"
                                                type="button"
                                                class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                    Belum ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAddModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah User Baru</h3>
                <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama
                            Lengkap</label>
                        <input type="text" name="nama" required
                            class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username</label>
                        <input type="text" name="username" required
                            class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter"
                            class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hak Akses /
                            Role</label>
                        <select name="is_admin" required
                            class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="0">User</option>
                            <option value="1">Administrator</option>
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-2">
                        <button type="button" onclick="closeAddModal()"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Ubah User</h3>
                <form id="editForm" action="" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama
                            Lengkap</label>
                        <input type="text" id="editNama" name="nama" required
                            class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username</label>
                        <input type="text" id="editUsername" name="username" required
                            class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Baru
                            (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter"
                            class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hak Akses /
                            Role</label>
                        <select id="editIsAdmin" name="is_admin" required
                            class="block w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="0">User</option>
                            <option value="1">Administrator</option>
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-2">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition-all">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative w-full max-w-sm transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100 text-center">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus User</h3>
                <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus user ini? Semua katalog yang
                    dibuat oleh user ini akan tetap ada namun kepemilikannya akan menjadi kosong.</p>
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl transition-all">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Warning / Protected User Modal -->
    <div id="warningModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeWarningModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative w-full max-w-sm transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100 text-center">
                <div
                    class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-circle-exclamation text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Aksi Ditolak</h3>
                <p id="warningText" class="text-sm text-slate-500 mb-6"></p>
                <div class="flex justify-center">
                    <button type="button" onclick="closeWarningModal()"
                        class="px-6 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all">Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addUserModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addUserModal').classList.add('hidden');
        }

        function openEditModal(btn) {
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;
            const username = btn.dataset.username;
            const is_admin = btn.dataset.is_admin;

            document.getElementById('editForm').action = `/admin/user/${id}`;
            document.getElementById('editNama').value = nama;
            document.getElementById('editUsername').value = username;
            document.getElementById('editIsAdmin').value = is_admin;

            document.getElementById('editUserModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editUserModal').classList.add('hidden');
        }

        function openDeleteModal(actionUrl) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function openWarningModal(message) {
            document.getElementById('warningText').innerText = message;
            document.getElementById('warningModal').classList.remove('hidden');
        }

        function closeWarningModal() {
            document.getElementById('warningModal').classList.add('hidden');
        }
    </script>
@endsection
