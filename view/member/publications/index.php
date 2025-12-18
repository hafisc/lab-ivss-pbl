<?php 
ob_start();
// $myPublications is passed from controller
?>


<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?= $_SESSION['success'] ?></span>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?= $_SESSION['error'] ?></span>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Header -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 mb-1">Publikasi Saya</h1>
            <p class="text-sm text-slate-500">Kelola paper dan jurnal penelitian kamu</p>
        </div>
        <a href="index.php?page=member-publication-create" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Publikasi
        </a>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <div class="flex items-center justify-between mb-2">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-slate-800"><?= count($myPublications) ?></h3>
        <p class="text-xs text-slate-600">Total Publikasi</p>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800"><?= count(array_filter($myPublications, fn($p) => $p['status'] === 'published')) ?></h3>
        <p class="text-xs text-slate-600">Published</p>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800"><?= count(array_filter($myPublications, fn($p) => $p['status'] === 'draft')) ?></h3>
        <p class="text-xs text-slate-600">Draft</p>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800"><?= array_sum(array_column($myPublications, 'citation_count')) ?></h3>
        <p class="text-xs text-slate-600">Total Citations</p>
    </div>
</div>

<!-- Tabs -->
<div class="mb-6">
    <div class="border-b border-slate-200">
        <nav class="flex gap-6">
            <button onclick="showTab('all')" id="tab-all" class="pb-3 px-1 text-sm font-medium border-b-2 border-purple-600 text-purple-600">
                Semua
            </button>
            <button onclick="showTab('published')" id="tab-published" class="pb-3 px-1 text-sm font-medium border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                Published
            </button>
            <button onclick="showTab('draft')" id="tab-draft" class="pb-3 px-1 text-sm font-medium border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                Draft
            </button>
        </nav>
    </div>
</div>

<!-- Publications List -->
<?php if (empty($myPublications)): ?>
<div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
    </div>
    <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Publikasi</h3>
    <p class="text-sm text-slate-500 mb-6">Tambahkan publikasi pertama kamu</p>
    <a href="index.php?page=member-publication-create" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Publikasi
    </a>
</div>
<?php else: ?>
<div class="space-y-4">
    <?php foreach ($myPublications as $pub): ?>
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300" data-status="<?= $pub['status'] ?>">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="flex-1">
                    <div class="flex items-start gap-3 mb-2">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-slate-800 mb-1"><?= htmlspecialchars($pub['title']) ?></h3>
                            <p class="text-sm text-slate-600 mb-2"><?= htmlspecialchars($pub['authors']) ?></p>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                    <?= htmlspecialchars($pub['journal']) ?>
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?= $pub['year'] ?>
                                </span>
                                <?php if ($pub['doi']): ?>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    DOI: <?= htmlspecialchars($pub['doi']) ?>
                                </span>
                                <?php endif; ?>
                                <?php if ($pub['citation_count'] > 0): ?>
                                <span class="flex items-center gap-1 text-blue-600 font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                    <?= $pub['citation_count'] ?> citations
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <?php if ($pub['status'] === 'published'): ?>
                        <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                            Published
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-1 bg-orange-100 text-orange-700 text-xs font-medium rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Draft
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="flex items-center gap-2 pt-4 border-t border-slate-200">
                <?php if ($pub['file_path']): ?>
                <a href="<?= htmlspecialchars($pub['file_path']) ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors" target="_blank" download>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download PDF
                </a>
                <?php endif; ?>
                <a href="index.php?page=member-publication-edit&id=<?= $pub['id'] ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 text-sm rounded-lg hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <button onclick="deletePublication(<?= $pub['id'] ?>)" class="inline-flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 text-sm rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<script>
function showTab(tab) {
    document.querySelectorAll('[id^="tab-"]').forEach(btn => {
        btn.classList.remove('border-purple-600', 'text-purple-600');
        btn.classList.add('border-transparent', 'text-slate-500');
    });
    document.getElementById('tab-' + tab).classList.add('border-purple-600', 'text-purple-600');
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-slate-500');
    
    const cards = document.querySelectorAll('[data-status]');
    cards.forEach(card => {
        if (tab === 'all' || card.dataset.status === tab) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function deletePublication(id) {
    if (confirm('Yakin hapus publikasi ini?')) {
        window.location.href = 'index.php?page=member-publication-delete&id=' + id;
    }
}
</script>

<?php
$content = ob_get_clean();
$title = "Publikasi Saya";
require_once __DIR__ . '/../../layouts/member.php';
?>