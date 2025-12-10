<?php
// Pastikan user memiliki akses
if (empty($_SESSION['user']) || !in_array($_SESSION['user']['role'] ?? '', ['admin', 'dosen', 'ketua_lab'])) {
    // Jika akses ditolak, redirect atau tampilkan pesan
    echo "Akses ditolak";
    exit;
}
ob_start();
?>

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Tambah Publikasi</h2>
            <p class="text-sm text-slate-500 mt-1">Tambahkan data publikasi ilmiah baru</p>
        </div>
        <a href="index.php?page=admin-publications" class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
</div>


<div class="max-w-4xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <form action="index.php?page=admin-publications&action=store" method="POST" class="p-6 space-y-6">
            
            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Judul Publikasi <span class="text-red-500">*</span></label>
                <input type="text" name="title" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                       placeholder="Masukkan judul publikasi lengkap">
            </div>

            <!-- Penulis -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Penulis (Authors) <span class="text-red-500">*</span></label>
                <input type="text" name="authors" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                       placeholder="Contoh: Budi Santoso, Siti Aminah, John Doe">
                <p class="text-xs text-slate-500 mt-1">Pisahkan nama penulis dengan koma</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tahun -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                    <input type="number" name="year" required min="1900" max="<?= date('Y') + 1 ?>"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                           value="<?= date('Y') ?>">
                </div>

                <!-- Tipe -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Publikasi <span class="text-red-500">*</span></label>
                    <select name="type" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <option value="journal">Jurnal</option>
                        <option value="conference">Konferensi</option>
                        <option value="book">Buku</option>
                        <option value="prosiding">Prosiding</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Nama Jurnal/Konferensi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Jurnal / Konferensi / Penerbit <span class="text-red-500">*</span></label>
                <input type="text" name="publisher" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                       placeholder="Contoh: IEEE Transactions on Pattern Analysis...">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <!-- DOI -->
                 <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">DOI</label>
                    <input type="text" name="doi"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                           placeholder="Contoh: 10.1109/TPAMI.2020.1234567">
                </div>

                <!-- URL -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Link URL</label>
                    <input type="url" name="url"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                           placeholder="https://...">
                </div>
            </div>

            <!-- Volume/Issue/Pages (Opsional, digabung dalam satu baris grid 3) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Volume</label>
                    <input type="text" name="volume"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Issue / Nomor</label>
                    <input type="text" name="issue"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Halaman</label>
                    <input type="text" name="pages"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                           placeholder="Contoh: 123-145">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Indexed In -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Terindeks Di</label>
                    <input type="text" name="indexed"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                           placeholder="Contoh: Scopus Q1, Sinta 2, Google Scholar">
                </div>

                <!-- Citation Count -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Sitasi</label>
                    <input type="number" name="citation_count" min="0" value="0"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
            </div>

            <!-- Abstract -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Abstrak (Opsional)</label>
                <textarea name="abstract" rows="4"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                          placeholder="Masukkan abstrak publikasi..."></textarea>
            </div>

            <hr class="border-slate-200">

            <div class="flex justify-end gap-3">
                <a href="index.php?page=admin-publications" class="px-5 py-2.5 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors text-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors text-sm shadow-sm md:w-auto w-full">
                    <svg class="w-4 h-4 inline mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Simpan Publikasi
                </button>
            </div>

        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
