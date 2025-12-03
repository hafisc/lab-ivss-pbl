<?php 
ob_start();

// Data already fetched by controller: $members
?>

<!-- Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Anggota Tim</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola anggota tim yang ditampilkan di home page</p>
    </div>
    <button onclick="showAddModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Anggota
    </button>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Foto</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Nama</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Jabatan</th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase">Urutan</th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase">Status</th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (empty($members)): ?>
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada data anggota tim</td>
            </tr>
            <?php else: ?>
            <?php foreach ($members as $member): ?>
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-slate-200">
                        <?php if ($member['photo']): ?>
                            <img src="<?= htmlspecialchars($member['photo']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-900 font-bold text-sm"><?= strtoupper(substr($member['name'], 0, 2)) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="font-medium text-slate-800"><?= htmlspecialchars($member['name']) ?></div>
                    <?php if ($member['email']): ?>
                        <div class="text-xs text-slate-500"><?= htmlspecialchars($member['email']) ?></div>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-sm text-slate-700"><?= htmlspecialchars($member['position']) ?></td>
                <td class="px-4 py-3 text-center text-sm text-slate-700"><?= $member['order_position'] ?></td>
                <td class="px-4 py-3 text-center">
                    <button onclick="toggleActive(<?= $member['id'] ?>)" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?= $member['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' ?>">
                        <?= $member['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                    </button>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="editMember(<?= $member['id'] ?>)" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button onclick="deleteMember(<?= $member['id'] ?>,'<?= htmlspecialchars($member['name']) ?>')" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="memberModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold" id="modalTitle">Tambah Anggota</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
        <form id="memberForm" enctype="multipart/form-data" class="p-6 space-y-4">
            <input type="hidden" id="memberId" name="id">
            
            <!-- Photo Upload -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Foto</label>
                <div class="flex items-center gap-4">
                    <div id="photoPreview" class="w-20 h-20 rounded-full overflow-hidden border-2 border-slate-200 bg-slate-100">
                        <img id="previewImg" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <div id="previewPlaceholder" class="w-full h-full flex items-center justify-center text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="photo" id="photoInput" accept="image/jpeg,image/jpg,image/png,image/webp" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, WebP. Max 2MB</p>
                    </div>
                </div>
            </div>

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap *</label>
                <input type="text" name="name" id="memberName" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Dr. John Doe, S.Kom., M.Kom">
            </div>

            <!-- Position -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jabatan *</label>
                <select name="position" id="memberPosition" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Jabatan</option>
                    <option value="Kepala Lab">Kepala Lab</option>
                    <option value="Peneliti">Peneliti</option>
                    <option value="Asisten Peneliti">Asisten Peneliti</option>
                    <option value="Teknisi">Teknisi</option>
                </select>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" id="memberEmail" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="john.doe@polinema.ac.id">
            </div>

            <!-- Order Position -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Urutan Tampilan</label>
                <input type="number" name="order_position" id="memberOrder" min="0" value="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="memberActive" value="1" checked class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                <label for="memberActive" class="ml-2 text-sm text-slate-700">Tampilkan di home page</label>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-slate-100 rounded-lg hover:bg-slate-200">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
let isEditMode = false;

// Photo preview
document.getElementById('photoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewImg').classList.remove('hidden');
            document.getElementById('previewPlaceholder').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
});

function showAddModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Tambah Anggota';
    document.getElementById('memberForm').reset();
    document.getElementById('memberId').value = '';
    document.getElementById('previewImg').classList.add('hidden');
    document.getElementById('previewPlaceholder').classList.remove('hidden');
    document.getElementById('memberModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('memberModal').classList.add('hidden');
}

function editMember(id) {
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit Anggota';
    
    fetch('index.php?page=admin-team-show&id=' + id)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const m = data.data;
                document.getElementById('memberId').value = m.id;
                document.getElementById('memberName').value = m.name;
                document.getElementById('memberPosition').value = m.position;
                document.getElementById('memberEmail').value = m.email || '';
                document.getElementById('memberOrder').value = m.order_position;
                document.getElementById('memberActive').checked = m.is_active;
                
                if (m.photo) {
                    document.getElementById('previewImg').src = m.photo;
                    document.getElementById('previewImg').classList.remove('hidden');
                    document.getElementById('previewPlaceholder').classList.add('hidden');
                }
                
                document.getElementById('memberModal').classList.remove('hidden');
            } else {
                alert(data.message);
            }
        })
        .catch(err => alert('Error: ' + err));
}

function deleteMember(id, name) {
    if (!confirm(`Hapus anggota "${name}"?\nData akan dihapus permanen!`)) return;
    
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('index.php?page=admin-team-delete', {method: 'POST', body: formData})
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) location.reload();
        })
        .catch(err => alert('Error: ' + err));
}

function toggleActive(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('index.php?page=admin-team-toggle', {method: 'POST', body: formData})
        .then(res => res.json())
        .then(data => {
            if (data.success) location.reload();
            else alert(data.message);
        })
        .catch(err => alert('Error: ' + err));
}

// Form submit
document.getElementById('memberForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const action = isEditMode ? 'admin-team-update' : 'admin-team-store';
    
    fetch('index.php?page=' + action, {method: 'POST', body: formData})
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
document.getElementById('memberModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<?php
$content = ob_get_clean();
$title = "Manajemen Anggota Tim";
require_once __DIR__ . '/../../layouts/admin.php';
?>
