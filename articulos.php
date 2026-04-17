<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require __DIR__ . '/src/database/connect_to_db.php';

$traer_articulos = $pdo->query("SELECT * FROM articulos");
$articulos = $traer_articulos->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/static/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Artículos - Noticiero Informático</title>
</head>
<body>
    <header>
        <img src ="src/static/img/breaking.png" alt="Breaking News" class="logo">
        <h1 class="el_titulo">Últimas novedades del mundo de la informática</h1>
        <div class="redes-sociales">
            <a href="https://www.facebook.com/" target="_blank">
                <img src ="src/static/img/face.png" alt="Facebook" class="face">
            </a>
            <a href="https://twitter.com/" target="_blank">
                <img src ="src/static/img/x.png" alt="Twitter" class="x">
            </a>
            <a href="https://www.instagram.com/" target="_blank">
                <img src ="src/static/img/insta.png" alt="Instagram" class="insta">
            </a>
        </div>
    </header>
    <div class="botones">
        <a href="welcome.html" class="boton">Inicio</a>
        <a href="articulos.php" class="boton">Artículos</a>
        <a href="noticias.html" class="boton">Noticias</a>
        <a href="contacto.html" class="boton">Contacto</a>
    </div>

    <div class="titulos">
        <h2>Artículos destacados</h2>
    </div>
    <div class="articulos">
        <?php foreach ($articulos as $articulo): ?>
            <div class="articulo">
                <h3><?php echo htmlspecialchars($articulo['titulo']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($articulo['descripcion'])); ?></p>
            </div>
        <?php endforeach; ?>
</body>
</html>