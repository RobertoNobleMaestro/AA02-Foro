<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/icono.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css">
    <title>Stack Overflow</title>
</head>
<body>
    <!-- Encabezado -->
    <header class="barra-navegacion">
        <div>
            <img class="logo-imagen" src="./img/Logo_pagina.png" alt="logo">
        </div>
        <form method="POST" class="barra-busqueda">
            <input type="text" placeholder="Buscar..." name="barra_de_busqueda" value="<?php echo isset($_POST['barra_de_busqueda']) ? htmlspecialchars($_POST['barra_de_busqueda']) : ''; ?>">
            <button type="submit" name="btn_buscar">Buscar</button>
            <!-- Botón para borrar filtros -->
            <button type="submit" name="btn_borrar_filtros">Borrar Filtros</button>
        </form>
        <?php
        if (!isset($_SESSION['nombre_usuario'])) {
        echo'
        <div class="acciones-usuario">
            <button><a href="./login.php">Iniciar sesión</a></button>
            <button><a href="./registrar.php">Crear cuenta</a></button>
        </div>
        </header>';
        } else {
            echo '<div class="acciones-usuario">bienvenido ' . $_SESSION['nombre_usuario'] . ' <button><a href="./php/cerrar_session.php">Cerrar sesión</a></button></div>';
        }
        ?>
    </header>

    <!-- Contenido principal -->
    <main class="contenedor-principal">
        <!-- Barra lateral -->
        <aside class="barra-lateral">
            <ul>
                <li><button><a href="./index.php">Preguntas</a></button></li>
                <li><button><a href="./usuarios.php">Usuarios</a></button></li>
                <?php if(isset($_SESSION['nombre_usuario'])){ ?>
                    <li><form action="" method="post"><input type="submit" name="btn_crear_pregunta" value="Crear pregunta"></form></li>
                <?php } ?>
                <?php if(isset($_SESSION['nombre_usuario'])){ ?>
                    <li><input type="submit" value="Historial de preguntas"></li>
                <?php } ?>
            </ul>
        </aside>

        <!-- Sección de preguntas -->
        <section class="seccion-preguntas">
            <div class="lista-preguntas">
                <?php
                    require_once "./php/conexion.php";
                    
                    // Si el botón de "Borrar Filtros" es presionado, limpiamos el campo de búsqueda
                    if (isset($_POST['btn_borrar_filtros'])) {
                        unset($_POST['barra_de_busqueda']);
                    }
                    
                    // Consulta para obtener el número total de preguntas
                    $sql = "SELECT count(id_preguntas) FROM tbl_preguntas;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute();
                    $total = $stmt->fetchColumn();
                    
                    // Mostrar el conteo de preguntas basado en los filtros de búsqueda
                    if (isset($_POST['btn_buscar']) && !empty($_POST['barra_de_busqueda'])) {
                        $query = htmlspecialchars($_POST['barra_de_busqueda']);
                        // Consulta para obtener las preguntas que coincidan con los filtros
                        $sql = "SELECT 
                                    p.id_preguntas AS pregunta_id, 
                                    p.titulo, 
                                    p.descripcion, 
                                    p.etiquetas, 
                                    p.usuario_id, 
                                    p.fecha_publicacion, 
                                    u.nombre_usuario, 
                                    COUNT(r.id_respuestas) AS numero_respuestas 
                                FROM tbl_preguntas p
                                INNER JOIN tbl_usuarios u ON p.usuario_id = u.id_usuario
                                LEFT JOIN tbl_respuestas r ON r.pregunta_id = p.id_preguntas
                                WHERE 
                                    u.nombre_usuario LIKE :query OR 
                                    p.titulo LIKE :query OR 
                                    p.descripcion LIKE :query
                                GROUP BY p.id_preguntas
                                ORDER BY p.fecha_publicacion DESC";
                        $stmt = $conexion->prepare($sql);
                        $stmt->execute(['query' => '%' . $query . '%']);
                        $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Mostrar el número de resultados encontrados
                        $total = count($preguntas); 
                        echo "<h4>Resultados encontrados: " . $total . "</h4>";
                    } else {
                        echo "<h4>Número total de preguntas: " . $total . "</h4>";
                    }
                ?>
                <hr>

                <?php
                    if (isset($_POST['btn_buscar']) && !empty($_POST['barra_de_busqueda'])) {
                        try {
                            $query = htmlspecialchars($_POST['barra_de_busqueda']);
                            // Consulta para obtener las preguntas que coincidan con los filtros
                            $sql = "SELECT 
                                        p.id_preguntas AS pregunta_id, 
                                        p.titulo, 
                                        p.descripcion, 
                                        p.etiquetas, 
                                        p.usuario_id, 
                                        p.fecha_publicacion, 
                                        u.nombre_usuario, 
                                        COUNT(r.id_respuestas) AS numero_respuestas 
                                    FROM tbl_preguntas p
                                    INNER JOIN tbl_usuarios u ON p.usuario_id = u.id_usuario
                                    LEFT JOIN tbl_respuestas r ON r.pregunta_id = p.id_preguntas
                                    WHERE 
                                        u.nombre_usuario LIKE :query OR 
                                        p.titulo LIKE :query OR 
                                        p.descripcion LIKE :query
                                    GROUP BY p.id_preguntas
                                    ORDER BY p.fecha_publicacion DESC";
                            $stmt = $conexion->prepare($sql);
                            $stmt->execute(['query' => '%' . $query . '%']);
                            $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Verificar si hay preguntas
                            if (count($preguntas) > 0) {
                                foreach ($preguntas as $pregunta) {
                                    echo "<div class='elemento-pregunta'>";
                                    echo "<h3>" . htmlspecialchars($pregunta['titulo']) . "</h3>";
                                    echo "<p>Preguntado por: " . htmlspecialchars($pregunta['nombre_usuario']) . "</p>";
                                    echo "<p>Número de respuestas: " . $pregunta['numero_respuestas'] . "</p>";
                                    echo "<p>Fecha de publicación: " . htmlspecialchars($pregunta['fecha_publicacion']) . "</p>";
                                    echo "<form method='GET' action='index.php'>";
                                    echo "<input type='hidden' name='id' value='" . $pregunta['pregunta_id'] . "'>";
                                    echo "<button type='submit' name='desplegar_preguntas'>Ver Respuestas</button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>No se encontraron preguntas que coincidan con los filtros.</p>";
                            }
                        } catch (PDOException $e) {
                            echo "<p>Error al acceder a la base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
                        }
                    } else {
                        try {
                            // Si no se ha hecho una búsqueda, mostramos todas las preguntas
                            $sql = "SELECT 
                                        p.id_preguntas AS pregunta_id, 
                                        p.titulo, 
                                        p.descripcion, 
                                        p.etiquetas, 
                                        p.usuario_id, 
                                        p.fecha_publicacion, 
                                        u.nombre_usuario, 
                                        COUNT(r.id_respuestas) AS numero_respuestas 
                                    FROM tbl_preguntas p
                                    INNER JOIN tbl_usuarios u ON p.usuario_id = u.id_usuario
                                    LEFT JOIN tbl_respuestas r ON r.pregunta_id = p.id_preguntas
                                    GROUP BY p.id_preguntas
                                    ORDER BY p.fecha_publicacion DESC";
                            $stmt = $conexion->prepare($sql);
                            $stmt->execute();
                            $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Verificar si hay preguntas
                            if (count($preguntas) > 0) {
                                foreach ($preguntas as $pregunta) {
                                    echo "<div class='elemento-pregunta'>";
                                    echo "<h3>" . htmlspecialchars($pregunta['titulo']) . "</h3>";
                                    echo "<p>Preguntado por: " . htmlspecialchars($pregunta['nombre_usuario']) . "</p>";
                                    echo "<p>Número de respuestas: " . $pregunta['numero_respuestas'] . "</p>";
                                    echo "<p>Fecha de publicación: " . htmlspecialchars($pregunta['fecha_publicacion']) . "</p>";
                                    echo "<form method='GET' action='index.php'>";
                                    echo "<input type='hidden' name='id' value='" . $pregunta['pregunta_id'] . "'>";
                                    echo "<button type='submit' name='desplegar_preguntas'>Ver Respuestas</button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>No se encontraron preguntas.</p>";
                            }
                        } catch (PDOException $e) {
                            echo "<p>Error al acceder a la base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
                        }
                    }
                ?>
            </div>
        </section>
        <!-- Detalles de la pregunta -->
        <section class="detalles-pregunta">
            <h2>Título de la pregunta</h2>
            <p>Aquí aparecerán todos los detalles de la pregunta seleccionada.</p>
            <div class="respuestas">
                <div class="elemento-respuesta">
                    <h3>Respuestas</h3>
                    <p>Este es un ejemplo de una respuesta.</p>
                    <span>Respondido por <strong>UsuarioExperto</strong></span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>