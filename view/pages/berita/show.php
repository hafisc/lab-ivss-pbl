<?php
// Pastikan dependencies dimuat/dikoneksikan
require_once __DIR__ . '/../../../app/config/Database.php';
require_once __DIR__ . '/../../../app/models/news.php';

// Koneksi Database
$db = Database::getInstance()->getPgConnection();
$newsModel = new News($db);

// Ambil Slug dari URL
$slug = $_GET['slug'] ?? '';
$news = null;

if (!empty($slug)) {
    $news = $newsModel->getBySlug($slug);
    
    // Increment view count jika berita ditemukan
    if ($news) {
        $newsModel->incrementViews($news['id']);
    }
}

// Redirect atau tampilkan 404 jika berita tidak ditemukan (opsional, di sini kita tampilkan pesan saja)
if (!$news) {
    echo "<div class='min-h-screen flex items-center justify-center bg-gray-50'><div class='text-center'><h1 class='text-6xl font-bold text-gray-900 mb-4'>404</h1><p class='text-xl text-gray-600 mb-8'>Berita tidak ditemukan atau telah dihapus.</p><a href='index.php?page=news' class='px-8 py-3 bg-blue-900 text-white rounded-full font-bold hover:bg-blue-800 transition-all'>Kembali ke Berita</a></div></div>";
    exit;
}

