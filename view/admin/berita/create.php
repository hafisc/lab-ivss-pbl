<?php ob_start(); ?>

<!-- Page Header -->
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg md:text-xl font-bold text-slate-800">Tambah Berita Baru</h2>
        <p class="text-xs text-slate-500 mt-0.5">Buat berita atau artikel baru untuk Lab IVSS</p>
    </div>
    <a href="index.php?page=admin-news" 
       class="inline-flex items-center px-3 py-2 bg-slate-500 hover:bg-slate-600 text-white text-xs font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
    </a>
</div>

<!-- Alert Messages -->
<?php if (isset($_SESSION['error'])): ?>
<div class="mb-3 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
    <p class="text-xs text-red-700"><?= $_SESSION['error'] ?></p>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Form Card -->
<div class="bg-white border border-slate-200 rounded-xl p-4">
    <form method="POST" action="index.php?page=admin-news&action=store" enctype="multipart/form-data" class="space-y-4">
        
        <!-- Title -->
        <div>
            <label for="title" class="block text-xs font-medium text-slate-700 mb-1.5">Judul Berita *</label>
            <input type="text" id="title" name="title" required
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-xs"
                   placeholder="Masukkan judul berita">
        </div>

        <!-- Excerpt -->
        <div>
            <label for="excerpt" class="block text-xs font-medium text-slate-700 mb-1.5">Ringkasan (Excerpt)</label>
            <textarea id="excerpt" name="excerpt" rows="2"
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-xs"
                      placeholder="Ringkasan singkat berita (opsional)"></textarea>
            <p class="mt-1 text-xs text-slate-500">Ringkasan akan ditampilkan di halaman daftar berita</p>
        </div>

        <!-- Content -->
        <div>
            <label for="content" class="block text-xs font-medium text-slate-700 mb-1.5">Konten Berita *</label>
            <textarea id="content" name="content" rows="10" required
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-mono text-xs"
                      placeholder="Tulis konten berita di sini..."></textarea>
            <p class="mt-1 text-xs text-slate-500">Mendukung HTML dan Markdown</p>
        </div>

        <!-- Image Upload with Preview -->
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1.5">Gambar Berita (Thumbnail)</label>
            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-blue-500 transition-colors cursor-pointer" id="dropZone">
                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                <div id="uploadPrompt">
                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="text-sm text-slate-600 mb-1"><span class="font-medium text-blue-600">Klik untuk upload</span> atau drag & drop</p>
                    <p class="text-xs text-slate-500">PNG, JPG, WebP up to 2MB</p>
                </div>
                <div id="imagePreview" class="hidden">
                    <img id="previewImg" src="" alt="Preview" class="max-w-full h-64 mx-auto rounded-lg shadow-lg">
                    <button type="button" onclick="removeImage()" class="mt-2 text-xs text-red-600 hover:text-red-700">Hapus Gambar</button>
                </div>
            </div>
        </div>

        <!-- Document Upload -->
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1.5">File Lampiran (PDF/Doc) <span class="text-slate-400 font-normal">(Opsional)</span></label>
            <input type="file" name="file_path" accept=".pdf,.doc,.docx,.zip"
                   class="w-full block text-xs text-slate-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-xs file:font-semibold
                          file:bg-blue-50 file:text-blue-700
                          hover:file:bg-blue-100
                          cursor-pointer border border-slate-300 rounded-lg">
            <p class="mt-1 text-xs text-slate-500">Upload file jika berita ini merupakan pengumuman atau memiliki lampiran.</p>
        </div>

        <!-- Category/Tags -->
        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label for="category" class="block text-xs font-medium text-slate-700 mb-1.5">Kategori</label>
                <select id="category" name="category"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-xs">
                    <option value="">Pilih Kategori</option>
                    <option value="achievement">Prestasi</option>
                    <option value="event">Event</option>
                    <option value="research">Riset</option>
                    <option value="announcement">Pengumuman</option>
                    <option value="other">Lainnya</option>
                </select>
            </div>

            <div>
                <label for="tags" class="block text-xs font-medium text-slate-700 mb-1.5">Tags</label>
                <input type="text" id="tags" name="tags"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-xs"
                       placeholder="Pisahkan dengan koma">
                <p class="mt-1 text-xs text-slate-500">Contoh: AI, Machine Learning, IoT</p>
            </div>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1.5">Status Publikasi *</label>
            <div class="flex gap-3">
                <label class="flex items-center">
                    <input type="radio" name="status" value="draft" checked
                           class="w-3.5 h-3.5 text-blue-600 focus:ring-2 focus:ring-blue-500">
                    <span class="ml-2 text-xs text-slate-700">Draft</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="status" value="published"
                           class="w-3.5 h-3.5 text-blue-600 focus:ring-2 focus:ring-blue-500">
                    <span class="ml-2 text-xs text-slate-700">Published</span>
                </label>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row gap-2 pt-3 border-t border-slate-200">
            <button type="submit" 
                    class="flex-1 sm:flex-none px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors text-xs">
                Simpan Berita
            </button>
            <a href="index.php?page=admin-news" 
               class="flex-1 sm:flex-none px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg text-center transition-colors text-xs">
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

function removeImage() {
    imageInput.value = '';
    uploadPrompt.classList.remove('hidden');
    imagePreview.classList.add('hidden');
    previewImg.src = '';
}
</script>

<?php
$content = ob_get_clean();
$title = "Tambah Berita";
include __DIR__ . "/../../layouts/admin.php";
?>
