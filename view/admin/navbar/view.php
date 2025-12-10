<div class="max-w-4xl mx-auto py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manajemen Navbar</h1>
                <p class="mt-2 text-gray-600">Kelola tampilan navigasi</p>
            </div>
            <a href="index.php?page=admin-navbar&action=edit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Navbar
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

        <!-- Top Bar Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Top Bar
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Top Bar Text</label>
                    <p class="text-gray-600 text-sm line-clamp-2"><?= htmlspecialchars($navbarSettings['topbar_text'] ?? 'Belum diatur') ?></p>
                </div>
            </div>
        </div>

        <!-- Logo & Identity Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Logo & Identity
            </h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600 block mb-1">Institution Name:</span>
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($navbarSettings['institution_name'] ?? '-') ?></p>
                </div>
                <div>
                    <span class="text-sm text-gray-600 block mb-1">Lab Name:</span>
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($navbarSettings['lab_name'] ?? '-') ?></p>
                </div>
                <div>
                    <span class="text-sm text-gray-600 block mb-1">Logo URL:</span>
                    <p class="font-medium text-gray-900 text-sm break-all"><?= htmlspecialchars($navbarSettings['logo_url'] ?? '-') ?></p>
                </div>
            </div>
        </div>

        <!-- Menu Items Section -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                Menu Items
            </h3>
            <div class="space-y-2">
                <?php if (!empty($navbarSettings['menu_items'])): ?>
                    <?php foreach ($navbarSettings['menu_items'] as $menu): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($menu['label']) ?></span>
                            <span class="text-sm text-gray-600"><?= htmlspecialchars($menu['url']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">Belum ada menu items</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Button Section -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l8-4-5 2"></path>
                </svg>
                Login Button
            </h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600 block mb-1">Login URL:</span>
                    <p class="font-medium text-gray-900 break-all"><?= htmlspecialchars($navbarSettings['login_url'] ?? '-') ?></p>
                </div>
            </div>
        </div>

    </div>

</div>