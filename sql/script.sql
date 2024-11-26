-- Tabla de tbl_usuarios
CREATE DATABASE bd_foro;
USE bd_foro;
CREATE TABLE tbl_usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    nombre_real VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL, 
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de tbl_preguntas
CREATE TABLE tbl_preguntas (
    id_preguntas INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    etiquetas VARCHAR(255) NULL, 
    usuario_id INT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de tbl_respuestas
CREATE TABLE tbl_respuestas (
    id_respuestas INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT NOT NULL, 
    usuario_id INT NOT NULL,  
    contenido TEXT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Claves foráneas
ALTER TABLE tbl_preguntas
ADD CONSTRAINT fk_preguntas_usuario FOREIGN KEY (usuario_id) REFERENCES tbl_usuarios(id_usuario) ON DELETE CASCADE;

ALTER TABLE tbl_respuestas
ADD CONSTRAINT fk_respuestas_pregunta FOREIGN KEY (pregunta_id) REFERENCES tbl_preguntas(id_preguntas) ON DELETE CASCADE,
ADD CONSTRAINT fk_respuestas_usuario FOREIGN KEY (usuario_id) REFERENCES tbl_usuarios(id_usuario) ON DELETE CASCADE;

-- tbl_usuarios
INSERT INTO tbl_usuarios (nombre_usuario, nombre_real, email, contrasena) VALUES
('luis78', 'Luis Hernández', 'luis@example.com', 'contrasena6'),
('sofia91', 'Sofía Rodríguez', 'sofia@example.com', 'contrasena7'),
('daniel45', 'Daniel González', 'daniel@example.com', 'contrasena8'),
('isabel67', 'Isabel Díaz', 'isabel@example.com', 'contrasena9'),
('fernando89', 'Fernando Moreno', 'fernando@example.com', 'contrasena10'),
('carlos23', 'Carlos López', 'carlos@example.com', 'contrasena11'),
('maria56', 'María García', 'maria@example.com', 'contrasena12'),
('juan90', 'Juan Pérez', 'juan@example.com', 'contrasena13'),
('ana34', 'Ana Rodríguez', 'ana@example.com', 'contrasena14'),
('pedro67', 'Pedro Hernández', 'pedro@example.com', 'contrasena15'),
('laura89', 'Laura Díaz', 'laura@example.com', 'contrasena16'),
('manuel45', 'Manuel González', 'manuel@example.com', 'contrasena17'),
('cristina98', 'Cristina Moreno', 'cristina@example.com', 'contrasena18'),
('raul21', 'Raúl Sánchez', 'raul@example.com', 'contrasena19'),
('evelyn76', 'Evelyn Martínez', 'evelyn@example.com', 'contrasena20'),
('usuarioNuevo', 'Nombre del usuario nuevo', 'nuevo@example.com', 'contrasenaNueva'),
('usuario21', 'Nombre del usuario 21', 'usuario21@example.com', 'contrasena21'),
('usuario22', 'Nombre del usuario 22', 'usuario22@example.com', 'contrasena22');

-- tbl_preguntas
INSERT INTO tbl_preguntas (titulo, descripcion, etiquetas, usuario_id) VALUES
('¿Cómo hacer un SELECT en MySQL?', 'Eddstoy aprendiendo MySQL y necesito ayuda para seleccionar datos.', 'MySQL,SQL', 1),
('¿Qué es una clave foránea?', 'No entiendo bien cómo funcionan las claves foráneas en una base de datos relacional.', 'SQL,Bases de datos', 2),
('Problemas con CSS en navegadores antiguos', 'Mi sitio no se ve bien en IE. ¿Qué puedo hacer?', 'CSS,HTML', 3),
('Uso de variables en PHP', '¿Cómo se declaran y usan variables en PHP?', 'PHP,Programación', 4),
('Errores comunes en JavaScript', '¿Cuáles son los errores más frecuentes al trabajar con JavaScript?', 'JavaScript,Errores', 5),
('Validación de formularios con JavaScript', '¿Cómo implementar validación en el lado del cliente?', 'JavaScript,HTML', 1),
('Buenas prácticas para estructuras de datos', '¿Qué prácticas recomiendan para manejar estructuras complejas?', 'Programación,Algoritmos', 2),
('¿Qué es AJAX y para qué se utiliza?', 'Estoy empezando con tecnologías web y quiero saber más sobre AJAX.', 'AJAX,JavaScript', 3),
('Problemas con subconsultas en SQL', 'Tengo problemas para entender cómo funcionan las subconsultas.', 'SQL,Bases de datos', 4),
('Diferencias entre INNER JOIN y OUTER JOIN', '¿Cuándo debería usar cada tipo de JOIN en SQL?', 'SQL,MySQL', 5);

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