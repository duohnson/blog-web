<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require __DIR__ . '/src/database/connect_to_db.php';

$noticias = [];

try {
    $stmt = $pdo->query("SELECT * FROM noticias ORDER BY fecha DESC, creado_en DESC");
    $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($noticias as &$noticia) {
        $rutaImagen = __DIR__ . '/' . $noticia['imagen'];
        if (!file_exists($rutaImagen)) {
            $noticia['imagen'] = 'src/img/default.svg';
        }
    }
} catch (PDOException $e) {
    $error = 'Error al cargar noticias: ' . $e->getMessage();
}

$noticiasDestacadas = array_filter($noticias, function($n) { return $n['destacada'] == 1; });
$noticiasNormales = array_filter($noticias, function($n) { return $n['destacada'] == 0; });

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/static/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Noticias - Noticiero Informático</title>
</head>
<body>
    <header>
        <img src="src/static/img/breaking.png" alt="Breaking News" class="logo">
        <h1 class="el_titulo">Últimas novedades del mundo de la informática</h1>
    </header>
    <div class="botones">
        <a href="welcome.html" class="botones_menu">Inicio</a>
        <a href="articulos.php" class="botones_menu">Artículos</a>
        <a href="noticias.php" class="botones_menu">Noticias</a>
        <a href="contacto.html" class="botones_menu">Contacto</a>
    </div>
    <div class="agregar-noticia">
        <a href="subirnoticias.php" class="boton-agregar">+ Agregar Noticia</a>
    </div>
    <div>
        <hr>
    </div>
    <div class="titulos">
        <h2>Noticias destacadas</h2>
    </div>

    <?php if (!empty($noticiasDestacadas)): ?>
        <div class="contenedor-noticias-cnn">
            <?php 
            $primeraNoticia = true;
            foreach ($noticiasDestacadas as $index => $noticia): 
            ?>
                <div class="noticia-cnn <?php echo $primeraNoticia ? 'noticia-principal' : 'noticia-secundaria'; ?>">
                    <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="<?php echo htmlspecialchars($noticia['titulo']); ?>" class="noticia-imagen-cnn" onerror="this.src='src/img/default.svg'">
                    <div class="noticia-contenido-cnn">
                        <span class="noticia-categoria"><?php echo htmlspecialchars($noticia['categoria']); ?></span>
                        <h2 class="noticia-titulo-cnn"><?php echo htmlspecialchars($noticia['titulo']); ?></h2>
                        <p class="noticia-descripcion-cnn"><?php echo htmlspecialchars(substr($noticia['descripcion'], 0, 150)) . '...'; ?></p>
                        <span class="noticia-fecha"><?php echo date('d M Y', strtotime($noticia['fecha'])); ?></span>
                    </div>
                </div>
                <?php $primeraNoticia = false; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div>
        <hr>
    </div>

    <?php if (!empty($noticiasNormales)): ?>
        <div class="titulos">
            <h2>Últimas noticias</h2>
        </div>
        <div class="contenedor-noticias-grid">
            <?php foreach ($noticiasNormales as $noticia): ?>
                <article class="tarjeta-noticia">
                    <div class="imagen-contenedor">
                        <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="<?php echo htmlspecialchars($noticia['titulo']); ?>" class="imagen-noticia" onerror="this.src='src/img/default.svg'">
                        <span class="etiqueta-categoria"><?php echo htmlspecialchars($noticia['categoria']); ?></span>
                    </div>
                    <div class="contenido-tarjeta">
                        <h3 class="titulo-tarjeta"><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                        <p class="descripcion-tarjeta"><?php echo htmlspecialchars(substr($noticia['descripcion'], 0, 120)) . '...'; ?></p>
                        <div class="pie-tarjeta">
                            <span class="fecha-tarjeta"><?php echo date('d M Y', strtotime($noticia['fecha'])); ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($noticias)): ?>
        <div class="sin-noticias">
            <p>No hay noticias disponibles. <a href="subirnoticias.php">Agrega una noticia</a></p>
        </div>
    <?php endif; ?>

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
