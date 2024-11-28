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
        <form method="POST" class="barra-busqueda botones-form">
        <input type="text" placeholder="Buscar..." name="barra_de_busqueda">
        <button type="submit" name="btn_buscar">Buscar</button>
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
                <?php if(isset($_SESSION['nombre_usuario'])){ ?>
                    <li>
                        <form action="index.php" method="post">
                            <button type="submit" name="btn_crear_pregunta">Crear pregunta</button>
                        </form>
                    </li>
                <?php }?>
                <?php if(isset($_SESSION['nombre_usuario'])){ ?>
                    <form>
                        <button type="submit" name="btn_historial_preguntas"><a href="./historial.php?id=<?php echo $_SESSION['id_usuario']; ?>">Historial de preguntas</a></button>
                    </form>
                <?php }?>
                <li>
                    <button><a href="./usuarios.php">Usuarios</a></button>
                </li>
                <li>
                    <button><a href="./etiquetas.php">Etiquetas</a></button>
                </li>
            </ul>
        </aside>

        <!-- Sección de preguntas -->
        <section class="seccion-preguntas">
            <div class="lista-preguntas">
                <?php if(isset($_POST['btn_crear_pregunta'])){ ?>
                    <div class="creacion">
                        <h2>Formulario creación preguntas</h2>
                        <form action="./php/creación_pregunta.php" method="post" style="padding: 1%;">
                            <label for="titulo">Título:</label>
                            <input type="text" id="titulo" name="titulo">
                            <br><br>
                            <label for="descripcion">Descripción:</label>
                            <br>
                            <textarea id="descripcion" name="descripcion"></textarea>
                            <br><br>
                            <button name="enviar_pregunta">Enviar pregunta</button>
                            <button><a href="./index.php">Eliminar pregunta</a></button>
                        </form>
                    </div>
                <?php } ?>
            </div>
            <div class="lista-preguntas">
                <h2>Preguntas</h2>
                <?php
                require_once "./php/conexion.php";

                try {
                    // Verificar si hay una búsqueda activa
                    $query = isset($_POST['btn_buscar']) && !empty($_POST['barra_de_busqueda']) ? '%' . htmlspecialchars($_POST['barra_de_busqueda']) . '%' : '%';

                    // Obtener el número total de preguntas basado en la búsqueda
                    $sql_count = "
                        SELECT COUNT(p.id_preguntas) 
                        FROM tbl_preguntas p
                        INNER JOIN tbl_usuarios u ON p.usuario_id = u.id_usuario
                        WHERE u.nombre_usuario LIKE :query OR p.titulo LIKE :query OR p.descripcion LIKE :query";
                    $stmt_count = $conexion->prepare($sql_count);
                    $stmt_count->execute(['query' => $query]);
                    $total = $stmt_count->fetchColumn();
                    echo "<h4>Número total de preguntas: $total</h4>";

                    // Obtener las preguntas basadas en la búsqueda
                    $sql = "
                        SELECT 
                            p.id_preguntas AS pregunta_id, 
                            p.titulo, 
                            p.descripcion,
                            p.usuario_id,
                            u.random, 
                            p.fecha_publicacion, 
                            u.nombre_usuario, 
                            COUNT(r.id_respuestas) AS numero_respuestas
                        FROM tbl_preguntas p
                        INNER JOIN tbl_usuarios u ON p.usuario_id = u.id_usuario
                        LEFT JOIN tbl_respuestas r ON r.pregunta_id = p.id_preguntas
                        WHERE u.nombre_usuario LIKE :query OR p.titulo LIKE :query OR p.descripcion LIKE :query
                        GROUP BY p.id_preguntas
                        ORDER BY p.fecha_publicacion DESC";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute(['query' => $query]);
                    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Mostrar las preguntas si existen
                    if (count($preguntas) > 0) {
                        foreach ($preguntas as $pregunta) {
                            echo "<div class='elemento-pregunta' id='id" . $pregunta['pregunta_id'] . "'>";
                            echo "<h3>" . htmlspecialchars($pregunta['titulo']) . "</h3>";
                            echo "<p>" . htmlspecialchars($pregunta['descripcion']) . "</p>";
                            echo "<p class='content-perfil'><img  class='foto-perfil' src='./img/" . htmlspecialchars($pregunta['random']) . "' alt='Foto de perfil'>" . htmlspecialchars($pregunta['nombre_usuario']) . "</p>";
                            echo "<p><strong>Fecha de publicación: </strong>" . htmlspecialchars($pregunta['fecha_publicacion']) . "</p>";
                            // Formularios para mostrar respuestas o responder
                            echo "<form class='botones-form' method='GET' action='#id" . $pregunta['pregunta_id'] . "'>";
                            echo "<input type='hidden' name='id' value='" . $pregunta['pregunta_id'] . "'>";
                            echo "<button type='submit' class='boton-comentarios' name='desplegar_preguntas' style='margin-right: 10px;'><img src='./img/comentarios.svg' style='width: 20px;'>"  . $pregunta['numero_respuestas'] . "</button>";
                            echo "<button type='submit' class='boton-comentarios' name='responder_preguntas' style='width: 110px;';'>Responder</button>";
                            echo "</form>";

                            // Mostrar respuestas si esta pregunta está seleccionada
                            if (isset($_GET['id']) && $_GET['id'] == $pregunta['pregunta_id'] && isset($_GET['desplegar_preguntas'])) {
                                $pregunta_id = htmlspecialchars($_GET['id']);
                                $sql_respuestas = "
                                    SELECT 
                                        r.id_respuestas, 
                                        r.contenido, 
                                        u.random,
                                        r.fecha_publicacion, 
                                        u.nombre_usuario AS autor
                                    FROM tbl_respuestas r
                                    INNER JOIN tbl_usuarios u ON r.usuario_id = u.id_usuario
                                    WHERE r.pregunta_id = :pregunta_id
                                    ORDER BY r.fecha_publicacion ASC";
                                $stmt_respuestas = $conexion->prepare($sql_respuestas);
                                $stmt_respuestas->execute(['pregunta_id' => $pregunta_id]);
                                $respuestas = $stmt_respuestas->fetchAll(PDO::FETCH_ASSOC);
                                echo "<br>";
                                echo "<div class='respuestas'>";
                                if (count($respuestas) > 0) {
                                    echo "<h3>Respuestas:</h3>";
                                    echo "<br>";
                                    echo "<br>";
                                    foreach ($respuestas as $respuesta) {
                                        echo "<div class='elemento-respuesta'>";
                                        echo "<p class='content-perfil'><img  class='foto-perfil' src='./img/" . htmlspecialchars($respuesta['random']) . "' alt='Foto de perfil'>" . htmlspecialchars($respuesta['autor']) . "</p>";
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
                        echo "<p>No hay preguntas que coincidan con la búsqueda.</p>";
                    }
                } catch (PDOException $e) {
                    // Manejo de errores
                    echo "<p>Error al acceder a la base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </div>

        </section>
        <!-- Detalles de la pregunta -->
        <?php
        if (isset($_GET['id']) && isset($_GET['responder_preguntas'])) {
            $pregunta_id = htmlspecialchars($_GET['id']);
            try {
                $sql_pregunta = "
                    SELECT titulo, descripcion 
                    FROM tbl_preguntas 
                    WHERE id_preguntas = :id_pregunta";
                $stmt_pregunta = $conexion->prepare($sql_pregunta);
                $stmt_pregunta->execute(['id_pregunta' => $pregunta_id]);
                $pregunta_seleccionada = $stmt_pregunta->fetch(PDO::FETCH_ASSOC);

                if ($pregunta_seleccionada) {
                    // Construir la sección con los datos de la pregunta seleccionada
                    echo '
                    <section class="detalles-pregunta">
                        <h2>' . htmlspecialchars($pregunta_seleccionada['titulo']) . '</h2>
                        <p>' . htmlspecialchars($pregunta_seleccionada['descripcion']) . '</p>
                        <div class="respuestas">
                            <div>
                                <form action="./php/respuesta.php" method="post">
                                    <label for="respuesta">Respuesta:</label><br>
                                    <textarea id="respuesta" name="respuesta"></textarea>
                                    <br><br>
                                    <input type="hidden" name="id_pregunta" value="' . $pregunta_id . '">
                                    <button type="submit" name="enviar_respuesta" style="margin-bottom:3%;">Enviar respuesta</button>
                                </form>
                            </div>
                        </div>
                    </section>
                    ';
                } else {
                    echo '<p>La pregunta seleccionada no existe.</p>';
                }
            } catch (PDOException $e) {
                echo '<p>Error al acceder a la base de datos: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
        }
        ?>
    </main>
</body>
</html>