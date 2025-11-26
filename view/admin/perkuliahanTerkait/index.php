<?php
// Admin view: Daftar Perkuliahan Terkait
if (session_status() === PHP_SESSION_NONE) session_start();

// Auth check
$userRole = $_SESSION['user']['role'] ?? ($_SESSION['role'] ?? '');
if ($userRole !== 'admin') {
    $_SESSION['error'] = 'Akses ditolak.';
    header('Location: index.php?page=admin');
    exit;
}

$dataPath = __DIR__ . '/../../../app/data/perkuliahan.json';

// Load existing data
$data = [
    'heading' => 'Perkuliahan Terkait',
    'subtitle' => 'Mata kuliah yang berkaitan dengan Lab IVSS',
    'items' => []
];

if (file_exists($dataPath)) {
    $json = file_get_contents($dataPath);
    $decoded = json_decode($json, true);
    if (is_array($decoded)) $data = array_replace_recursive($data, $decoded);
}

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $idx = intval($_POST['index'] ?? -1);
    if ($idx >= 0 && $idx < count($data['items'])) {
        array_splice($data['items'], $idx, 1);

        $dir = dirname($dataPath);
        if (!is_dir($dir)) @mkdir($dir, 0755, true);

        if (file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            $_SESSION['success'] = 'Item berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus item';
        }
    }
    header('Location: index.php?page=admin-perkuliahan-list');
    exit;
}

ob_start();
?>

<div class="max-w-6xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Perkuliahan Terkait</h1>
                <p class="text-gray-600 mt-1">Kelola daftar mata kuliah pada landing page</p>
            </div>
            <a href="index.php?page=admin-perkuliahan-edit" class="px-4 py-2 bg-blue-900 text-white rounded-lg font-medium hover:bg-blue-800 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Mata Kuliah
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p><?= htmlspecialchars($_SESSION['error']) ?></p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p><?= htmlspecialchars($_SESSION['success']) ?></p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Daftar Mata Kuliah -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-900 to-blue-800">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
                Daftar Mata Kuliah
            </h3>
            <p class="text-indigo-100 text-sm mt-1"><?= count($data['items']) ?> item tersimpan</p>
        </div>

        <?php if (empty($data['items'])): ?>
            <!-- Empty State -->
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada mata kuliah</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat item pertama</p>
                <div class="mt-6">
                    <a href="index.php?page=admin-perkuliahan-edit" class="inline-flex items-center gap-2 px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Item Pertama
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Table of Items -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data['items'] as $idx => $item): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?= $idx + 1 ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    <?= htmlspecialchars($item['title']) ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-md">
                                    <div class="line-clamp-2">
                                        <?= htmlspecialchars($item['description']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex justify-center gap-2">
                                        <!-- Edit Button -->
                                        <a href="index.php?page=admin-perkuliahan-edit&id=<?= $idx ?>" class="inline-flex items-center gap-1 px-2 py-1 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded transition-colors">
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form method="POST" action="index.php?page=admin-perkuliahan-list&action=delete" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                                            <input type="hidden" name="index" value="<?= $idx ?>">
                                            <button type="submit" class="inline-flex items-center gap-1 px-2 py-1 bg-red-500 text-white text-xs frotn-medium rounded hover:bg-red-600 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = "Perkuliahan Terkait - Admin";
include __DIR__ . "/../../layouts/admin.php";
?>