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
        
        <!-- Dashboard -->
        <a href="index.php?page=member" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </div>
        </a>
        
        <!-- Upload Dokumen -->
        <a href="index.php?page=member-upload" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-upload' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <span>Upload Dokumen</span>
            </div>
        </a>
        
        <!-- Absensi -->
        <a href="index.php?page=member-attendance" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-attendance' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <span>Absensi Saya</span>
            </div>
        </a>
        
        <!-- Divider -->
        <div class="my-2 border-t border-slate-200"></div>
        
        <!-- Profile -->
        <a href="index.php?page=member-profile" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-profile' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profil Saya</span>
            </div>
        </a>
        
        <!-- Edit Profil -->
        <a href="index.php?page=member-profile-edit" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-profile-edit' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Edit Profil</span>
            </div>
        </a>
        
        <!-- Ubah Password -->
        <a href="index.php?page=member-change-password" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'member-change-password' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
            <span>Ubah Password</span>
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
