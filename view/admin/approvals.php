<?php
require_once __DIR__ . '/../../app/controllers/MemberController.php';

// Check auth (simplified for demo)
// In real app: if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['dosen', 'ketua_lab'])) die('Access denied');

$memberController = new MemberController();

// Handle actions
if (isset($_POST['action'])) {
    $id = $_POST['registration_id'];
    $role = $_POST['role']; // 'dosen' or 'ketua_lab'
    $notes = $_POST['notes'];
    
    if ($_POST['action'] === 'approve') {
        $memberController->approveRegistration($id, $role, $notes);
    } elseif ($_POST['action'] === 'reject') {
        $memberController->rejectRegistration($id, $role, $notes);
    }
}

// Get pending list based on logged in user
// For demo, we'll simulate user ID 3 (Dr. Budi)
$current_user_id = 3; 
$pending_list = $memberController->getPendingRegistrations($current_user_id);
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Persetujuan Pendaftaran Anggota</h1>

    <?php if (empty($pending_list)): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Icon info -->
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Tidak ada pendaftaran yang menunggu persetujuan Anda saat ini.
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="grid gap-6">
            <?php foreach ($pending_list as $reg): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($reg['nama']) ?></h3>
                            <p class="text-sm text-gray-500"><?= htmlspecialchars($reg['nim']) ?> | <?= htmlspecialchars($reg['email']) ?></p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Menunggu Review
                        </span>
                    </div>
                    
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-900">Judul Riset:</h4>
                        <p class="mt-1 text-sm text-gray-600"><?= htmlspecialchars($reg['research_title']) ?></p>
                    </div>
                    
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-900">Motivasi:</h4>
                        <p class="mt-1 text-sm text-gray-600 italic">"<?= htmlspecialchars($reg['motivation']) ?>"</p>
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-4">
                        <form method="POST" class="flex gap-3">
                            <input type="hidden" name="registration_id" value="<?= $reg['id'] ?>">
                            <input type="hidden" name="role" value="dosen"> <!-- Dynamic based on session -->
                            
                            <div class="flex-grow">
                                <input type="text" name="notes" placeholder="Catatan (opsional)" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            
                            <button type="submit" name="action" value="approve" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Setujui
                            </button>
                            
                            <button type="submit" name="action" value="reject" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Tolak
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