// Format Tanggal
$date = date('d F Y', strtotime($news['published_at']));
$readTime = ceil(str_word_count(strip_tags($news['content'])) / 200); // Estimasi waktu baca
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($news['title']) ?> - Lab IVSS</title>
    <!-- Tailwind CSS (Assuming it's loaded in parent, but included here for standalone checking) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Plus Jakarta Sans for Modern Look -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #1e3a8a; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #1e40af; }

        /* Typography improvements */
        .prose p { margin-bottom: 1.5rem; line-height: 1.8; color: #374151; font-size: 1.125rem; }
        .prose h2 { font-size: 1.875rem; font-weight: 800; margin-top: 2.5rem; margin-bottom: 1rem; color: #111827; letter-spacing: -0.025em; }
        .prose h3 { font-size: 1.5rem; font-weight: 700; margin-top: 2rem; margin-bottom: 0.75rem; color: #1f2937; }
        .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.5rem; }
        .prose img { border-radius: 1rem; margin: 2rem 0; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); width: 100%; }
        .prose blockquote { border-left: 4px solid #1e3a8a; padding-left: 1rem; font-style: italic; color: #4b5563; margin: 1.5rem 0; background: #eff6ff; padding: 1.5rem; border-radius: 0 1rem 1rem 0; }
        
        /* Progress Bar */
        .progress-container { width: 100%; height: 4px; background: transparent; position: fixed; top: 0; left: 0; z-index: 50; }
        .progress-bar { height: 4px; background: #1e3a8a; width: 0%; transition: width 0.1s; }
    </style>
</head>
<body class="bg-[#fafafa] text-gray-900 antialiased selection:bg-blue-200 selection:text-blue-900">

    <!-- Scroll Progress Bar -->
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>


    <!-- Navbar -->
    <?php include __DIR__ . '/../partials/navbar.php'; ?>


    <main class="pt-10 pb-20 px-4 sm:px-6">
        <!-- Header Section -->
        <article class="max-w-4xl mx-auto">
            <!-- Breadcrumb & Category -->
            <div class="flex flex-wrap items-center gap-3 text-sm font-medium mb-6 animate-fade-in-up">
                <a href="index.php" class="text-gray-400 hover:text-blue-900 transition-colors">Home</a>
                <span class="text-gray-300">/</span>
                <a href="index.php?page=news" class="text-gray-400 hover:text-blue-900 transition-colors">Berita</a>
                <span class="text-gray-300">/</span>
                <span class="px-3 py-1 bg-blue-50 text-blue-900 rounded-full border border-blue-100">
                    <?= !empty($news['category']) ? htmlspecialchars($news['category']) : 'Umum' ?>
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-8 tracking-tight animate-fade-in-up" style="animation-delay: 0.1s;">
                <?= htmlspecialchars($news['title']) ?>
            </h1>

            <!-- Author & Meta -->
            <div class="flex items-center justify-between border-y border-gray-100 py-6 mb-10 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-blue-500 to-purple-600 p-[2px]">
                        <div class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                            <!-- Placeholder Avatar based on name -->
                            <span class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-tr from-blue-500 to-purple-600">
                                <?= substr(strtoupper($news['author_name'] ?? 'A'), 0, 1) ?>
                            </span>
                        </div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-base"><?= htmlspecialchars($news['author_name'] ?? 'Admin') ?></p>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <span><?= $date ?></span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span><?= $readTime ?> min read</span>
                        </p>
                    </div>
                </div>
                
                <!-- Share Buttons (Desktop) -->
                <div class="hidden sm:flex items-center gap-2">
                    <button onclick="copyLink()" class="p-2 text-gray-400 hover:text-blue-900 hover:bg-blue-50 rounded-full transition-all" title="Copy Link">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </button>
                    <!-- Add more share buttons here -->
                </div>
            </div>

            <!-- Hero Image -->
            <div class="relative w-full aspect-video rounded-3xl overflow-hidden shadow-2xl mb-12 group animate-fade-in-up" style="animation-delay: 0.3s;">
                <?php if (!empty($news['image_url'])): ?>
                    <img src="<?= htmlspecialchars($news['image_url']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <?php else: ?>
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-indigo-900 flex items-center justify-center">
                        <svg class="w-32 h-32 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                <?php endif; ?>
                
                <!-- Floating Views Badge -->
                <div class="absolute bottom-6 right-6 px-4 py-2 bg-black/50 backdrop-blur-md rounded-full text-white text-sm font-medium flex items-center gap-2 border border-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <?= number_format($news['views']) ?> Views
                </div>
            </div>

            <!-- Content Body -->
            <div class="prose prose-lg prose-blue mx-auto max-w-none mb-16 animate-fade-in-up" style="animation-delay: 0.4s;">
                <?= $news['content'] // Note: Pastikan konten aman/sanitized saat input admin, atau gunakan library purifier di sini. Asumsi aman. ?>
                
                <?php if (!empty($news['file_path'])): ?>
                <div class="mt-8 not-prose">
                    <a href="<?= htmlspecialchars($news['file_path']) ?>" target="_blank" download class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-all hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Lampiran / Dokumen
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Tags -->
            <?php if (!empty($news['tags'])): 
                $tags = explode(',', $news['tags']);
            ?>
            <div class="flex flex-wrap gap-2 mb-12 pt-8 border-t border-gray-100">
                <?php foreach ($tags as $tag): ?>
                    <a href="index.php?page=news&tag=<?= trim($tag) ?>" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-blue-100 hover:text-blue-900 transition-colors text-sm font-medium">#<?= trim($tag) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Navigation: Next/Prev Article Placeholder -->
            <!-- <div class="grid grid-cols-2 gap-4 mb-16"> ... </div> -->

        </article>
    </main>


    <!-- Footer Modern -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>


    <!-- Interactive Scripts -->
    <script>
        // Scroll Progress Bar Logic
        window.onscroll = function() { updateProgressBar() };

        function updateProgressBar() {
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
            
            // Navbar Glass Effect intensification
            const navbar = document.getElementById('navbar');
            if (winScroll > 50) {
                navbar.classList.add('shadow-md');
                navbar.classList.replace('bg-white/80', 'bg-white/95');
            } else {
                navbar.classList.remove('shadow-md');
                navbar.classList.replace('bg-white/95', 'bg-white/80');
            }
        }

        // Copy Link Function
        function copyLink() {
            navigator.clipboard.writeText(window.location.href);
            alert('Link copied to clipboard!'); 
            // Better: Show a visually pleasing toast notification instead of alert
        }
    </script>
    
    <style>
        /* Animation Classes */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0; /* Initial state */
        }
    </style>
</body>
</html>
