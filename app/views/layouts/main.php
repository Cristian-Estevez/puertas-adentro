<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title><?= $this->escape($title ?? 'Puertas Adentro') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style type="text/tailwindcss">
        :root {
            --primary-blue:#0d47a1;
            --accent-yellow:#facc15;
        }
        body { font-family:'Public Sans',sans-serif; }
    </style>
</head>
<body class="bg-white">
    <!-- <header class="header">
        <div class="container">
            <h1><?= $this->escape($headerTitle ?? 'Puertas Adentro') ?></h1>
        </div>
    </header> -->
    
    <main class="main-content">
        <div class="container">
            <?= $content ?? '' ?>
        </div>
    </main>
    
    <!-- <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Puertas Adentro. Todos los derechos reservados.</p>
        </div>
    </footer> -->
</body>
</html>
