<!-- Profile Settings -->
<div class="bg-white border border-slate-200 rounded-xl p-6">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-slate-800">Profil Saya</h3>
        <p class="text-sm text-slate-500 mt-1">Update informasi profil Anda</p>
    </div>

    <form method="POST" action="index.php?page=admin-settings&action=update-profile" enctype="multipart/form-data" class="space-y-6">
        
        <!-- Profile Photo -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-3">Foto Profil</label>
            <div class="flex items-center gap-4">
                <?php if (!empty($currentUser['photo'])): ?>
                    <img src="<?= htmlspecialchars($currentUser['photo']) ?>" alt="Profile" class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                <?php else: ?>
                    <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-2xl font-bold text-blue-700">
                        <?= strtoupper(substr($currentUser['name'] ?? 'A', 0, 1)) ?>
                    </div>
                <?php endif; ?>
                <div>
                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                    <label for="photo" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg cursor-pointer transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Ubah Foto
                    </label>
                    <p class="text-xs text-slate-500 mt-1">JPG, PNG atau WebP (Max. 2MB)</p>
                </div>
            </div>
        </div>
        
        <script>
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Find the image or create new one
                    const container = input.closest('div').closest('div').querySelector('.w-20');
                    if (container.tagName === 'IMG') {
                        container.src = e.target.result;
                    } else {
                        // Replace div with img
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-20 h-20 rounded-full object-cover border-2 border-slate-200';
                        img.alt = 'Preview';
                        container.replaceWith(img);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap *</label>
            <input type="text" id="name" name="name" required
                   value="<?= htmlspecialchars($currentUser['name'] ?? '') ?>"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email *</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">No. Telepon</label>
            <input type="tel" id="phone" name="phone"
                   value="<?= htmlspecialchars($currentUser['phone'] ?? '') ?>"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="08xxxxxxxxxx">
        </div>

        <!-- NIP/NIM -->
        <div>
            <label for="nim" class="block text-sm font-medium text-slate-700 mb-2">NIP/NIM</label>
            <input type="text" id="nim" name="nim"
                   value="<?= htmlspecialchars($currentUser['nim'] ?? '') ?>"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Bio -->
        <div>
            <label for="bio" class="block text-sm font-medium text-slate-700 mb-2">Bio</label>
            <textarea id="bio" name="bio" rows="4"
                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Ceritakan sedikit tentang Anda..."><?= htmlspecialchars($currentUser['bio'] ?? '') ?></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" class="px-6 py-2.5 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors">
                Simpan Perubahan
            </button>
            <button type="reset" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                Reset
            </button>
        </div>
    </form>
</div>
