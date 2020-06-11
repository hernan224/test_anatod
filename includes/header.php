<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hernán Zubiri - Prueba Anatod</title>

    <script src="https://kit.fontawesome.com/1afd94d30f.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header class="main-header">
        <a href="/" class="main-logo">
            <h1 class="logo-text">Anatod Test</h1>
        </a>
        <nav class="section-nav">
            <ul class="horizontal-nav">
                <li class="nav-item <?=$nav_selected == 'clientes' ? 'selected' : ''?>"><a href="/">Clientes</a></li>
                <li class="nav-item <?=$nav_selected == 'nuevo_cliente' ? 'selected' : ''?>"><a href="/new_client.php">Nuevo cliente</a></li>
                <li class="nav-item <?=$nav_selected == 'provincias' ? 'selected' : ''?>"><a href="/provinces.php">Provincias</a></li>
            </ul>
            <button class="mobile-nav-toggle">
                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 512" class="svg-icon"><path fill="currentColor" d="M32 224c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zM0 136c0 17.7 14.3 32 32 32s32-14.3 32-32-14.3-32-32-32-32 14.3-32 32zm0 240c0 17.7 14.3 32 32 32s32-14.3 32-32-14.3-32-32-32-32 14.3-32 32z" ></path></svg>
            </button>
        </nav>
    </header>
    <main class="main-content">
