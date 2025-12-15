<?php 
ob_start(); 

// Variabel default untuk memastikan tidak ada error jika $data belum didefinisikan
$data = $data ?? [
    'name' => '', 
    'deskripsi' => '', 
    'image' => 'uploads/default.jpg'
];
// Sesuaikan kunci array jika di DB menggunakan 'nama', namun disarankan 'name'
$data['nama'] = $data['name'] ?? $data['nama'] ?? ''; 
$data['deskripsi'] = $data['deskripsi'] ?? ''; 
$data['image_url'] = $data['image'] ?? 'uploads/default.jpg'; 

?>

<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg md:text-xl font-bold text-slate-800">Edit Profil Laboratorium</h2>
        <p class="text-xs text-slate-500 mt-0.5">Ubah informasi Profil Laboratorium</p>
    </div>
    <a href="index.php?page=admin-profil" 
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
    <form method="POST" action="index.php?page=admin-profil&action=update" enctype="multipart/form-data" class="space-y-4">
        
        <div>
            <label for="nama" class="block text-xs font-medium text-slate-700 mb-1.5">Nama Laboratorium </label>
            <input type="text" id="nama" name="nama" required
                   value="<?= htmlspecialchars($data['nama']) ?>"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
        </div>

        <div>
            <label for="deskripsi" class="block text-xs font-medium text-slate-700 mb-1.5">Deskripsi Laboratorium *</label>
            <textarea id="deskripsi" name="deskripsi" rows="10" required
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-xs"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1.5">Gambar Profil</label>
            
            <?php if (!empty($data['image_url']) && $data['image_url'] !== 'uploads/default.jpg'): ?>
            <div id="currentImageContainer" class="mb-3 p-3 border border-slate-200 rounded-lg bg-slate-50">
                <p class="text-xs text-slate-600 mb-2 font-medium">Gambar Saat Ini:</p>
                <img src="<?= htmlspecialchars($data['image_url']) ?>" alt="Current" class="max-w-full h-40 object-cover rounded-lg shadow-md mb-2">
                </div>
            <?php endif; ?>
            
            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-blue-500 transition-colors cursor-pointer" id="dropZone">
                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                <div id="uploadPrompt">
                    <svg class="w-10 h-10 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="text-xs text-slate-600 mb-1"><span class="font-medium text-blue-600">Klik untuk upload gambar baru</span> atau drag & drop</p>
                    <p class="text-xs text-slate-500">PNG, JPG, WebP up to 2MB. Mengganti gambar saat ini.</p>
                </div>
                <div id="imagePreview" class="hidden">
                    <img id="previewImg" src="" alt="Preview" class="max-w-full h-48 mx-auto rounded-lg shadow-lg">
                    <button type="button" onclick="removeNewImage()" class="mt-2 text-xs text-red-600 hover:text-red-700 font-medium">Batalkan Upload Baru</button>
                </div>
            </div>
        </div>
        <div class="flex gap-2 pt-3 border-t">
            <button type="submit" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors text-xs">
                Update Profil
            </button>
            <a href="index.php?page=admin-profil" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg text-xs">
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


// Click to upload
dropZone.addEventListener('click', () => imageInput.click());

// File input change
imageInput.addEventListener('change', function(e) {
    handleFile(e.target.files[0]);
});

// Drag & drop
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-blue-500', 'bg-blue-50');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-blue-500', 'bg-blue-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-500', 'bg-blue-50');
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
$title = "Edit Profil Laboratorium";
include __DIR__ . "/../../layouts/admin.php";
?>