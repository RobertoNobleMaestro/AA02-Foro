-- Tabla de tbl_usuarios
CREATE DATABASE bd_foro;
USE bd_foro;
CREATE TABLE tbl_usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    nombre_real VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    random VARCHAR(255) NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de tbl_etiquetas
CREATE TABLE tbl_etiquetas (
    id_etiqueta INT AUTO_INCREMENT PRIMARY KEY,
    nombre_etiqueta VARCHAR(255) NOT NULL,
    descripcion_etiqueta VARCHAR(255) NULL
);

-- Tabla de tbl_preguntas
CREATE TABLE tbl_preguntas (
    id_preguntas INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL, 
    usuario_id INT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tbl_preguntas_etiquetas (
    id_pregunta INT NOT NULL,
    id_etiqueta INT NOT NULL
);

-- Tabla de tbl_respuestas
CREATE TABLE tbl_respuestas (
    id_respuestas INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT NULL, 
    usuario_id INT NOT NULL,  
    contenido TEXT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Claves foráneas
ALTER TABLE tbl_preguntas_etiquetas
ADD CONSTRAINT fk_preguntas_etiquetas_pregunta FOREIGN KEY (id_pregunta) REFERENCES tbl_preguntas(id_preguntas);

ALTER TABLE tbl_preguntas_etiquetas
ADD CONSTRAINT fk_preguntas_etiquetas_etiqueta FOREIGN KEY (id_etiqueta) REFERENCES tbl_etiquetas(id_etiqueta);

ALTER TABLE tbl_respuestas
ADD CONSTRAINT fk_respuestas_pregunta FOREIGN KEY (pregunta_id) REFERENCES tbl_preguntas(id_preguntas);

ALTER TABLE tbl_respuestas
ADD CONSTRAINT fk_respuestas_usuario FOREIGN KEY (usuario_id) REFERENCES tbl_usuarios(id_usuario);

-- tbl_usuarios
INSERT INTO tbl_usuarios (nombre_usuario, nombre_real, email, contrasena, random) VALUES
('juan90', 'Juan Pérez', 'juan@example.com', 'contrasena7','2.png'),
('maria23', 'María García', 'maria@example.com', 'contrasena8','3.png'),
('pedro45', 'Pedro López', 'pedro@example.com', 'contrasena9','4.png'),
('ana56', 'Ana Rodríguez', 'ana@example.com', 'contrasena10','5.png'),
('carlos78', 'Carlos Hernández', 'carlos@example.com', 'contrasena11','6.png'),
('laura90', 'Laura Martínez', 'laura@example.com', 'contrasena12','7.png'),
('diego23', 'Diego Sánchez', 'diego@example.com', 'contrasena13','8.png'),
('sofia45', 'Sofía Gómez', 'sofia@example.com', 'contrasena14','9.png'),
('manuel56', 'Manuel González', 'manuel@example.com', 'contrasena15','10.png'),
('isabel78', 'Isabel Fernández', 'isabel@example.com', 'contrasena16','11.png'),
('rafael90', 'Rafael Díaz', 'rafael@example.com', 'contrasena17','12.png'),
('cristina23', 'Cristina Moreno', 'cristina@example.com', 'contrasena18','13.png'),
('alberto45', 'Alberto Álvarez', 'alberto@example.com', 'contrasena19','14.png'),
('beatriz56', 'Beatriz Castro', 'beatriz@example.com', 'contrasena20','15.png'),
('fernando78', 'Fernando Rubio', 'fernando@example.com', 'contrasena21','16.png');

-- tbl_etiquetas
INSERT INTO tbl_etiquetas (nombre_etiqueta, descripcion_etiqueta) VALUES
('SQL', 'Lenguaje de consulta de bases de datos'),
('CSS', 'Lenguaje de estilos para la web'),
('HTML', 'Lenguaje de marcado para la web'),
('PHP', 'Lenguaje de programación para la web'),
('JavaScript', 'Lenguaje de programación para la web'),
('Programación', 'Desarrollo de software'),
('AJAX', 'Tecnología para actualización de páginas web'),
('Errores', 'Problemas comunes en la programación');

-- tbl_preguntas
INSERT INTO tbl_preguntas (titulo, descripcion, usuario_id) VALUES
('¿Cómo hacer un SELECT en MySQL?', 'Estoy aprendiendo MySQL y necesito ayuda para seleccionar datos.', 1),
('¿Qué es una clave foránea?', 'No entiendo bien cómo funcionan las claves foráneas en una base de datos relacional.', 2),
('Problemas con CSS en navegadores antiguos', 'Mi sitio no se ve bien en IE. ¿Qué puedo hacer?', 3),
('Uso de variables en PHP', '¿Cómo se declaran y usan variables en PHP?', 4),
('Errores comunes en JavaScript', '¿Cuáles son los errores más frecuentes al trabajar con JavaScript?', 5),
('Validación de formularios con JavaScript', '¿Cómo implementar validación en el lado del cliente?', 1),
('Buenas prácticas para estructuras de datos', '¿Qué prácticas recomiendan para manejar estructuras complejas?', 2),
('¿Qué es AJAX y para qué se utiliza?', 'Estoy empezando con tecnologías web y quiero saber más sobre AJAX.', 3),
('Problemas con subconsultas en SQL', 'Tengo problemas para entender cómo funcionan las subconsultas.', 4),
('Diferencias entre INNER JOIN y OUTER JOIN', '¿Cuándo debería usar cada tipo de JOIN en SQL?', 5);

-- tbl_respuestas
INSERT INTO tbl_respuestas (pregunta_id, usuario_id, contenido) VALUES
(1, 2, 'Puedes usar SELECT * FROM tabla para seleccionar todos los datos.'),
(1, 3, 'Recomiendo especificar las columnas en lugar de usar * para mejor rendimiento.'),
(2, 4, 'Una clave foránea conecta una tabla con otra y asegura integridad referencial.'),
(3, 5, 'Intenta usar hacks específicos para IE o una librería como Modernizr.'),
(4, 1, 'Las variables en PHP se declaran con $. Por ejemplo: $variable = "valor".'),
(5, 2, 'Un error común es usar == en lugar de === en comparaciones.'),
(6, 3, 'Puedes usar el evento onsubmit para validar formularios antes de enviarlos.'),
(7, 4, 'Divide las estructuras complejas en componentes más pequeños para facilitar el manejo.'),
(8, 5, 'AJAX permite actualizar partes de la página sin recargarla.'),
(9, 1, 'Una subconsulta es una consulta dentro de otra consulta, como en SELECT WHERE IN.'),
(10, 2, 'INNER JOIN devuelve filas coincidentes en ambas tablas, mientras que OUTER JOIN incluye las no coincidentes.');

-- tbl_preguntas_etiquetas
INSERT INTO tbl_preguntas_etiquetas (id_pregunta, id_etiqueta) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 4),
(5, 5),
(6, 5),
(7, 6),
(8, 7),
(9, 1),
(10, 1);