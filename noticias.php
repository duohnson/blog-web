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
                    <svg class="face" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.312h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                </a>
                <a href="https://twitter.com/" target="_blank">
                    <svg class="x" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                </a>
                <a href="https://www.instagram.com/" target="_blank">
                    <svg class="insta" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
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
