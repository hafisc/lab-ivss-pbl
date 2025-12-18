<?php
require_once __DIR__ . '/../../../app/config/Database.php'; 
// Asumsi sudah dikoneksikan via index.php atau controller.
// Namun untuk amannya kita check connection.
$db = Database::getInstance()->getPgConnection();

// Fetch Research
$query = "SELECT r.*, u.username as leader_name 
          FROM research r 
          LEFT JOIN users u ON r.leader_id = u.id 
          WHERE r.status = 'active' 
          ORDER BY r.created_at DESC";
$result = pg_query($db, $query);
$researchList = [];

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $researchList[] = $row;
    }
}
?>

<section id="riset" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Riset Unggulan</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Inovasi dan penelitian terkini dari Lab IVSS untuk solusi masa depan</p>
                <div class="h-1 w-24 bg-purple-900 mx-auto rounded-full mt-4"></div>
            </div>

            <!-- Swiper Container -->
            <div class="swiper researchSwiper relative !pb-12 px-4">
                <div class="swiper-wrapper">
                    <?php if (!empty($researchList)): ?>
                        <?php foreach ($researchList as $research): ?>
                            <div class="swiper-slide !h-auto">
                                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 !h-full flex flex-col group border border-purple-50">
                                    <div class="relative h-48 overflow-hidden">
                                        <?php if (!empty($research['image'])): ?>
                                            <img src="<?= htmlspecialchars($research['image']) ?>" alt="<?= htmlspecialchars($research['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        <?php else: ?>
                                            <div class="w-full h-full bg-gradient-to-br from-purple-600 to-indigo-800 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        
                                        <!-- Category Badge -->
                                        <div class="absolute top-4 left-4">
                                            <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-purple-900 text-xs font-bold rounded-full shadow-sm">
                                                <?= htmlspecialchars($research['category'] ?? 'Research') ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-8 flex flex-col flex-grow relative">
                                        <!-- Floating Date Badge -->
                                        <div class="absolute -top-6 right-8 w-12 h-12 bg-purple-900 rounded-xl flex flex-col items-center justify-center text-white shadow-lg border-2 border-white transform group-hover:-translate-y-1 transition-transform">
                                            <span class="text-xs font-bold"><?= date('M', strtotime($research['start_date'] ?? 'now')) ?></span>
                                            <span class="text-lg font-bold leading-none"><?= date('d', strtotime($research['start_date'] ?? 'now')) ?></span>
                                        </div>

                                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-purple-700 transition-colors line-clamp-2">
                                            <?= htmlspecialchars($research['title']) ?>
                                        </h3>
                                        
                                        <p class="text-gray-600 mb-6 text-sm flex-grow line-clamp-3 leading-relaxed">
                                            <?= htmlspecialchars(mb_strimwidth(strip_tags($research['description']), 0, 150, "...")) ?>
                                        </p>

                                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 mt-auto">
                                            <div class="flex items-center gap-2">
                                                 <!-- Leader Avatar Placeholder -->
                                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-xs ring-2 ring-white shadow-sm">
                                                    <?= substr(strtoupper($research['leader_name'] ?? 'L'), 0, 1) ?>
                                                </div>
                                                <span class="text-sm font-medium text-gray-500">
                                                    <?= htmlspecialchars($research['leader_name'] ?? 'Team') ?>
                                                </span>
                                            </div>
                                            <!-- Optional: Detail Link -->
                                            <!-- <a href="#" class="text-purple-900 hover:text-purple-700 font-semibold text-sm flex items-center gap-1 transition-all group-hover:gap-2">
                                                Detail
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                            </a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-3 text-center py-12">
                            <p class="text-gray-500">Belum ada data riset yang aktif.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Swiper Pagination -->
                <div class="swiper-pagination !bottom-0"></div>
                
                <!-- Swiper Navigation -->
                <!-- <div class="swiper-button-next !text-purple-900 after:!text-xl !w-10 !h-10 !bg-white/80 !rounded-full !shadow-lg hover:!bg-white !hidden sm:!flex"></div>
                <div class="swiper-button-prev !text-purple-900 after:!text-xl !w-10 !h-10 !bg-white/80 !rounded-full !shadow-lg hover:!bg-white !hidden sm:!flex"></div> -->
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.researchSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            }
        });
    });
</script>
