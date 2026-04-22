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
<!-- innecesario si ya estan en el footer,
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
        -->
    </header>
    <div class="botones">
        <a href="welcome.html" class="botones_menu">Inicio</a>
        <a href="articulos.php" class="botones_menu">Artículos</a>
        <a href="noticias.php" class="botones_menu">Noticias</a>
        <a href="contacto.html" class="botones_menu">Contacto</a>
    </div>
    <div>
        <hr>
    </div>
    <div class="titulos">
        <h2>Artículos destacados</h2>
    </div>
    <div class="articulos">
        <?php foreach ($articulos as $articulo): ?>
            <div class="articulo">
                <a href="articulo.php?id=<?php echo $articulo['id']; ?>">
                <h3 class="art_titulo no_color"><?php echo htmlspecialchars($articulo['titulo']); ?></h3>
                </a>
                <h3 class="art_autor"><?php echo htmlspecialchars($articulo['autor']); ?></h3>
                <p class="art_descripcion"><?php echo nl2br(htmlspecialchars($articulo['descripcion'])); ?></p>
                <p class="art_creado_en">Creado el: <?php echo htmlspecialchars($articulo['creado_en']); ?></p>
                <p class="art_divisor">-----------------------------------------------------------------</p>
            </div>
        <?php endforeach; ?>
    </div>
    <div>
        <hr>
    </div>
    <footer>
        <div class="footer-izquierda">
            <p>2026 Noticiero Informático. Todos los derechos reservados. Developed by Daniel Uohnson</p>
            <p>Contacto: contacto@noticiasinformaticas.com</p>
        </div>
        <div class="footer-derecha cartas">
            <div class="redes-sociales-footer">
                <a href="https://www.facebook.com/" target="_blank">
                    <img src="src/static/img/face.png" alt="Facebook" class="face">
                </a>
                <a href="https://twitter.com/" target="_blank">
                    <img src="src/static/img/x.png" alt="Twitter" class="x">
                </a>
                <a href="https://www.instagram.com/" target="_blank">
                    <img src="src/static/img/insta.png" alt="Instagram" class="insta">
                </a>
            </div>
            <div class="suscribirse">
                <h3>Suscríbete a nuestro boletín</h3>
                <form action="suscripcion.php" method="post">
                    <input type="email" name="email" placeholder="Ingresa tu correo electrónico" required>
                    <button class="suscribirse-boton" type="submit">Suscribirse</button>
                </form>
            </div>
        </div>
    </footer>
</body>
</html>

