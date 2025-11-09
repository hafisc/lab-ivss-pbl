<!-- Mobile Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 w-60 h-screen bg-white border-r border-slate-200 flex flex-col z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    
    <!-- Logo & Title -->
    <div class="p-4 border-b border-slate-200">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center overflow-hidden">
                <img src="assets/images/logo1.png" alt="IVSS Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <h2 class="font-bold text-slate-800">IVSS Member</h2>
                <span class="text-xs text-slate-500">Portal Lab</span>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
        <?php $currentPage = $_GET['page'] ?? 'member'; ?>
        
        <!-- Dashboard Member -->
        <a href="index.php?page=member" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </div>
        </a>
        
        <!-- Riset Saya -->
        <a href="index.php?page=member-research" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-research' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span>Riset Saya</span>
            </div>
        </a>
        
        <!-- Publikasi Saya -->
        <a href="index.php?page=member-publications" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-publications' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Publikasi Saya</span>
            </div>
        </a>
        
       
        
        <!-- Dokumentasi / Berita Lab -->
        <a href="index.php?page=member-news" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-news' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <span>Berita & Event</span>
            </div>
        </a>

         <!-- Profil -->
        <a href="index.php?page=member-profile" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-profile' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profil</span>
            </div>
        </a>
        
    </nav>

    <!-- Logout Button -->
    <div class="p-3 border-t border-slate-200">
        <a href="index.php?page=logout" class="block px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 transition-colors">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Logout</span>
            </div>
        </a>
    </div>
    
</aside>

<!-- Sidebar Toggle Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    // Toggle sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden', !overlay.classList.contains('hidden'));
    }
    
    // Open sidebar when toggle button clicked
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }
    
    // Close sidebar when overlay clicked
    overlay.addEventListener('click', toggleSidebar);
    
    // Close sidebar when clicking menu item on mobile
    const menuLinks = sidebar.querySelectorAll('a');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Only auto-close on mobile
            if (window.innerWidth < 1024) {
                toggleSidebar();
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            // Desktop: ensure sidebar is visible and overlay hidden
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
});
</script>
