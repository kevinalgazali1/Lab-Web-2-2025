<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Manajemen Proyek'; ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Raleway', 'sans-serif']
                    },
                    colors: {
                        'dark-bg': '#2d3250',
                        'dark-content': '#424769',
                        'dark-accent': '#676f9d',
                        'brand-orange': '#f9b17a',
                        'brand-white': '#ffffff'
                    }
                }
            }
        }
    </script>
    
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="bg-dark-bg text-brand-white font-sans min-h-screen">