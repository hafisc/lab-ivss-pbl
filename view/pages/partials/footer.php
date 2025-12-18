<?php
// Fetch footer settings from database
// Try to get database connection from global scope or create new one
$db = null;

// Check if $db exists in global scope
if (isset($GLOBALS['db'])) {
    $db = $GLOBALS['db'];
}

// If not found, try to get connection from required config
if (!$db) {
    require_once __DIR__ . '/../../app/config/database.php';
    $db = getDb();
}

$footerSettings = [];
if ($db) {
    $query = "SELECT * FROM footer_settings LIMIT 1";
    $result = @pg_query($db, $query);
    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $footerSettings = $row;
        // Decode JSON fields
        $footerSettings['quick_links'] = !empty($row['quick_links']) ? json_decode($row['quick_links'], true) : [];
        $footerSettings['resources'] = !empty($row['resources']) ? json_decode($row['resources'], true) : [];
    }
}

// Default values if settings not available
$footer_desc = $footerSettings['description'] ?? 'Laboratorium Intelligent Vision and Smart System - Pusat riset Computer Vision, AI, dan IoT di Politeknik Negeri Malang.';
$footer_email = $footerSettings['email'] ?? 'ivss@polinema.ac.id';
$footer_phone = $footerSettings['phone'] ?? '(0341) 404424';
$footer_address = $footerSettings['address'] ?? 'Jurusan Teknologi Informasi, Politeknik Negeri Malang';
$footer_instagram = $footerSettings['instagram'] ?? 'https://instagram.com/jtipolinema';
$footer_facebook = $footerSettings['facebook'] ?? '';
$footer_linkedin = $footerSettings['linkedin'] ?? '';
$footer_twitter = $footerSettings['twitter'] ?? '';
$footer_youtube = $footerSettings['youtube'] ?? '';
$quick_links = $footerSettings['quick_links'] ?? [];
$resources = $footerSettings['resources'] ?? [];

