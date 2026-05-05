# Noticias web

Proyecto de blog simple en PHP con gestión de noticias y formulario de contacto, se desarrollo en php, html y css puro, para mantenerlo sencillo y fácil de entender. El sistema permite a los usuarios suscribirse a un boletín, enviar mensajes a través de un formulario de contacto y gestionar noticias mediante una interfaz administrativa. La base de datos MySQL se utiliza para almacenar artículos, suscriptores y mensajes de contacto.

## Descripción

Sistema dinámico de noticias con formulario de contacto (SMTP de Gmail) y base de datos MySQL.

## Requisitos

- PHP 7.4+
- MySQL 5.7+
- Composer

## Instalación

1. Descargar el proyecto
2. Ejecutar `composer install`
3. Configurar variables en `.env`
4. Importar `src/database/schema.sql` en MySQL

## Archivos Principales

- `index.php` - Página de inicio
- `articulos.php` - Listado de artículos
- `noticias.php` - Gestor de noticias
- `contacto.html` - Formulario de contacto
- `suscripcion.php` - Sistema de suscripción
- `src/database/` - Conexión y esquema de BD

## Nota

Proyecto educativo de práctica. No está optimizado para producción ni posee medidas de seguridad avanzadas.
