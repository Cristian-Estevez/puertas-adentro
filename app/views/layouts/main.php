<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title><?= $this->escape($title ?? 'Puertas Adentro') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700;900&family=Public+Sans:wght@400;500;700;900&family=Material+Symbols+Outlined&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="<?= $this->asset('css/main.css') ?>">
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>

</head>
<body style='font-family:"Public Sans","Noto Sans",sans-serif;' class="bg-white">
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
