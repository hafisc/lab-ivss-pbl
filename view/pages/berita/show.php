<!-- Halaman Detail Berita -->
<!-- Menampilkan konten lengkap dari sebuah berita atau artikel -->
<div class="pt-24 pb-16 min-h-screen bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <!-- Breadcrumb (Navigasi Jalur) -->
        <nav class="flex mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="index.php" class="inline-flex items-center hover:text-blue-900 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="index.php?page=news" class="ml-1 md:ml-2 hover:text-blue-900 transition-colors">Berita</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 md:ml-2 text-gray-700 font-medium truncate max-w-xs"><?= htmlspecialchars($news['title']) ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header Artikel -->
        <header class="mb-10 text-center">
            <!-- Kategori -->
            <?php if (!empty($news['category'])): ?>
            <div class="mb-4">
               <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full uppercase tracking-wide">
                   <?= htmlspecialchars($news['category']) ?>
               </span>
            </div>
            <?php endif; ?>
            
            <!-- Judul Berita -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                <?= htmlspecialchars($news['title']) ?>
            </h1>
            
            <!-- Meta Data -->
            <div class="flex items-center justify-center gap-6 text-sm text-gray-500">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="font-medium"><?= htmlspecialchars($news['author_name'] ?? 'Admin') ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <time datetime="<?= $news['published_at'] ?>">
                        <?= date('d M Y', strtotime($news['published_at'])) ?>
                    </time>
                </div>
                <div class="flex items-center gap-2">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                     <span><?= number_format($news['views'] ?? 0) ?> views</span>
                </div>
            </div>
        </header>

        <!-- Gambar Utama (Featured Image) -->
        <?php if (!empty($news['image_url'])): ?>
        <div class="relative w-full h-[300px] md:h-[500px] mb-12 rounded-2xl overflow-hidden shadow-2xl">
            <img src="<?= htmlspecialchars($news['image_url']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover">
        </div>
        <?php endif; ?>

        <!-- Konten Artikel -->
        <article class="prose prose-lg prose-blue mx-auto text-gray-700 leading-relaxed max-w-none">
            <?php 
                // Menampilkan konten. Cek apakah konten berupa HTML (dari WYSIWYG) atau teks biasa.
                if ($news['content'] != strip_tags($news['content'])) {
                    echo $news['content'];
                } else {
                    echo nl2br($news['content']);
                }
            ?>
        </article>

        <!-- Lampiran File -->
        <?php if (!empty($news['file_path'])): ?>
        <div class="mt-12 p-6 bg-blue-50 rounded-xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between group hover:bg-blue-100 transition-colors gap-4">
            <div class="flex items-center gap-4 w-full sm:w-auto">
                <div class="w-12 h-12 bg-blue-900 text-white rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 group-hover:text-blue-900">Dokumen Lampiran</h3>
                    <p class="text-sm text-gray-500">Unduh dokumen terkait berita ini</p>
                </div>
            </div>
            <a href="<?= htmlspecialchars($news['file_path']) ?>" target="_blank" download class="w-full sm:w-auto px-6 py-2 bg-blue-900 text-white rounded-lg font-medium hover:bg-blue-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                Download
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </a>
        </div>
        <?php endif; ?>

        <!-- Share & Tags -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <?php if (!empty($news['tags'])): 
                $tags = explode(',', $news['tags']);
            ?>
            <div class="flex flex-wrap gap-2 mb-8">
                <span class="text-sm font-semibold text-gray-500 flex items-center mr-2">Tags:</span>
                <?php foreach($tags as $tag): ?>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm hover:bg-gray-200 cursor-pointer transition-colors">#<?= trim(htmlspecialchars($tag)) ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
