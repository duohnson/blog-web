* Esquema para la creación de la DB

CREATE DATABASE IF NOT EXISTS blog_web;
USE blog_web;
CREATE TABLE articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255),
  descripcion TEXT
);

* Artículo de ejemplo
INSERT INTO articulos (titulo, descripcion) VALUES ('Primer Articulo', 'Prueba de un articulo dinamico.');
