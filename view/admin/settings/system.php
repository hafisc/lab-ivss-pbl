<h2 class="text-lg font-semibold text-slate-800 mb-4">Pengaturan Sistem</h2>

<form action="index.php?page=admin-settings&action=update-system" method="POST" enctype="multipart/form-data" class="space-y-6">
    <!-- Site Identity -->
    <div class="bg-white border border-slate-200 rounded-xl p-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-4">Identitas Website</h3>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Nama Website (Tab Title)</label>
                <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>
            
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Deskripsi Website</label>
                <textarea name="site_description" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Header & Logo -->
    <div class="bg-white border border-slate-200 rounded-xl p-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-4">Header & Logo</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Text Topbar (Running Text)</label>
                <input type="text" name="topbar_text" value="<?= htmlspecialchars($settings['topbar_text'] ?? '') ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Nama Institusi (Header)</label>
                <input type="text" name="institution_name" value="<?= htmlspecialchars($settings['institution_name'] ?? '') ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Nama Lab (Header)</label>
                <input type="text" name="lab_name" value="<?= htmlspecialchars($settings['lab_name'] ?? '') ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>
            
             <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Logo URL (Atau Upload)</label>
                <input type="text" name="logo_url" value="<?= htmlspecialchars($settings['logo_url'] ?? '') ?>" placeholder="assets/images/logo.png" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm mb-2">
                <input type="file" name="logo" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="bg-white border border-slate-200 rounded-xl p-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-4">Informasi Kontak (Footer)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Email Kontak</label>
                <input type="email" name="contact_email" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Telepon Lab</label>
                <input type="text" name="contact_phone" value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors shadow-lg shadow-blue-600/20">
            Simpan Perubahan
        </button>
    </div>
</form>
