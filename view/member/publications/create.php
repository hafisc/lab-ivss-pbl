<?php 
ob_start();
?>

<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="index.php?page=member-publications" class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-purple-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Publikasi
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Tambah Publikasi</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800 mb-1">Tambah Publikasi Baru</h1>
    <p class="text-sm text-slate-500">Lengkapi informasi publikasi penelitian Anda</p>
</div>

<!-- Alert Messages -->
<?php if (isset($_SESSION['error'])): ?>
<div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
    <span class="block sm:inline"><?= $_SESSION['error'] ?></span>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Form -->
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <form action="index.php?page=member-publication-create" method="POST" enctype="multipart/form-data">
        <div class="p-6 space-y-6">
            <!-- Publication Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">
                    Judul Publikasi <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    required 
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="Masukkan judul publikasi"
                >
                <p class="mt-1 text-xs text-slate-500">Judul lengkap dari paper atau jurnal penelitian</p>
            </div>

            <!-- Authors -->
            <div>
                <label for="authors" class="block text-sm font-medium text-slate-700 mb-2">
                    Penulis <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="authors" 
                    id="authors" 
                    required 
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="John Doe, Jane Smith, Ahmad Fauzi"
                >
                <p class="mt-1 text-xs text-slate-500">Pisahkan nama penulis dengan koma</p>
            </div>

            <!-- Journal/Conference and Year -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="journal" class="block text-sm font-medium text-slate-700 mb-2">
                        Journal/Conference <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="journal" 
                        id="journal" 
                        required 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="IEEE Transactions on..."
                    >
                </div>

                <div>
                    <label for="year" class="block text-sm font-medium text-slate-700 mb-2">
                        Tahun Publikasi <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="year" 
                        id="year" 
                        min="2000" 
                        max="2100" 
                        required 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                </div>
            </div>

            <!-- Volume, Issue, Pages -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="volume" class="block text-sm font-medium text-slate-700 mb-2">
                        Volume
                    </label>
                    <input 
                        type="text" 
                        name="volume" 
                        id="volume" 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="Vol. 10"
                    >
                </div>

                <div>
                    <label for="issue" class="block text-sm font-medium text-slate-700 mb-2">
                        Issue/Nomor
                    </label>
                    <input 
                        type="text" 
                        name="issue" 
                        id="issue" 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="No. 2"
                    >
                </div>

                <div>
                    <label for="pages" class="block text-sm font-medium text-slate-700 mb-2">
                        Halaman
                    </label>
                    <input 
                        type="text" 
                        name="pages" 
                        id="pages" 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="100-115"
                    >
                </div>
            </div>

            <!-- URL -->
            <div>
                <label for="url" class="block text-sm font-medium text-slate-700 mb-2">
                    URL Link
                </label>
                <input 
                    type="url" 
                    name="url" 
                    id="url" 
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="https://journal.example.com/paper/123"
                >
                <p class="mt-1 text-xs text-slate-500">Link ke halaman publikasi resmi</p>
            </div>

            <!-- DOI and Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="doi" class="block text-sm font-medium text-slate-700 mb-2">
                        DOI (Digital Object Identifier)
                    </label>
                    <input 
                        type="text" 
                        name="doi" 
                        id="doi" 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="10.1109/..."
                    >
                    <p class="mt-1 text-xs text-slate-500">Opsional - Identifier unik untuk publikasi</p>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status" 
                        required 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
            </div>

            <!-- File Upload -->
            <div>
                <label for="file" class="block text-sm font-medium text-slate-700 mb-2">
                    Upload PDF
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-purple-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600">
                            <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none">
                                <span>Upload file</span>
                                <input id="file" name="file" type="file" accept=".pdf" class="sr-only" onchange="updateFileName(this)">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-slate-500">PDF hingga 10MB</p>
                        <p id="fileName" class="text-sm text-purple-600 font-medium mt-2"></p>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Tips Menambahkan Publikasi</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pastikan informasi yang dimasukkan akurat dan lengkap</li>
                                <li>Upload file PDF publikasi untuk memudahkan akses</li>
                                <li>Gunakan status "Draft" jika publikasi masih dalam proses</li>
                                <li>DOI dapat ditemukan di halaman publikasi resmi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
            <a href="index.php?page=member-publications" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Batal
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Publikasi
            </button>
        </div>
    </form>
</div>

<script>
function updateFileName(input) {
    const fileName = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        fileName.textContent = '📄 ' + input.files[0].name;
    } else {
        fileName.textContent = '';
    }
}

// Auto-fill current year
document.addEventListener('DOMContentLoaded', function() {
    const yearInput = document.getElementById('year');
    if (!yearInput.value) {
        yearInput.value = new Date().getFullYear();
    }
});
</script>

<?php
$content = ob_get_clean();
$title = "Tambah Publikasi";
require_once __DIR__ . '/../../layouts/member.php';
?>
