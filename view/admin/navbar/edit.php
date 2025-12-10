<?php
// Edit navbar settings form
?>

<div class="max-w-4xl mx-auto py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Navbar</h1>
                <p class="mt-2 text-gray-600">Sesuaikan pengaturan navigasi website Anda</p>
            </div>
            <a href="index.php?page=admin-navbar" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="index.php?page=admin-navbar&action=update" class="space-y-6">

        <!-- Top Bar Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Bar</h3>
            <div class="space-y-4">
                <div>
                    <label for="topbar_text" class="block text-sm font-medium text-gray-700 mb-1">Top Bar Text</label>
                    <textarea name="topbar_text" id="topbar_text" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., Welcome to our laboratory"><?= htmlspecialchars($navbarSettings['topbar_text'] ?? '') ?></textarea>
                    <p class="mt-1 text-sm text-gray-500">Teks yang muncul di top bar navbar</p>
                </div>
            </div>
        </div>

        <!-- Logo & Identity Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Logo & Identity</h3>
            <div class="space-y-4">
                <div>
                    <label for="institution_name" class="block text-sm font-medium text-gray-700 mb-1">Institution Name</label>
                    <input type="text" name="institution_name" id="institution_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., Politeknik Negeri Malang" value="<?= htmlspecialchars($navbarSettings['institution_name'] ?? '') ?>">
                    <p class="mt-1 text-sm text-gray-500">Nama institusi yang ditampilkan di navbar</p>
                </div>

                <div>
                    <label for="lab_name" class="block text-sm font-medium text-gray-700 mb-1">Lab Name</label>
                    <input type="text" name="lab_name" id="lab_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., Lab IVSS" value="<?= htmlspecialchars($navbarSettings['lab_name'] ?? '') ?>">
                    <p class="mt-1 text-sm text-gray-500">Nama laboratorium</p>
                </div>

                <div>
                    <label for="logo_url" class="block text-sm font-medium text-gray-700 mb-1">Logo URL</label>
                    <input type="text" name="logo_url" id="logo_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., assets/images/logo1.png" value="<?= htmlspecialchars($navbarSettings['logo_url'] ?? '') ?>">
                    <p class="mt-1 text-sm text-gray-500">Path atau URL menuju file logo (relatif atau absolut)</p>
                </div>
            </div>
        </div>

        <!-- Menu Items Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Menu Items</h3>
                <button type="button" id="addMenuBtn" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Menu
                </button>
            </div>

            <div id="menuItemsContainer" class="space-y-3">
                <?php
                $menuItems = $navbarSettings['menu_items'] ?? [];
                foreach ($menuItems as $index => $menu):
                ?>
                    <div class="menu-item flex gap-3 items-end">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                            <input type="text" name="menu_items[<?= $index ?>][label]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., Home" value="<?= htmlspecialchars($menu['label'] ?? '') ?>">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                            <input type="text" name="menu_items[<?= $index ?>][url]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., #home" value="<?= htmlspecialchars($menu['url'] ?? '') ?>">
                        </div>
                        <button type="button" class="removeMenuBtn px-3 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <p class="mt-4 text-sm text-gray-500">Kelola menu items yang muncul di navbar. Tambahkan label dan URL untuk setiap item.</p>
        </div>

        <!-- Login Button Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Login Button</h3>
            <div class="space-y-4">
                <div>
                    <label for="login_url" class="block text-sm font-medium text-gray-700 mb-1">Login URL</label>
                    <input type="text" name="login_url" id="login_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., index.php?page=login" value="<?= htmlspecialchars($navbarSettings['login_url'] ?? '') ?>">
                    <p class="mt-1 text-sm text-gray-500">URL untuk tombol login di navbar (relatif atau absolut)</p>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex gap-3 justify-end">
                <a href="index.php?page=admin-navbar" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Batalkan</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

<script>
    let menuIndex = <?= count($menuItems ?? []) ?>;

    document.getElementById('addMenuBtn').addEventListener('click', function() {
        const container = document.getElementById('menuItemsContainer');
        const newItem = document.createElement('div');
        newItem.className = 'menu-item flex gap-3 items-end';
        newItem.innerHTML = `
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                <input type="text" name="menu_items[${menuIndex}][label]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., Home">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                <input type="text" name="menu_items[${menuIndex}][url]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., #home">
            </div>
            <button type="button" class="removeMenuBtn px-3 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        container.appendChild(newItem);
        attachRemoveListener(newItem.querySelector('.removeMenuBtn'));
        menuIndex++;
    });

    function attachRemoveListener(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.closest('.menu-item').remove();
        });
    }

    document.querySelectorAll('.removeMenuBtn').forEach(attachRemoveListener);
</script>