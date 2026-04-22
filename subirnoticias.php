<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require __DIR__ . '/src/database/connect_to_db.php';

$exito = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = sanitizar($_POST['titulo'] ?? '');
    $descripcion = sanitizar($_POST['descripcion'] ?? '');
    $categoria = sanitizar($_POST['categoria'] ?? 'Tecnología');
    $imagen = $_FILES['imagen'] ?? null;
    $destacada = isset($_POST['destacada']) ? 1 : 0;

    if (!$titulo || !$descripcion) {
        $error = 'El título y la descripción son requeridos.';
    } else {
        $rutaImagen = 'src/img/default.jpg';
        
        if ($imagen && $imagen['size'] > 0 && $imagen['error'] === UPLOAD_ERR_OK) {
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
            
            if (!in_array($imagen['type'], $tiposPermitidos)) {
                $error = 'El formato de imagen no es válido. Usa: JPG, PNG, GIF, WEBP o AVIF.';
            } else {
                if (!is_dir(__DIR__ . '/src/img')) {
                    mkdir(__DIR__ . '/src/img', 0755, true);
                }
                
                $nombreArchivo = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $imagen['name']);
                $rutaDestino = __DIR__ . '/src/img/' . $nombreArchivo;
                
                if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                    $rutaImagen = 'src/img/' . $nombreArchivo;
                } else {
                    $error = 'Error al guardar la imagen. Verifica los permisos de la carpeta.';
                }
            }
        }

        if (empty($error)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO noticias (titulo, descripcion, imagen, categoria, destacada, fecha) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $titulo,
                    $descripcion,
                    $rutaImagen,
                    $categoria,
                    $destacada,
                    date('Y-m-d')
                ]);
                
                $exito = 'Noticia agregada exitosamente.';
            } catch (PDOException $e) {
                $error = 'Error al guardar la noticia: ' . $e->getMessage();
            }
        }
    }
}

function sanitizar($entrada) {
    return htmlspecialchars(trim($entrada), ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/static/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Subir Noticia - Noticiero Informático</title>
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
    <div>
        <hr>
    </div>
    <div class="titulos">
        <h2>Agregar Nueva Noticia</h2>
    </div>

    <?php if (!empty($exito)): ?>
        <div class="mensaje-exito">
            <?php echo $exito; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="mensaje-error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <div class="formulario-noticia">
        <form method="POST" enctype="multipart/form-data">
            <div class="campo-formulario">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required placeholder="Ingresa el título de la noticia">
            </div>

            <div class="campo-formulario">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required placeholder="Ingresa la descripción detallada"></textarea>
            </div>

            <div class="campo-formulario">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria">
                    <option value="Tecnología">Tecnología</option>
                    <option value="Semiconductores">Semiconductores</option>
                    <option value="Empresas">Empresas</option>
                    <option value="IA">Inteligencia Artificial</option>
                    <option value="Software">Software</option>
                    <option value="Hardware">Hardware</option>
                </select>
            </div>

            <div class="campo-formulario">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>

            <div class="campo-formulario">
                <label>
                    <input type="checkbox" name="destacada" value="1">
                    Marcar como noticia destacada
                </label>
            </div>

            <button type="submit" class="boton-enviar">Publicar Noticia</button>
        </form>
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
