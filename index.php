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
        <div class="barra-busqueda">
            <input type="text" placeholder="Buscar...">
            <button>Buscar</button>
        </div>
        <?php
        if (!isset($_SESSION['nombre_usuario'])) {
        echo'
        <div class="acciones-usuario">
            <button><a href="./login.php">Iniciar sessión</a></button>
            <button><a href="./registrar.php">Crear cuenta</a></button>
        </div>
        </header>';
        } else {
            echo '<div class="acciones-usuario">bienvenido ' . $_SESSION['nombre_usuario']. '  ' . '<button><a href="./php/cerrar_session.php">cerrar session</a></button> </div>';
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
                            <input type="submit" name="btn_crear_pregunta" value="Crear pregunta">
                        </form>
                    </li>
                <?php }?>
                <?php if(isset($_SESSION['nombre_usuario'])){ ?>
                    <li>
                        <input type="submit" value="Historial de preguntas">
                    </li>
                <?php }?>
            </ul>
        </aside>

        <!-- Sección de preguntas -->
        <section class="seccion-preguntas">
            <div class="lista-preguntas">
                <?php if(isset($_POST['btn_crear_pregunta'])){ ?>
                    <h2>Formulario creación preguntas</h2>
                    <form action="./php/creación_pregunta.php" method="post">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" required>
                        <br><br>
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" required></textarea>
                        <br><br>
                        <button name="enviar_pregunta" type="submit">Enviar pregunta</button>
                        <button type="button" onclick="window.location.href='./index.php'">Cancelar</button>
                    </form>
                <?php } ?>
            </div>
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
                    
                    require_once "./php/conexion.php";

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
                        inner JOIN tbl_usuarios u ON p.usuario_id = u.id_usuario
                        inner JOIN tbl_respuestas r ON r.pregunta_id = p.id_preguntas
                        GROUP BY p.id_preguntas
                        ORDER BY p.fecha_publicacion DESC
                    ";

                    $stmt = $conexion->prepare($sql);
                    $stmt->execute();
                    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($preguntas) > 0) {
                        foreach ($preguntas as $pregunta) {
                            echo "<div class='elemento-pregunta'>";
                            echo "<h3>" . $pregunta['titulo'] . "</h3>";
                            echo "<p>Preguntado por: " . $pregunta['nombre_usuario'] . "</p>";
                            echo "<p>Número de respuestas: " . $pregunta['numero_respuestas'] . "</p>";
                            echo "<form method='POST' action='index.php?id=".$pregunta['pregunta_id'] ."'>";
                                echo "<button type='submit' name='desplegar_preguntas'>Texto del botón</button>";
                            echo "</form>";
                        }
                    } else {
                        echo "No hay preguntas en la base de datos.";
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
                    <?php
                        if (isset($_GET['id'])) {
                            $pregunta_id = $_GET['id']; 
                            echo "Mostrando detalles para la pregunta con ID: " . $pregunta_id;
                        }
                    ?>
                    <span>Respondido por <strong>UsuarioExperto</strong></span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>