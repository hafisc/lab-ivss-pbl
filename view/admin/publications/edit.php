<?php
// view/admin/publications/edit.php
$title = "Edit Publikasi";
ob_start();
?>

<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Publikasi</h1>
        <a href="index.php?page=admin-publications" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="index.php?page=admin-publications&action=update&id=<?= $publication['id'] ?>" method="POST" enctype="multipart/form-data">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Judul Publikasi</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($publication['title']) ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <!-- Authors -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="authors">Penulis</label>
                    <input type="text" id="authors" name="authors" value="<?= htmlspecialchars($publication['authors']) ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma (contoh: John Doe, Jane Smith)</p>
                </div>

                <!-- Year -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="year">Tahun</label>
                    <input type="number" id="year" name="year" value="<?= htmlspecialchars($publication['year']) ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="type">Tipe Publikasi</label>
                    <select id="type" name="type" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required onchange="togglePublisherField()">
                        <option value="journal" <?= $publication['type'] === 'journal' ? 'selected' : '' ?>>Jurnal</option>
                        <option value="conference" <?= $publication['type'] === 'conference' ? 'selected' : '' ?>>Konferensi</option>
                        <option value="prosiding" <?= $publication['type'] === 'prosiding' ? 'selected' : '' ?>>Prosiding</option>
                        <option value="book" <?= $publication['type'] === 'book' ? 'selected' : '' ?>>Buku</option>
                        <option value="other" <?= $publication['type'] === 'other' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <!-- Publisher / Conference Name -->
                <div class="md:col-span-2">
                    <label id="publisher_label" class="block text-gray-700 text-sm font-bold mb-2" for="publisher">Nama Jurnal / Penerbit</label>
                    <input type="text" id="publisher" name="publisher" value="<?= htmlspecialchars($publication['journal'] ?? $publication['conference'] ?? '') ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <!-- Volume & Issue -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="volume">Volume (Opsional)</label>
                    <input type="text" id="volume" name="volume" value="<?= htmlspecialchars($publication['volume'] ?? '') ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="issue">Issue/Nomor (Opsional)</label>
                    <input type="text" id="issue" name="issue" value="<?= htmlspecialchars($publication['issue'] ?? '') ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <!-- Pages & DOI -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="pages">Halaman (Opsional)</label>
                    <input type="text" id="pages" name="pages" value="<?= htmlspecialchars($publication['pages'] ?? '') ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="doi">DOI (Opsional)</label>
                    <input type="text" id="doi" name="doi" value="<?= htmlspecialchars($publication['doi'] ?? '') ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <!-- URL & Indexed -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="url">URL Link (Opsional)</label>
                    <input type="url" id="url" name="url" value="<?= htmlspecialchars($publication['url'] ?? '') ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="indexed">Terindeks (Opsional)</label>
                    <input type="text" id="indexed" name="indexed" value="<?= htmlspecialchars($publication['indexed'] ?? '') ?>" placeholder="Scopus, Sinta, WoS, dll." class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                 <!-- File Upload Field (Updated) -->
                 <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="file_path">Upload File (PDF/Docs/Zip)</label>
                    
                    <?php if (!empty($publication['file_path'])): ?>
                        <div class="mb-2 p-3 bg-blue-50 border border-blue-200 rounded flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">File Saat Ini:</span>
                                    <a href="<?= htmlspecialchars($publication['file_path']) ?>" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 underline ml-1">
                                        Lihat File
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="remove_file" name="remove_file" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                <label for="remove_file" class="ml-2 block text-sm text-red-600">Hapus File</label>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Upload file baru di bawah ini untuk mengganti file saat ini.</p>
                    <?php endif; ?>

                    <input type="file" id="file_path" name="file_path" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" accept=".pdf,.doc,.docx,.zip,.rar">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, ZIP, RAR. Maks: 10MB.</p>
                </div>

                <!-- Abstract -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="abstract">Abstrak (Opsional)</label>
                    <textarea id="abstract" name="abstract" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"><?= htmlspecialchars($publication['abstract'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <a href="index.php?page=admin-publications" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePublisherField() {
    const type = document.getElementById('type').value;
    const label = document.getElementById('publisher_label');
    
    if (type === 'conference' || type === 'prosiding') {
        label.textContent = 'Nama Konferensi';
    } else {
        label.textContent = 'Nama Jurnal / Penerbit';
    }
}

// Run on load
document.addEventListener('DOMContentLoaded', togglePublisherField);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
