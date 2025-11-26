<?php
// Admin editor for landing page section "Perkuliahan Terkait"
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

// Determine if editing an item or adding new
$editingId = isset($_GET['id']) ? intval($_GET['id']) : null;
$isEditing = $editingId !== null && isset($data['items'][$editingId]);
$currentItem = $isEditing ? $data['items'][$editingId] : ['title' => '', 'description' => ''];

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($title) || empty($description)) {
        $_SESSION['error'] = 'Judul dan deskripsi harus diisi';
    } else {
        $dir = dirname($dataPath);
        if (!is_dir($dir)) @mkdir($dir, 0755, true);

        if ($isEditing) {
            // Update existing item
            $data['items'][$editingId] = ['title' => $title, 'description' => $description];
            $msg = 'Item berhasil diupdate';
        } else {
            // Add new item
            $data['items'][] = ['title' => $title, 'description' => $description];
            $msg = 'Item berhasil ditambahkan';
        }

        if (file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            $_SESSION['success'] = $msg;
            header('Location: index.php?page=admin-perkuliahan-list');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal menyimpan data';
        }
    }
}

ob_start();
?>
<div class="max-w-2xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900"><?= $isEditing ? 'Edit' : 'Tambah' ?> Mata Kuliah</h1>
        <p class="text-gray-600 mt-1">
            <?= $isEditing ? 'Update informasi mata kuliah' : 'Tambahkan mata kuliah baru' ?> pada landing page
        </p>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Mata Kuliah <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="title"
                    value="<?= htmlspecialchars($currentItem['title']) ?>"
                    placeholder="Contoh: Machine Learning"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p class="text-gray-500 text-xs mt-1">Masukkan nama mata kuliah yang akan ditampilkan</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                <textarea
                    name="description"
                    placeholder="Jelaskan mata kuliah ini dan relevansinya dengan Lab IVSS..."
                    rows="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required><?= htmlspecialchars($currentItem['description']) ?></textarea>
                <p class="text-gray-500 text-xs mt-1">Tulis deskripsi yang menarik dan informatif</p>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 px-6 py-3 bg-blue-900 text-white rounded-lg font-medium hover:bg-blue-800 transition-colors inline-flex items-center justify-center gap-2">
                    Simpan Perubahan
                </button>

                <a
                    href="index.php?page=admin-perkuliahan-list"
                    class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors inline-flex items-center justify-center gap-2">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong><?= $isEditing ? 'Update' : 'Item baru' ?> akan otomatis ditampilkan di halaman landing setelah disimpan.</strong>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = ($isEditing ? 'Edit' : 'Tambah') . " Mata Kuliah - Admin";
include __DIR__ . "/../../layouts/admin.php";
?>