// Bottom bar fields
$footer_copyright = $footerSettings['copyright_text'] ?? 'Lab IVSS - Jurusan Teknologi Informasi, Politeknik Negeri Malang';
$footer_privacy_url = $footerSettings['privacy_url'] ?? '';
$footer_terms_url = $footerSettings['terms_url'] ?? '';
$footer_operating_hours = $footerSettings['operating_hours'] ?? 'Senin - Jumat<br>08:00 - 16:00 WIB';
?>
<!-- Footer Modern -->
<footer class="bg-gray-900 text-white mt-auto">
    <!-- Main Footer Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">

            <!-- Kolom 1: About Lab -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-5 border-2 border-white border-opacity-10 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Lab IVSS</h3>
                        <p class="text-xs text-gray-500">JTI Polinema</p>
                    </div>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">
                    <?= htmlspecialchars($footer_desc) ?>
                </p>
                <!-- Social Media -->
                <div class="flex items-center space-x-3 pt-2">
                    <?php if (!empty($footer_instagram)): ?>
                        <a href="<?= htmlspecialchars($footer_instagram) ?>" target="_blank" class="w-10 h-10 bg-white bg-opacity-10 border border-white border-opacity-30 hover:bg-white hover:bg-opacity-20 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($footer_facebook)): ?>
                        <a href="<?= htmlspecialchars($footer_facebook) ?>" target="_blank" class="w-10 h-10 bg-white bg-opacity-10 border border-white border-opacity-30 hover:bg-white hover:bg-opacity-20 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($footer_twitter)): ?>
                        <a href="<?= htmlspecialchars($footer_twitter) ?>" target="_blank" class="w-10 h-10 bg-white bg-opacity-10 border border-white border-opacity-30 hover:bg-white hover:bg-opacity-20 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($footer_youtube)): ?>
                        <a href="<?= htmlspecialchars($footer_youtube) ?>" target="_blank" class="w-10 h-10 bg-white bg-opacity-10 border border-white border-opacity-30 hover:bg-white hover:bg-opacity-20 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($footer_linkedin)): ?>
                        <a href="<?= htmlspecialchars($footer_linkedin) ?>" target="_blank" class="w-10 h-10 bg-white bg-opacity-10 border border-white border-opacity-30 hover:bg-white hover:bg-opacity-20 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Kolom 2: Quick Links (Dynamic) -->
            <div>
                <h4 class="font-bold text-lg mb-4 text-white flex items-center">
                    <span class="w-1 h-6 bg-blue-500 mr-3 rounded-full"></span>
                    Link Cepat
                </h4>
                <ul class="space-y-2">
                    <?php if (!empty($quick_links)): ?>
                        <?php foreach ($quick_links as $link): ?>
                            <li>
                                <a href="<?= htmlspecialchars($link['url']) ?>" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                                    <svg class="w-4 h-4 mr-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <?= htmlspecialchars($link['label']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>
                            <a href="#profil" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                                <svg class="w-4 h-4 mr-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Profil Laboratorium
                            </a>
                        </li>
                        <li>
                            <a href="#riset" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                                <svg class="w-4 h-4 mr-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Riset & Penelitian
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Kolom 3: Contact Info (Dynamic) -->
            <div>
                <h4 class="font-bold text-lg mb-4 text-white flex items-center">
                    <span class="w-1 h-6 bg-blue-500 mr-3 rounded-full"></span>
                    Kontak
                </h4>
                <ul class="space-y-3">
                    <?php if (!empty($footer_address)): ?>
                        <li class="flex items-start space-x-3 group">
                            <div class="w-9 h-9 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-white group-hover:bg-opacity-20 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="text-xs text-gray-300">
                                <p class="font-medium text-white mb-1">Alamat</p>
                                <?= htmlspecialchars($footer_address) ?>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($footer_email)): ?>
                        <li class="flex items-center space-x-3 group">
                            <div class="w-9 h-9 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-white group-hover:bg-opacity-20 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Email</p>
                                <a href="mailto:<?= htmlspecialchars($footer_email) ?>" class="text-sm text-gray-300 hover:text-white transition-colors"><?= htmlspecialchars($footer_email) ?></a>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($footer_phone)): ?>
                        <li class="flex items-center space-x-3 group">
                            <div class="w-9 h-9 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-white group-hover:bg-opacity-20 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Telepon</p>
                                <a href="tel:<?= htmlspecialchars($footer_phone) ?>" class="text-sm text-gray-300 hover:text-white transition-colors"><?= htmlspecialchars($footer_phone) ?></a>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Kolom 4: Newsletter/CTA -->
            <div>
                <h4 class="font-bold text-lg mb-4 text-white flex items-center">
                    <span class="w-1 h-6 bg-blue-500 mr-3 rounded-full"></span>
                    Bergabung
                </h4>
                <p class="text-sm text-gray-400 mb-4">
                    Tertarik bergabung dengan Lab IVSS? Daftar sekarang!
                </p>
                <a href="index.php?page=register" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Daftar Member
                </a>
                <div class="mt-4 p-3 bg-gray-800 bg-opacity-50 rounded-lg border border-gray-700">
                    <p class="text-xs text-gray-300">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?= nl2br ($footer_operating_hours) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-800 bg-black">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0">
                <p class="text-sm text-gray-400 text-center md:text-left">
                    &copy; <?= date('Y') ?> <span class="text-white font-semibold"><?= htmlspecialchars($footer_copyright) ?></span>
                </p>
                <div class="flex items-center space-x-4 text-sm">
                    <?php if (!empty($footer_privacy_url)): ?>
                        <a href="<?= htmlspecialchars($footer_privacy_url) ?>" class="text-gray-400 hover:text-white transition-colors">Privacy</a>
                        <span class="text-gray-600">•</span>
                    <?php endif; ?>
                    <?php if (!empty($footer_terms_url)): ?>
                        <a href="<?= htmlspecialchars($footer_terms_url) ?>" class="text-gray-400 hover:text-white transition-colors">Terms</a>
                    <?php endif; ?>
                <div class="flex items-center space-x-4 text-sm">
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">Privacy</a>
                    <span class="text-gray-700">•</span>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">Terms</a>
                </div>
            </div>
        </div>
    </div>
</footer>