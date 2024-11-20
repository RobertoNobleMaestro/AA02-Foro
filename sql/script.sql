-- Tabla de usuarios
CREATE DATABASE bd_foro;
USE bd_foro;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    nombre_real VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL, 
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de preguntas
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    etiquetas VARCHAR(255), 
    usuario_id INT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de respuestas
CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT NOT NULL, 
    usuario_id INT NOT NULL,  
    contenido TEXT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Claves foráneas
ALTER TABLE preguntas
ADD CONSTRAINT fk_preguntas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE respuestas
ADD CONSTRAINT fk_respuestas_pregunta FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
ADD CONSTRAINT fk_respuestas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE;

-- Usuarios
INSERT INTO usuarios (nombre_usuario, nombre_real, email, contrasena) VALUES
('juan23', 'Juan Pérez', 'juan@example.com', 'contrasena1'),
('maria12', 'María López', 'maria@example.com', 'contrasena2'),
('carlos90', 'Carlos García', 'carlos@example.com', 'contrasena3'),
('ana34', 'Ana Sánchez', 'ana@example.com', 'contrasena4'),
('pedro56', 'Pedro Martínez', 'pedro@example.com', 'contrasena5');

-- Preguntas
INSERT INTO preguntas (titulo, descripcion, etiquetas, usuario_id) VALUES
('¿Cómo hacer un SELECT en MySQL?', 'Estoy aprendiendo MySQL y necesito ayuda para seleccionar datos.', 'MySQL,SQL', 1),
('¿Qué es una clave foránea?', 'No entiendo bien cómo funcionan las claves foráneas en una base de datos relacional.', 'SQL,Bases de datos', 2),
('Problemas con CSS en navegadores antiguos', 'Mi sitio no se ve bien en IE. ¿Qué puedo hacer?', 'CSS,HTML', 3),
('Uso de variables en PHP', '¿Cómo se declaran y usan variables en PHP?', 'PHP,Programación', 4),
('Errores comunes en JavaScript', '¿Cuáles son los errores más frecuentes al trabajar con JavaScript?', 'JavaScript,Errores', 5),
('Validación de formularios con JavaScript', '¿Cómo implementar validación en el lado del cliente?', 'JavaScript,HTML', 1),
('Buenas prácticas para estructuras de datos', '¿Qué prácticas recomiendan para manejar estructuras complejas?', 'Programación,Algoritmos', 2),
('¿Qué es AJAX y para qué se utiliza?', 'Estoy empezando con tecnologías web y quiero saber más sobre AJAX.', 'AJAX,JavaScript', 3),
('Problemas con subconsultas en SQL', 'Tengo problemas para entender cómo funcionan las subconsultas.', 'SQL,Bases de datos', 4),
('Diferencias entre INNER JOIN y OUTER JOIN', '¿Cuándo debería usar cada tipo de JOIN en SQL?', 'SQL,MySQL', 5);

-- Respuestas
INSERT INTO respuestas (pregunta_id, usuario_id, contenido) VALUES
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
