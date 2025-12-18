<?php
require_once __DIR__ . '/../../../app/config/Database.php';
require_once __DIR__ . '/../../../app/models/Facility.php';

$db = Database::getInstance()->getPgConnection();
$facilityModel = new Facility($db);

$id = $_GET['id'] ?? 0;
$facility = $facilityModel->getById($id);

if (!$facility) {
    echo "<div class='min-h-screen flex items-center justify-center bg-gray-50'><div class='text-center'><h1 class='text-6xl font-bold text-gray-900 mb-4'>404</h1><p class='text-xl text-gray-600 mb-8'>Fasilitas tidak ditemukan.</p><a href='index.php' class='px-8 py-3 bg-blue-900 text-white rounded-full font-bold hover:bg-blue-800 transition-all'>Kembali ke Beranda</a></div></div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($facility['name']) ?> - Lab IVSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <main class="py-20 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto">
            
             <!-- Back Button -->
             <div class="mb-8">
                <a href="index.php?page=home#fasilitas" class="inline-flex items-center text-gray-500 hover:text-blue-900 transition-colors gap-2 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Fasilitas
                </a>
            </div>

            <!-- Content -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Image Side -->
                    <div class="relative h-[400px] lg:h-auto bg-gray-200">
                         <?php if (!empty($facility['image'])): ?>
                            <img src="<?= htmlspecialchars($facility['image']) ?>" alt="<?= htmlspecialchars($facility['name']) ?>" class="absolute inset-0 w-full h-full object-cover">
                        <?php else: ?>
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Details Side -->
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <div class="mb-6">
                            <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-bold uppercase tracking-wide">Fasilitas Lab</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                            <?= htmlspecialchars($facility['name']) ?>
                        </h1>
                        <div class="prose prose-blue text-gray-600 leading-relaxed">
                            <?= nl2br(htmlspecialchars($facility['description'])) ?>
                        </div>

                        <!-- Additional Info or CTA if needed -->
                        <div class="mt-8 pt-8 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-400 font-semibold uppercase">Status</span>
                                <span class="text-green-600 font-bold flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    Tersedia
                                </span>
                            </div>
                            <!-- Future: Booking Button? -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
