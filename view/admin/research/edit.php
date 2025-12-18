<?php ob_start(); ?>

<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg md:text-xl font-bold text-slate-800">Edit Riset</h2>
        <p class="text-xs text-slate-500 mt-0.5">Ubah informasi riset</p>
    </div>
    <a href="index.php?page=admin-research" 
       class="inline-flex items-center px-3 py-2 bg-slate-500 hover:bg-slate-600 text-white text-xs font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
    </a>
</div>

<?php if (isset($_SESSION['error'])): ?>
<div class="mb-3 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
    <p class="text-xs text-red-700"><?= $_SESSION['error'] ?></p>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="bg-white border border-slate-200 rounded-xl p-4">
    <form method="POST" action="index.php?page=admin-research&action=update&id=<?= $researchItem['id'] ?>" enctype="multipart/form-data" class="space-y-4">
        
        <div>
            <label for="title" class="block text-xs font-medium text-slate-700 mb-1.5">Judul Riset *</label>
            <input type="text" id="title" name="title" required
                   value="<?= htmlspecialchars($researchItem['title']) ?>"
                   class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="description" class="block text-xs font-medium text-slate-700 mb-1.5">Deskripsi *</label>
            <textarea id="description" name="description" rows="4" required
                      class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars($researchItem['description']) ?></textarea>
        </div>

        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label for="category" class="block text-xs font-medium text-slate-700 mb-1.5">Kategori *</label>
                <select id="category" name="category" required
                        class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Riset Utama" <?= $researchItem['category'] === 'Riset Utama' ? 'selected' : '' ?>>Riset Utama</option>
                    <option value="Riset Lainnya" <?= $researchItem['category'] === 'Riset Lainnya' ? 'selected' : '' ?>>Riset Lainnya</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-xs font-medium text-slate-700 mb-1.5">Status *</label>
                <select id="status" name="status" required
                        class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="active" <?= $researchItem['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="completed" <?= $researchItem['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="on-hold" <?= $researchItem['status'] === 'on-hold' ? 'selected' : '' ?>>On-Hold</option>
                </select>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label for="start_date" class="block text-xs font-medium text-slate-700 mb-1.5">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date"
                       value="<?= htmlspecialchars($researchItem['start_date'] ?? '') ?>"
                       class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="end_date" class="block text-xs font-medium text-slate-700 mb-1.5">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date"
                       value="<?= htmlspecialchars($researchItem['end_date'] ?? '') ?>"
                       class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div>
            <label for="funding" class="block text-xs font-medium text-slate-700 mb-1.5">Sumber Pendanaan</label>
            <input type="text" id="funding" name="funding"
                   value="<?= htmlspecialchars($researchItem['funding'] ?? '') ?>"
                   class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="team_members" class="block text-xs font-medium text-slate-700 mb-1.5">Anggota Tim</label>
            <textarea id="team_members" name="team_members" rows="2"
                      class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars($researchItem['team_members'] ?? '') ?></textarea>
        </div>

        <div>
            <textarea id="publications" name="publications" rows="2"
                      class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars($researchItem['publications'] ?? '') ?></textarea>
        </div>

        <div>
            <label for="url" class="block text-xs font-medium text-slate-700 mb-1.5">Link Penelitian URL</label>
            <input type="url" id="url" name="url" value="<?= htmlspecialchars($researchItem['url'] ?? '') ?>"
                   class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="https://...">
        </div>

        <!-- Image Upload with Preview -->
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1.5">Gambar Riset (Opsional)</label>
            
            <?php if (!empty($researchItem['image_url'])): ?>
            <!-- Current Image Preview -->
            <div id="currentImageContainer" class="mb-3 p-3 border border-slate-200 rounded-lg bg-slate-50">
                <p class="text-xs text-slate-600 mb-2 font-medium">Gambar Saat Ini:</p>
                <img src="<?= htmlspecialchars($researchItem['image_url']) ?>" alt="Current" class="max-w-full h-40 object-cover rounded-lg shadow-md mb-2">
                <label class="flex items-center text-xs text-slate-700 cursor-pointer hover:text-red-600 transition-colors">
                    <input type="checkbox" name="remove_image" value="1" class="mr-2 w-3.5 h-3.5 text-red-600 rounded">
                    <span class="font-medium">Hapus gambar ini</span>
                </label>
            </div>
            <?php endif; ?>
            
            <!-- Upload New Image -->
            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-purple-500 transition-colors cursor-pointer" id="dropZone">
                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                <div id="uploadPrompt">
                    <svg class="w-10 h-10 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="text-xs text-slate-600 mb-1"><span class="font-medium text-purple-600">Klik untuk upload gambar baru</span> atau drag & drop</p>
                    <p class="text-xs text-slate-500">PNG, JPG, WebP up to 2MB</p>
                </div>
                <div id="imagePreview" class="hidden">
                    <img id="previewImg" src="" alt="Preview" class="max-w-full h-48 mx-auto rounded-lg shadow-lg">
                    <button type="button" onclick="removeNewImage()" class="mt-2 text-xs text-red-600 hover:text-red-700 font-medium">Hapus Gambar Baru</button>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 rounded-lg p-3 text-xs text-slate-600">
                <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <span class="font-medium">Dibuat:</span> <?= date('d M Y H:i', strtotime($researchItem['created_at'])) ?>
                </div>
                <?php if (!empty($researchItem['updated_at'])): ?>
                <div>
                    <span class="font-medium">Diupdate:</span> <?= date('d M Y H:i', strtotime($researchItem['updated_at'])) ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex gap-2 pt-3 border-t">
            <button type="submit" class="px-4 py-2 text-xs bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors">
                Update Riset
            </button>
            <a href="index.php?page=admin-research" class="px-4 py-2 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
// Image upload with drag & drop
const dropZone = document.getElementById('dropZone');
const imageInput = document.getElementById('image');
const uploadPrompt = document.getElementById('uploadPrompt');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');

dropZone.addEventListener('click', () => imageInput.click());

imageInput.addEventListener('change', function(e) {
    handleFile(e.target.files[0]);
});

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-purple-500', 'bg-purple-50');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-purple-500', 'bg-purple-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-purple-500', 'bg-purple-50');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        imageInput.files = e.dataTransfer.files;
        handleFile(file);
    }
});

function handleFile(file) {
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            uploadPrompt.classList.add('hidden');
            imagePreview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function removeNewImage() {
    imageInput.value = '';
    uploadPrompt.classList.remove('hidden');
    imagePreview.classList.add('hidden');
    previewImg.src = '';
}
</script>

<?php
$content = ob_get_clean();
$title = "Edit Riset";
include __DIR__ . "/../../layouts/admin.php";
?>
