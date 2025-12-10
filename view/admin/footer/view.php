<?php
// Display current footer settings
?>

<div class="max-w-4xl mx-auto py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manajemen Footer</h1>
                <p class="mt-2 text-gray-600">Kelola konten dan link footer website Anda</p>
            </div>
            <a href="index.php?page=admin-footer&action=edit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Footer
            </a>
        </div>
    </div>

    <!-- Status Messages -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                </svg>
                <span><?= htmlspecialchars($_SESSION['success']) ?></span>
            </div>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" />
                </svg>
                <span><?= htmlspecialchars($_SESSION['error']) ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Current Settings Display -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- About Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Tentang Laboratorium
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <p class="text-gray-600 text-sm line-clamp-3"><?= htmlspecialchars($footerSettings['description'] ?? 'Belum diatur') ?></p>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Informasi Kontak
            </h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600">Email:</span>
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($footerSettings['email'] ?? '-') ?></p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Telepon:</span>
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($footerSettings['phone'] ?? '-') ?></p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Alamat:</span>
                    <p class="font-medium text-gray-900 text-sm"><?= htmlspecialchars($footerSettings['address'] ?? '-') ?></p>
                </div>
            </div>
        </div>

        <!-- Quick Links Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                Link Cepat
            </h3>
            <div class="space-y-2">
                <?php if (!empty($footerSettings['quick_links'])): ?>
                    <?php foreach ($footerSettings['quick_links'] as $link): ?>
                        <div class="text-sm">
                            <span class="text-gray-600"><?= htmlspecialchars($link['label']) ?>:</span>
                            <a href="<?= htmlspecialchars($link['url']) ?>" class="text-blue-600 hover:underline ml-1" target="_blank"><?= htmlspecialchars($link['url']) ?></a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">Belum ada link cepat</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Social Media Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Media Sosial
            </h3>
            <div class="space-y-2">
                <?php $social_media = ['instagram' => 'Instagram', 'facebook' => 'Facebook', 'linkedin' => 'LinkedIn', 'twitter' => 'Twitter', 'youtube' => 'YouTube']; ?>
                <?php foreach ($social_media as $key => $label): ?>
                    <div class="text-sm">
                        <span class="text-gray-600"><?= $label ?>:</span>
                        <span class="text-gray-900 ml-2"><?= htmlspecialchars($footerSettings[$key] ?? '-') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Bottom Bar Section -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Bottom Bar
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="text-sm text-gray-600 block mb-1">Copyright Text:</span>
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($footerSettings['copyright_text'] ?? '-') ?></p>
                </div>
                <div>
                    <span class="text-sm text-gray-600 block mb-1">Jam Operasional:</span>
                    <p class="font-medium text-gray-900 text-sm"><?= nl2br(htmlspecialchars($footerSettings['operating_hours'] ?? '-')) ?></p>
                </div>
                <div>
                    <span class="text-sm text-gray-600 block mb-1">Privacy URL:</span>
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($footerSettings['privacy_url'] ?? '-') ?></p>
                </div>
                <div>
                    <span class="text-sm text-gray-600 block mb-1">Terms URL:</span>
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($footerSettings['terms_url'] ?? '-') ?></p>
                </div>
            </div>
        </div>

    </div>

</div>
</div>