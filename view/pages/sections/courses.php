<?php if ($perkuliahan): ?>
<!-- Bagian Mata Kuliah Terkait -->
<!-- Menampilkan daftar mata kuliah yang didukung atau dilaksanakan di laboratorium -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            
            <!-- Header Seksi -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($perkuliahan['judul'] ?? 'Perkuliahan Terkait') ?></h2>
                <p class="text-gray-600 max-w-2xl mx-auto"><?= htmlspecialchars($perkuliahan['deskripsi'] ?? 'Mata kuliah yang didukung oleh fasilitas laboratorium ini.') ?></p>
            </div>

            <!-- Grid Daftar Mata Kuliah -->
            <div class="grid md:grid-cols-2 gap-8">
                <?php if (!empty($perkuliahan['daftar_mk'])): ?>
                    <?php foreach ($perkuliahan['daftar_mk'] as $mk): ?>
                    <!-- Item Kartu Mata Kuliah -->
                    <div class="flex gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 transition-colors">
                        <!-- Ikon Buku/Pelajaran -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Informasi Detail Mata Kuliah -->
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1"><?= htmlspecialchars($mk['nama'] ?? '') ?></h3>
                            <div class="flex gap-3 text-xs text-gray-500 mb-2">
                                <span class="bg-blue-50 px-2 py-0.5 rounded text-blue-800 font-medium"><?= htmlspecialchars($mk['kode'] ?? '') ?></span>
                                <span><?= htmlspecialchars($mk['sks'] ?? '0') ?> SKS</span>
                                <span>Semester <?= htmlspecialchars($mk['semester'] ?? '-') ?></span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed"><?= htmlspecialchars($mk['deskripsi'] ?? '') ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full text-center text-gray-500">Belum ada data mata kuliah.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
