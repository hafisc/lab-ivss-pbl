<!-- Bagian Anggota Tim -->
<!-- Menampilkan daftar dosen dan anggota tim laboratorium -->
<section id="member" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            <!-- Header Seksi -->
            <div class="text-center mb-16">
                <!-- Ikon Tim -->
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Anggota Tim</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Tim peneliti dan pengajar Lab IVSS</p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <!-- Grid Anggota Tim -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <?php if (!empty($teamMembers)): ?>
                    <?php foreach ($teamMembers as $member): ?>
                    <!-- Kartu Anggota Tim -->
                    <div class="group text-center">
                        <div class="relative mb-4 mx-auto w-32 h-32">
                            <!-- Efek Glow Latar Belakang -->
                            <div class="absolute inset-0 bg-blue-900 rounded-full blur-lg opacity-50 group-hover:opacity-75 transition-opacity"></div>
                            
                            <!-- Foto Profil dengan Bingkai -->
                            <div class="relative w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-xl">
                                <?php if (!empty($member['photo'])): ?>
                                    <img src="<?= htmlspecialchars($member['photo']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <!-- Avatar Default (Inisial Nama) -->
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($member['name']) ?>&background=1e40af&color=fff&size=256" alt="<?= htmlspecialchars($member['name']) ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Informasi Nama & Jabatan -->
                        <h3 class="font-bold text-gray-900 text-sm mb-1"><?= htmlspecialchars($member['name']) ?></h3>
                        <p class="text-xs <?= $member['position'] === 'Kepala Lab' ? 'text-blue-900' : 'text-gray-700' ?> font-semibold">
                            <?= htmlspecialchars($member['position']) ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Pesan Fallback -->
                    <div class="col-span-full text-center text-gray-500">Data anggota tim belum tersedia</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
