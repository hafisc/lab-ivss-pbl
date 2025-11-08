<?php 
ob_start();

// Data already fetched by controller: $users, $totalUsers, $adminCount, $dosenCount, $memberCount, $inactiveCount
?>

<!-- Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Manajemen User</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola semua pengguna sistem Lab IVSS</p>
    </div>
    <button onclick="showAddModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah User
    </button>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 p-4">
        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800"><?= $totalUsers ?></h3>
        <p class="text-xs text-slate-600">Total User</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4">
        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800"><?= $adminCount ?></h3>
        <p class="text-xs text-slate-600">Admin</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4">
        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800"><?= $dosenCount ?></h3>
        <p class="text-xs text-slate-600">Dosen & Ketua Lab</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4">
        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800"><?= $memberCount ?></h3>
        <p class="text-xs text-slate-600">Member Aktif</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4">
        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800"><?= $inactiveCount ?></h3>
        <p class="text-xs text-slate-600">Tidak Aktif</p>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-xl border border-slate-200 p-4 mb-6">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" id="searchInput" placeholder="Cari nama, email, NIM, atau NIP..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select id="roleFilter" class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="all">Semua Role</option>
            <option value="admin">Admin</option>
            <option value="ketua_lab">Ketua Lab</option>
            <option value="dosen">Dosen</option>
            <option value="member">Member</option>
        </select>
        <select id="statusFilter" class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="all">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
        </select>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">User</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Role</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">NIM/NIP</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Last Login</th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php foreach ($users as $user): ?>
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                            <span class="text-sm font-semibold text-slate-600"><?= strtoupper(substr($user['name'], 0, 2)) ?></span>
                        </div>
                        <div>
                            <div class="font-medium text-slate-800"><?= $user['name'] ?></div>
                            <div class="text-sm text-slate-500"><?= $user['email'] ?></div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <?php
                    $badges = ['admin' => 'bg-purple-100 text-purple-700', 'ketua_lab' => 'bg-blue-100 text-blue-700', 'dosen' => 'bg-green-100 text-green-700', 'member' => 'bg-orange-100 text-orange-700'];
                    $labels = ['admin' => 'Admin', 'ketua_lab' => 'Ketua Lab', 'dosen' => 'Dosen', 'member' => 'Member'];
                    ?>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium <?= $badges[$user['role']] ?>"><?= $labels[$user['role']] ?></span>
                </td>
                <td class="px-4 py-3 text-sm"><?= $user['nim'] ?? $user['nip'] ?? '-' ?></td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?= $user['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                        <span class="w-1.5 h-1.5 <?= $user['status'] === 'active' ? 'bg-green-500' : 'bg-red-500' ?> rounded-full mr-1.5"></span>
                        <?= $user['status'] === 'active' ? 'Aktif' : 'Tidak Aktif' ?>
                    </span>
                </td>
                <td class="px-4 py-3 text-sm text-slate-600">
                    <?php 
                    if ($user['last_login']) {
                        echo date('d M Y H:i', strtotime($user['last_login']));
                    } else {
                        echo '<span class="text-slate-400">Belum pernah login</span>';
                    }
                    ?>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="editUser(<?= $user['id'] ?>)" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button onclick="resetPassword(<?= $user['id'] ?>)" class="p-1.5 text-orange-600 hover:bg-orange-50 rounded" title="Reset Password">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </button>
                        <?php if ($user['id'] != 1): ?>
                        <button onclick="deleteUser(<?= $user['id'] ?>,'<?= $user['name'] ?>')" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full">
        <div class="p-6 border-b">
            <div class="flex justify-between">
                <h3 class="text-lg font-bold" id="modalTitle">Tambah User</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
        <form id="userForm" class="p-6 space-y-4">
            <input type="hidden" id="userId" name="id">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2"><input type="text" name="name" id="userName" placeholder="Nama Lengkap *" required class="w-full px-3 py-2 border rounded-lg"></div>
                <div><input type="email" name="email" id="userEmail" placeholder="Email *" required class="w-full px-3 py-2 border rounded-lg"></div>
                <div><input type="text" name="phone" id="userPhone" placeholder="No. Telepon" class="w-full px-3 py-2 border rounded-lg"></div>
                <div>
                    <select name="role" id="userRole" required class="w-full px-3 py-2 border rounded-lg" onchange="toggleRoleFields()">
                        <option value="">Pilih Role *</option>
                        <option value="admin">Admin</option>
                        <option value="ketua_lab">Ketua Lab</option>
                        <option value="dosen">Dosen</option>
                        <option value="member">Member</option>
                    </select>
                </div>
                <div>
                    <select name="status" id="userStatus" required class="w-full px-3 py-2 border rounded-lg">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
                <div id="nipField" class="col-span-2 hidden"><input type="text" name="nip" id="userNip" placeholder="NIP (untuk Dosen/Ketua Lab)" class="w-full px-3 py-2 border rounded-lg"></div>
                <div id="nimField" class="hidden"><input type="text" name="nim" id="userNim" placeholder="NIM" class="w-full px-3 py-2 border rounded-lg"></div>
                <div id="angkatanField" class="hidden"><input type="text" name="angkatan" id="userAngkatan" placeholder="Angkatan" class="w-full px-3 py-2 border rounded-lg"></div>
                <div class="col-span-2">
                    <input type="password" name="password" id="userPassword" placeholder="Password *" class="w-full px-3 py-2 border rounded-lg">
                    <p class="text-xs text-slate-500 mt-1" id="passwordHint">Minimal 8 karakter</p>
                </div>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <span id="btnText">Simpan</span>
                </button>
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-slate-100 rounded-lg hover:bg-slate-200">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
let isEditMode = false;

function showAddModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Tambah User Baru';
    document.getElementById('userForm').reset();
    document.getElementById('userId').value = '';
    document.getElementById('userPassword').required = true;
    document.getElementById('passwordHint').textContent = 'Minimal 8 karakter';
    document.getElementById('btnText').textContent = 'Simpan';
    document.getElementById('userModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function toggleRoleFields() {
    const role = document.getElementById('userRole').value;
    const nipField = document.getElementById('nipField');
    const nimField = document.getElementById('nimField');
    const angkatanField = document.getElementById('angkatanField');
    
    // Reset
    nipField.classList.add('hidden');
    nimField.classList.add('hidden');
    angkatanField.classList.add('hidden');
    
    if (role === 'dosen' || role === 'ketua_lab') {
        nipField.classList.remove('hidden');
    } else if (role === 'member') {
        nimField.classList.remove('hidden');
        angkatanField.classList.remove('hidden');
    }
}

function editUser(id) {
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit User';
    document.getElementById('btnText').textContent = 'Update';
    document.getElementById('userPassword').required = false;
    document.getElementById('passwordHint').textContent = 'Kosongkan jika tidak ingin mengubah password';
    
    // Fetch user data
    fetch('index.php?page=user-show&id=' + id)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const user = data.data;
                document.getElementById('userId').value = user.id;
                document.getElementById('userName').value = user.name;
                document.getElementById('userEmail').value = user.email;
                document.getElementById('userPhone').value = user.phone || '';
                document.getElementById('userRole').value = user.role;
                document.getElementById('userStatus').value = user.status;
                document.getElementById('userNip').value = user.nip || '';
                document.getElementById('userNim').value = user.nim || '';
                document.getElementById('userAngkatan').value = user.angkatan || '';
                toggleRoleFields();
                document.getElementById('userModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                alert(data.message);
            }
        })
        .catch(err => alert('Error: ' + err));
}

function resetPassword(id) {
    if (!confirm('Reset password user ini ke default (admin123)?')) return;
    
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('index.php?page=user-reset-password', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    })
    .catch(err => alert('Error: ' + err));
}

function deleteUser(id, name) {
    if (!confirm(`Hapus user "${name}"?\nData akan dihapus permanen!`)) return;
    
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('index.php?page=user-delete', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    })
    .catch(err => alert('Error: ' + err));
}

// Form submit
document.getElementById('userForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const action = isEditMode ? 'user-update' : 'user-store';
    
    fetch('index.php?page=' + action, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            closeModal();
            location.reload();
        }
    })
    .catch(err => alert('Error: ' + err));
});

// Close modal on outside click
document.getElementById('userModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<?php
$content = ob_get_clean();
$title = "Manajemen User";
require_once __DIR__ . '/../../layouts/admin.php';
?>
