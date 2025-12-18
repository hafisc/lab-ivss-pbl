<?php
require_once __DIR__ . '/../../../app/config/Database.php'; 

$pgConnection = Database::getInstance()->getPgConnection(); 

$profileData = [];
$defaultData = [
    // Default Data Profil Detail
    'nama_lab' => 'Lab Default',
    'lokasi_ruangan' => 'Lokasi Belum Diatur',
    'deskripsi_singkat' => 'Deskripsi Lab Belum Diisi. Silakan perbarui melalui halaman Admin.',
    'riset_fitur_judul' => 'Riset Inovatif',
    'riset_fitur_desk' => 'Penelitian berkelas dunia',
    'fasilitas_fitur_judul' => 'Fasilitas Modern',
    'fasilitas_fitur_desk' => 'Peralatan canggih',
];

if ($pgConnection) {
    $query = 'SELECT * FROM "profile_lab" WHERE id = $1'; 
    $result = pg_query_params($pgConnection, $query, [1]);
    
    if ($result) {
        $dataFromDb = pg_fetch_assoc($result);
        if ($dataFromDb) {
            $profileData = $dataFromDb;
        }
        pg_free_result($result);
    }
} else {
    error_log("Gagal mendapatkan koneksi PostgreSQL saat loading home.php");
}

$profileData = array_replace_recursive($defaultData, $profileData);

?>

<section id="profil" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Profil <?= htmlspecialchars($profileData['nama_lab'] ?? 'Lab Default') ?></h2>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-4">
                    <div class="relative group bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-blue-900 transition-all duration-300 hover:shadow-2xl">
                        <div class="relative z-10 flex flex-col items-center justify-center space-y-6">
                            <?php if (!empty($profileData['image'])): ?>
                                <img src="<?= htmlspecialchars($profileData['image']) ?>" alt="Lab Logo" class="w-full max-w-xs h-auto object-contain">
                            <?php else: ?>
                                <img src="assets/images/IVSS LOGO.png" alt="Lab Logo" class="w-full max-w-xs h-auto">
                            <?php endif; ?>
                            <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($profileData['lokasi_ruangan'] ?? 'Lokasi Belum Ditetapkan') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <p class="text-gray-700 leading-relaxed text-justify">
                        <span class="text-3xl font-bold text-blue-900 float-left mr-3 leading-none"><?= substr(htmlspecialchars($profileData['nama_lab'] ?? 'D'), 0, 1) ?></span>
                        <?= htmlspecialchars($profileData['deskripsi_singkat'] ?? 'Deskripsi Lab Belum Diisi. Silakan perbarui melalui halaman Admin.') ?>
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl">
                            <div>
                                <div class="font-semibold text-gray-900"><?= htmlspecialchars($profileData['riset_fitur_judul'] ?? 'Riset Inovatif') ?></div>
                                <div class="text-sm text-gray-600"><?= htmlspecialchars($profileData['riset_fitur_desk'] ?? 'Penelitian berkelas dunia') ?></div>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl">
                            <div>
                                <div class="font-semibold text-gray-900"><?= htmlspecialchars($profileData['fasilitas_fitur_judul'] ?? 'Fasilitas Modern') ?></div>
                                <div class="text-sm text-gray-600"><?= htmlspecialchars($profileData['fasilitas_fitur_desk'] ?? 'Peralatan canggih') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
