<?php
// Check authorization
if (empty($_SESSION['user']) || !in_array($_SESSION['user']['role'] ?? '', ['admin', 'ketua_lab'])) {
    echo "Akses ditolak!";
    exit;
}

// Make sure $footerSettings is available
if (empty($footerSettings)) {
    $footerSettings = [
        'description' => '',
        'email' => '',
        'phone' => '',
        'address' => '',
        'instagram' => '',
        'facebook' => '',
        'linkedin' => '',
        'twitter' => '',
        'youtube' => '',
        'quick_links' => [],
        'resources' => []
    ];
}
include __DIR__ . '/../../../public/'
?>

<div class="max-w-5xl mx-auto py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Footer</h1>
        <p class="mt-2 text-gray-600">Perbarui konten dan pengaturan footer website Anda</p>
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

    <form method="POST" action="index.php?page=admin-footer&action=edit" class="space-y-8">

        <!-- Basic Information Section -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-blue-100">
                <svg class="w-6 h-6 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Informasi Dasar
            </h2>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Laboratorium</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan deskripsi laboratorium..."><?= htmlspecialchars($footerSettings['description'] ?? '') ?></textarea>
                <p class="text-xs text-gray-500 mt-1">Deskripsi singkat tentang laboratorium Anda yang akan ditampilkan di footer</p>
            </div>

            <!-- Address -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <input type="text" name="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan alamat..." value="<?= htmlspecialchars($footerSettings['address'] ?? '') ?>">
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-blue-100">
                <svg class="w-6 h-6 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Informasi Kontak
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="contoh@email.com" value="<?= htmlspecialchars($footerSettings['email'] ?? '') ?>">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="tel" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="(0341) 404424" value="<?= htmlspecialchars($footerSettings['phone'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- Social Media Section -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-blue-100">
                <svg class="w-6 h-6 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                Media Sosial
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php $socials = [
                    'instagram' => ['label' => 'Instagram', 'placeholder' => 'https://instagram.com/username'],
                    'facebook' => ['label' => 'Facebook', 'placeholder' => 'https://facebook.com/username'],
                    'linkedin' => ['label' => 'LinkedIn', 'placeholder' => 'https://linkedin.com/company/username'],
                    'twitter' => ['label' => 'Twitter', 'placeholder' => 'https://twitter.com/username'],
                    'youtube' => ['label' => 'YouTube', 'placeholder' => 'https://youtube.com/channel/username']
                ]; ?>

                <?php foreach ($socials as $key => $social): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?= $social['label'] ?></label>
                        <input type="url" name="<?= $key ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="<?= $social['placeholder'] ?>" value="<?= htmlspecialchars($footerSettings[$key] ?? '') ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Quick Links Section -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-blue-100">
                <svg class="w-6 h-6 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Link Cepat
            </h2>

            <div id="quick-links-container" class="space-y-4 mb-6">
                <?php if (!empty($footerSettings['quick_links'])): ?>
                    <?php foreach ($footerSettings['quick_links'] as $index => $link): ?>
                        <div class="quick-link-item grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                            <input type="text" name="quick_links_label[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="Label (Profil, Riset, dll)" value="<?= htmlspecialchars($link['label']) ?>">
                            <input type="url" name="quick_links_url[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="URL" value="<?= htmlspecialchars($link['url']) ?>">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="quick-link-item grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                        <input type="text" name="quick_links_label[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="Label (Profil, Riset, dll)">
                        <input type="url" name="quick_links_url[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="URL">
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" onclick="addQuickLink()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Link Cepat
            </button>
        </div>


        <!-- Bottom Bar Section -->
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-blue-100">
                <svg class="w-6 h-6 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Bottom Bar
            </h2>

            <!-- Copyright Text -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Copyright Text</label>
                <input type="text" name="copyright_text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="Lab IVSS - JTI Polinema" value="<?= htmlspecialchars($footerSettings['copyright_text'] ?? '') ?>">
                <p class="text-xs text-gray-500 mt-1">Teks copyright yang akan ditampilkan di bottom bar footer</p>
            </div>

            <!-- Operating Hours -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                <textarea name="operating_hours" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="Senin - Jumat&#10;08:00 - 16:00 WIB"><?= htmlspecialchars($footerSettings['operating_hours'] ?? '') ?></textarea>
                <p class="text-xs text-gray-500 mt-1">Gunakan &lt;br&gt; untuk membuat baris baru</p>
            </div>

            <!-- Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Privacy URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Privacy URL</label>
                    <input type="url" name="privacy_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="https://..." value="<?= htmlspecialchars($footerSettings['privacy_url'] ?? '') ?>">
                </div>

                <!-- Terms URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Terms URL</label>
                    <input type="url" name="terms_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="https://..." value="<?= htmlspecialchars($footerSettings['terms_url'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between items-center">
            <a href="index.php?page=admin-footer" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>

<script>
    function addQuickLink() {
        const container = document.getElementById('quick-links-container');
        const newItem = document.createElement('div');
        newItem.className = 'quick-link-item grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg';
        newItem.innerHTML = `
            <input type="text" name="quick_links_label[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="Label (Profil, Riset, dll)">
            <input type="url" name="quick_links_url[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent" placeholder="URL">
        `;
        container.appendChild(newItem);
    }
</script>