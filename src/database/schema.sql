* Esquema para la creación de la DB

CREATE DATABASE IF NOT EXISTS blog_web;
USE blog_web;
CREATE TABLE articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255),
  descripcion TEXT
);

* Artículo de ejemplo
INSERT INTO articulos (titulo, descripcion, autor) VALUES ('Primer Articulo', 'Prueba de un articulo dinamico.', 'Admin');

* Fix para timestamp

Alter TABLE articulos
ADD creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

* Subir noticias a la DB

DROP TABLE IF EXISTS noticias;
CREATE TABLE noticias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT NOT NULL,
  imagen VARCHAR(255),
  categoria VARCHAR(100),
  destacada TINYINT(1) DEFAULT 0,
  fecha DATE DEFAULT CURDATE(),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE suscriptores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) UNIQUE,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

