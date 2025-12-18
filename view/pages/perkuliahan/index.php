<?php
$dataFile = __DIR__ . '/../../app/data/perkuliahan.json';
// Adjust relative path since this file is in view/pages/perkuliahan/index.php
// The original was in view/pages/home.php which is one level up.
// So __DIR__ will be .../view/pages/perkuliahan
// The data file is in .../app/data/perkuliahan.json
// From view/pages/perkuliahan/index.php to app/data is: ../../../app/data
$dataFile = __DIR__ . '/../../../app/data/perkuliahan.json';

$perkuliahan = null;
if (file_exists($dataFile)) {
    $raw = file_get_contents($dataFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $perkuliahan = $decoded;
}
?>
<section id="perkuliahan" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    <?= htmlspecialchars($perkuliahan['heading'] ?? 'Perkuliahan Terkait') ?>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    <?= htmlspecialchars($perkuliahan['subtitle'] ?? 'Mata kuliah yang berkaitan dengan Lab IVSS') ?>
                </p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <?php
                $items = $perkuliahan['items'] ?? [
                    ['title' => 'Kecerdasan Artifisial (AI)', 'description' => 'Teknologi yang fokus pada pembelajaran tugas-tugas berbasis manusia seperti pengenalan pola'],
                    ['title' => 'Machine Learning', 'description' => 'Cabang dari kecerdasan artifisial yang memungkinkan mesin belajar dari data'],
                    ['title' => 'Pengolahan Citra dan Visi Komputer', 'description' => 'Menganalisis gambar atau video untuk ekstraksi pola, deteksi objek, segmentasi, dan lainnya'],
                    ['title' => 'Sistem Cerdas (Intelligent System)', 'description' => 'Pengembangan sistem yang dapat melakukan keputusan otomatis, penanganan informasi dalam konteks aplikasi nyata']
                ];

                foreach ($items as $it):
                ?>
                    <div class="flex items-start gap-4 bg-blue-50 rounded-2xl p-6 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2"><?= htmlspecialchars($it['title']) ?></h3>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($it['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
