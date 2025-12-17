<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IVSS Lab - Laboratorium Intelligent Vision and Smart System</title>
    <link rel="icon" type="image/png" href="./assets/images/logo1.png">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Config untuk tema Lab IVSS -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ivss-primary': '#1e40af',
                        'ivss-secondary': '#1d4ed8',
                        'ivss-dark': '#1e3a8a',
                    }
                }
            }
        }
    </script>
    
    <!-- Font dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        .hero-gradient {
            background: #1e40af;
        }
    </style>
</head>
<body class="bg-gray-50 h-full flex flex-col">
    
    <?php 
    // Sertakan Navbar
    include __DIR__ . '/../pages/partials/navbar.php'; 
    ?>
    
    <!-- Konten Utama -->
    <main class="flex-grow">
        <?php 
        // Sertakan halaman home
        include __DIR__ . '/../pages/home.php'; 
        ?>
    </main>
    
    <?php 
    // Sertakan Footer
    include __DIR__ . '/../pages/partials/footer.php'; 
    ?>
    
</body>
</html>