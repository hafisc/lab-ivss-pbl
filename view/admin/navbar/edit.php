<div class="max-w-4xl mx-auto py-8">
    <form method="POST" action="index.php?page=admin-navbar&action=update" enctype="multipart/form-data" class="space-y-6">
        
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-900">Edit Navbar</h1>
            <a href="index.php?page=admin-navbar" class="text-sm text-gray-600 hover:underline">Kembali</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm font-medium mb-1">Top Bar Text</label>
            <textarea name="topbar_text" rows="2" class="w-full border rounded-lg px-3 py-2"><?= htmlspecialchars($navbarSettings['topbar_text']) ?></textarea>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Logo & Identitas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm mb-1">Nama Institusi</label>
                    <input type="text" name="institution_name" value="<?= htmlspecialchars($navbarSettings['institution_name']) ?>" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm mb-1">Nama Lab</label>
                    <input type="text" name="lab_name" value="<?= htmlspecialchars($navbarSettings['lab_name']) ?>" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
            
            <label class="block text-sm mb-1">Logo</label>
            <div class="flex items-center space-x-4">
                <img id="logo-preview" src="<?= $navbarSettings['logo_url'] ?>" class="h-16 w-16 object-contain border rounded">
                <input type="file" name="logo_file" id="logo_file" accept="image/*" class="text-sm">
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold">Menu Navigasi</h3>
                <button type="button" id="addMenuBtn" class="bg-green-600 text-white px-3 py-1 rounded text-sm">+ Tambah</button>
            </div>
            <div id="menuItemsContainer" class="space-y-3">
                <?php foreach ($navbarSettings['menu_items'] as $index => $menu): ?>
                <div class="menu-item flex gap-2">
                    <input type="text" name="menu_items[<?= $index ?>][label]" value="<?= htmlspecialchars($menu['label']) ?>" placeholder="Label" class="flex-1 border rounded px-2 py-1">
                    <input type="text" name="menu_items[<?= $index ?>][url]" value="<?= htmlspecialchars($menu['url']) ?>" placeholder="URL (#beranda)" class="flex-1 border rounded px-2 py-1">
                    <button type="button" class="removeMenuBtn text-red-500 px-2">×</button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <label class="block text-sm mb-1">URL Login</label>
            <input type="text" name="login_url" value="<?= htmlspecialchars($navbarSettings['login_url']) ?>" class="w-full border rounded-lg px-3 py-2">
            <div class="flex justify-end mt-6 space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

<script>
    // Preview Gambar
    document.getElementById('logo_file').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = (e) => document.getElementById('logo-preview').src = e.target.result;
        reader.readAsDataURL(e.target.files[0]);
    });

    // Tambah & Hapus Menu
    let menuIndex = <?= count($navbarSettings['menu_items']) ?>;
    document.getElementById('addMenuBtn').addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'menu-item flex gap-2';
        div.innerHTML = `<input type="text" name="menu_items[${menuIndex}][label]" placeholder="Label" class="flex-1 border rounded px-2 py-1">
                         <input type="text" name="menu_items[${menuIndex}][url]" placeholder="URL" class="flex-1 border rounded px-2 py-1">
                         <button type="button" class="removeMenuBtn text-red-500 px-2">×</button>`;
        document.getElementById('menuItemsContainer').appendChild(div);
        menuIndex++;
    });

    document.addEventListener('click', (e) => {
        if(e.target.classList.contains('removeMenuBtn')) e.target.closest('.menu-item').remove();
    });
</script>