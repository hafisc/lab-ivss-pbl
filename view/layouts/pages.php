<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVSS Lab - Laboratorium Intelligent Vision and Smart System</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="./assets/images/logo1.png">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Konfigurasi Kustom Tailwind untuk tema Lab IVSS -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ivss-primary': '#1e40af',   // Warna biru utama
                        'ivss-secondary': '#1d4ed8', // Warna biru sekunder
                        'ivss-dark': '#1e3a8a',      // Warna biru gelap
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'], // Font utama
                    }
                }
            }
        }
    </script>
    
    <!-- Font Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Gaya Tambahan Kustom -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        
        /* Animasi Kustom */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .animate-fade-in-up {
            animation-name: fadeInUp;
            animation-duration: 0.5s;
            animation-fill-mode: both;
        }
        .animate-fade-in {
            animation-name: fadeIn;
            animation-duration: 0.3s;
            animation-fill-mode: both;
        }
    </style>
</head>
<body class="bg-gray-50 h-full flex flex-col">
    
    <!-- Sertakan Navigasi Atas (Navbar) -->
    <?php include __DIR__ . '/../pages/partials/navbar.php'; ?>
    
    <!-- Konten Utama Halaman -->
    <!-- Menggunakan flex-grow agar footer tetap di bawah meskipun konten sedikit -->
    <main class="flex-grow">
        <?php 
        // Pemuatan Konten Dinamis
        // Memeriksa apakah variabel $pageView telah diatur oleh controller
        if (isset($pageView) && file_exists($pageView)) {
            include $pageView;
        } else {
            // Jika tidak ada permintaan halaman khusus, muat halaman beranda secara default
            include __DIR__ . '/../pages/home.php'; 
        }
        ?>
    </main>
    
    <!-- Sertakan Kaki Halaman (Footer) -->
    <?php include __DIR__ . '/../pages/partials/footer.php'; ?>
    
</body>
</html>