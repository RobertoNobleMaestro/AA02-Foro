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
        <input type="text" placeholder="Buscar..." name="barra_de_busqueda">
        <button type="submit" name="btn_buscar">Buscar</button>
        </form>
        <?php
        if (!isset($_SESSION['nombre_usuario'])) {
        echo'
        <div class="acciones-usuario">
            <button><a href="./login.php">Iniciar sessión</a></button>
            <button><a href="./registrar.php">Crear cuenta</a></button>
        </div>
        </header>';
        } else {
            echo '<div class="acciones-usuario">bienvenido ' . $_SESSION['nombre_usuario']. '  ' . '<button><a href="./php/cerrar_session.php">Cerrar sesion</a></button> </div>';
        }
        ?>
    </header>
    <!-- Contenido principal -->
    <main class="contenedor-principal">
        <!-- Barra lateral -->
        <aside class="barra-lateral">
            <ul>
                
                <li>
                    <button><a href="./index.php">Preguntas</a></button>
                </li>
                <li>
                    <button><a href="./usuarios.php">Usuarios</a></button>
                </li>
                <?php if(isset($_SESSION['nombre_usuario'])){ ?>
                    <li>
                        <form action="" method="post">
                            <button type="submit" name="btn_crear_pregunta">Crear pregunta</button>
                        </form>
                    </li>
                <?php }?>
                <?php if(isset($_SESSION['nombre_usuario'])){ ?>
                    <form>
                        <button type="submit" name="btn_historial_preguntas"><a href="./historial.php">Historial de preguntas</a></button>
                    </form>
                <?php }?>
            </ul>
        </aside>

        <!-- Sección de preguntas -->
        <section class="seccion-preguntas">
            <div class="lista-preguntas">
                <h2>Preguntas</h2>
                <?php
                    require_once "./php/conexion.php";
                    $sql = "SELECT count(id_preguntas) FROM tbl_preguntas;";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute();
                    $total = $stmt->fetchColumn();
                    echo "<h4>Número total de preguntas: " . $total . "</h4>";
                ?>
                <hr>
                <?php
                    if (isset($_POST['btn_buscar']) && !empty($_POST['barra_de_busqueda'])) {
                        try {
                        require_once "./php/conexion.php";
                        $query = htmlspecialchars($_POST['barra_de_busqueda']);
                        // Consulta para obtener las preguntas y el conteo de respuestas
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
                    
                                // Formulario para mostrar respuestas de la pregunta
                                echo "<form method='GET' action='index.php'>";
                                echo "<input type='hidden' name='id' value='" . $pregunta['pregunta_id'] . "'>";
                                echo "<button type='submit' name='desplegar_preguntas'>Ver Respuestas</button>";
                                echo "</form>";
                    
                                // Mostrar respuestas si la pregunta actual coincide con el ID seleccionado
                                if (isset($_GET['id']) && $_GET['id'] == $pregunta['pregunta_id']) {
                                    $pregunta_id = $_GET['id'];
                    
                                    // Consultar las respuestas de la pregunta seleccionada
                                    $sql_respuestas = "SELECT 
                                                           r.id_respuestas,
                                                           r.contenido,
                                                           r.fecha_publicacion,
                                                           u.nombre_usuario AS autor
                                                       FROM 
                                                           tbl_respuestas r
                                                       INNER JOIN 
                                                           tbl_usuarios u ON r.usuario_id = u.id_usuario
                                                       WHERE 
                                                           r.pregunta_id = :pregunta_id
                                                       ORDER BY 
                                                           r.fecha_publicacion ASC";
                    
                                    $stmt_respuestas = $conexion->prepare($sql_respuestas);
                                    $stmt_respuestas->execute(['pregunta_id' => $pregunta_id]);
                                    $respuestas = $stmt_respuestas->fetchAll(PDO::FETCH_ASSOC);
                    
                                    // Mostrar las respuestas si existen
                                    echo "<div class='respuestas'>";
                                    if (count($respuestas) > 0) {
                                        echo "<h4>Respuestas:</h4>";
                                        foreach ($respuestas as $respuesta) {
                                            echo "<div class='elemento-respuesta'>";
                                            echo "<p><strong>Respondido por: </strong>" . htmlspecialchars($respuesta['autor']) . "</p>";
                                            echo "<hr>";
                                            echo "<p>" . htmlspecialchars($respuesta['contenido']) . "</p>";
                                            echo "<p><strong>Fecha de publicación: </strong>" . htmlspecialchars($respuesta['fecha_publicacion']) . "</p>";
                                            echo "</div>";
                                        }                                        
                                    } else {
                                        echo "<p>No hay respuestas para esta pregunta.</p>";
                                    }
                                    echo "</div>";
                                }
                    
                                echo "</div>";
                            }
                        } else {
                            echo "No hay preguntas en la base de datos.";
                        }
                    } catch (PDOException $e) {
                        // Manejo de errores
                        echo "<p>Error al acceder a la base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                } else {
                    try {
                        require_once "./php/conexion.php";
                    
                        // Consulta para obtener las preguntas y el conteo de respuestas
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
                                echo "<div class='elemento-pregunta' id='id" . $pregunta['pregunta_id'] . "'>";
                                echo "<h3>" . htmlspecialchars($pregunta['titulo']) . "</h3>";
                                echo "<p>Preguntado por: " . htmlspecialchars($pregunta['nombre_usuario']) . "</p>";
                                echo "<p>Número de respuestas: " . $pregunta['numero_respuestas'] . "</p>";
                                echo "<p>Fecha de publicación: " . htmlspecialchars($pregunta['fecha_publicacion']) . "</p>";
                                
                                
                                // Formulario para mostrar respuestas de la pregunta
                                echo "<form method='GET' action='#id" . $pregunta['pregunta_id'] . "'>";
                                echo "<input type='hidden' name='id' id='id" . $pregunta['pregunta_id'] . "' value='" . $pregunta['pregunta_id'] . "'>";
                                echo "<button type='submit' name='desplegar_preguntas'>Ver Respuestas</button>";
                                echo "</form>";
                                echo "</div>";
                                
                                // Mostrar respuestas si la pregunta actual coincide con el ID seleccionado
                                if (isset($_GET['id']) && $_GET['id'] == $pregunta['pregunta_id']) {
                                    $pregunta_id = $_GET['id'];
                    
                                    // Consultar las respuestas de la pregunta seleccionada
                                    $sql_respuestas = "SELECT 
                                                           r.id_respuestas,
                                                           r.contenido,
                                                           r.fecha_publicacion,
                                                           u.nombre_usuario AS autor
                                                       FROM 
                                                           tbl_respuestas r
                                                       INNER JOIN 
                                                           tbl_usuarios u ON r.usuario_id = u.id_usuario
                                                       WHERE 
                                                           r.pregunta_id = :pregunta_id
                                                       ORDER BY 
                                                           r.fecha_publicacion ASC";
                    
                                    $stmt_respuestas = $conexion->prepare($sql_respuestas);
                                    $stmt_respuestas->execute(['pregunta_id' => $pregunta_id]);
                                    $respuestas = $stmt_respuestas->fetchAll(PDO::FETCH_ASSOC);
                    
                                    // Mostrar las respuestas si existen
                                    echo "<div class='respuestas'>";
                                    if (count($respuestas) > 0) {
                                        echo "<h4>Respuestas:</h4>";
                                        foreach ($respuestas as $respuesta) {
                                            echo "<div class='elemento-respuesta'>";
                                            echo "<p><strong>Respondido por: </strong>" . htmlspecialchars($respuesta['autor']) . "</p>";
                                            echo "<p>" . htmlspecialchars($respuesta['contenido']) . "</p>";
                                            echo "<p><strong>Fecha de publicación: </strong>" . htmlspecialchars($respuesta['fecha_publicacion']) . "</p>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<p>No hay respuestas para esta pregunta.</p>";
                                    }
                                    echo "</div>";
                                }
                    
                                echo "</div>";
                            }
                        } else {
                            echo "No hay preguntas en la base de datos.";
                        }
                    } catch (PDOException $e) {
                        // Manejo de errores
                        echo "<p>Error al acceder a la base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                }
                ?>

            </div>
        </section>
    </main>
</body>
</html>