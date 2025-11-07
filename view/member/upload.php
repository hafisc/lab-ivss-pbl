<?php ob_start(); ?>

<div class="max-w-4xl mx-auto">
    
    <!-- Page Title -->
    <div class="mb-4">
        <h1 class="text-lg font-bold text-slate-900">Upload Dokumen</h1>
        <p class="text-slate-600 text-xs mt-0.5">Upload laporan riset, dokumentasi, atau file penting lainnya</p>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
    <div class="mb-3 bg-emerald-50 border border-emerald-200 rounded-lg p-3">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-xs font-medium text-emerald-900"><?= $_SESSION['success'] ?></p>
        </div>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="mb-3 bg-red-50 border border-red-200 rounded-lg p-3">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-xs font-medium text-red-900"><?= $_SESSION['error'] ?></p>
        </div>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <form action="index.php?page=member-upload" method="POST" enctype="multipart/form-data" class="p-4 space-y-4">
            
            <!-- Pilih Riset -->
            <div>
                <label for="research_id" class="block text-xs font-medium text-slate-700 mb-1.5">
                    Pilih Riset <span class="text-red-600">*</span>
                </label>
                <select id="research_id" name="research_id" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-slate-900 text-xs">
                    <option value="">-- Pilih Riset --</option>
                    <?php if (!empty($myResearches)): ?>
                        <?php foreach ($myResearches as $research): ?>
                            <option value="<?= $research['id'] ?>"><?= htmlspecialchars($research['title']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <?php if (empty($myResearches)): ?>
                    <p class="mt-1.5 text-xs text-amber-600">⚠️ Kamu belum terdaftar di riset manapun. Hubungi admin untuk bergabung.</p>
                <?php endif; ?>
            </div>
            
            <!-- Judul File -->
            <div>
                <label for="title" class="block text-xs font-medium text-slate-700 mb-1.5">
                    Judul Dokumen <span class="text-red-600">*</span>
                </label>
                <input type="text" id="title" name="title" required
                       placeholder="Contoh: Laporan Progress Minggu 1"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
            </div>
            
            <!-- Upload File -->
            <div>
                <label for="file" class="block text-xs font-medium text-slate-700 mb-1.5">
                    Pilih File <span class="text-red-600">*</span>
                </label>
                <input type="file" id="file" name="file" required
                       accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer text-xs">
                <p class="mt-1.5 text-xs text-slate-500">Format yang didukung: PDF, DOC, DOCX, PPT, PPTX, ZIP, RAR (Maksimal 10MB)</p>
            </div>
            
            <!-- Keterangan -->
            <div>
                <label for="description" class="block text-xs font-medium text-slate-700 mb-1.5">
                    Keterangan <span class="text-slate-400 text-xs">(Opsional)</span>
                </label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Tambahkan keterangan atau deskripsi singkat tentang dokumen ini..."
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none text-xs"></textarea>
            </div>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-2 pt-3">
                <button type="submit" 
                        class="w-full sm:flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload File Sekarang
                </button>
                <a href="index.php?page=member" 
                   class="w-full sm:w-auto px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg transition-all border border-slate-300 hover:border-slate-400 flex items-center justify-center gap-1.5 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
            
        </form>
    </div>
    
    <!-- Tips & Info Grid -->
    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-indigo-200 rounded-lg p-3 shadow-md">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg mb-2">
                <svg class="w-8 h-8 p-1.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            </div>
            <h4 class="font-bold text-indigo-900 mb-1.5 text-xs">📄 Format File</h4>
            <p class="text-xs text-indigo-700">PDF, DOC, DOCX, PPT, PPTX, ZIP, RAR dengan maksimal ukuran 10MB</p>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-200 rounded-lg p-3 shadow-md">
            <div class="w-8 h-8 bg-purple-600 rounded-lg mb-2">
                <svg class="w-8 h-8 p-1.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>
            <h4 class="font-bold text-purple-900 mb-1.5 text-xs">✅ Review Process</h4>
            <p class="text-xs text-purple-700">File akan ditinjau oleh leader riset sebelum disetujui</p>
        </div>
        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 border border-teal-200 rounded-lg p-3 shadow-md">
            <div class="w-8 h-8 bg-teal-600 rounded-lg mb-2">
                <svg class="w-8 h-8 p-1.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
            </div>
            <h4 class="font-bold text-teal-900 mb-1.5 text-xs">📝 Nama File</h4>
            <p class="text-xs text-teal-700">Gunakan nama file yang jelas dan deskriptif</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = "Upload Laporan";
include __DIR__ . "/../layouts/member.php";
?>
