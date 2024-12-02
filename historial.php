<?php
session_start();
require_once './php/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/icono.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/historial.css">
    <title>Historial de preguntas - Stack Overflow</title>
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
            echo '
            <div class="acciones-usuario">
                <button><a href="./login.php">Iniciar sesión</a></button>
                <button><a href="./registrar.php">Crear cuenta</a></button>
            </div>';
        } else {
            echo '<div class="acciones-usuario">Bienvenido ' . htmlspecialchars($_SESSION['nombre_usuario']) . '  
            <button><a href="./php/cerrar_session.php">Cerrar sesión</a></button></div>';
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
                <li><button><a href="./historial.php">Historial de preguntas</a></button></li>
            </ul>
        </aside>

        <!-- Sección de preguntas -->
        <section class="seccion-preguntas">
            <div class="lista-preguntas">
                <h2>Mis Preguntas</h2>
                <?php
                if (isset($_SESSION['id_usuario'])) {
                    $id_usuario = $_SESSION['id_usuario'];
                    $id_pregunta_editar = $_GET['editar'] ?? null; // Captura el ID de la pregunta a editar

                    try {
                        // Consulta de preguntas del usuario
                        $sql = "SELECT 
                                    p.id_preguntas AS pregunta_id, 
                                    p.titulo, 
                                    p.descripcion, 
                                    p.fecha_publicacion, 
                                    COUNT(r.id_respuestas) AS numero_respuestas 
                                FROM tbl_preguntas p
                                LEFT JOIN tbl_respuestas r ON r.pregunta_id = p.id_preguntas
                                WHERE p.usuario_id = :id_usuario
                                GROUP BY p.id_preguntas
                                ORDER BY p.fecha_publicacion DESC";
                        $stmt = $conexion->prepare($sql);
                        $stmt->execute(['id_usuario' => $id_usuario]);
                        $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Mostrar el conteo de preguntas encontradas
                        $total_preguntas = count($preguntas);
                        echo "<h4>Número de preguntas hechas por el usuario: " . $total_preguntas . "</h4>";
                        echo "<hr>";

                        if ($preguntas) {
                            foreach ($preguntas as $pregunta) {
                                echo "<div class='elemento-pregunta'>";
                                echo "<h3>" . htmlspecialchars($pregunta['titulo']) . "</h3>";
                                echo "<p><strong>Descripción:</strong> " . htmlspecialchars($pregunta['descripcion']) . "</p>";
                                echo "<p><strong>Fecha de publicación:</strong> " . htmlspecialchars($pregunta['fecha_publicacion']) . "</p>";
                                echo "<p><strong>Número de respuestas:</strong> " . $pregunta['numero_respuestas'] . "</p>";

                                // Mostrar formulario solo si se selecciona "Editar"
                                if ($id_pregunta_editar == $pregunta['pregunta_id']) {
                                    echo "<form method='POST' action='./editar.php'>";
                                        echo "<input type='hidden' name='id' value='" . $pregunta['pregunta_id'] . "'>";
                                        echo "<label for='titulo'>Editar título:</label>";
                                        echo "<input type='text' name='titulo' value='" . htmlspecialchars($pregunta['titulo']) . "' required><br><br>";
                                        echo "<label for='descripcion'>Editar descripción:</label><br>";
                                        echo "<textarea name='descripcion' required>" . htmlspecialchars($pregunta['descripcion']) . "</textarea><br><br>";
                                        echo "<button type='submit'>Guardar cambios</button>";
                                    echo "</form>";
                                } else {
                                    // Botones para editar o eliminar
                                    echo "<form method='GET' action=''>";
                                        echo "<input type='hidden' name='editar' value='" . $pregunta['pregunta_id'] . "'>";
                                        echo "<button type='submit' style='margin-right: 10px;'>Editar Pregunta</button>";
                                        echo "<input type='hidden' name='id' value='" . $pregunta['pregunta_id'] . "'>";
                                        echo "<button type='submit'><a href='./eliminar.php?id=$pregunta[pregunta_id]'>Eliminar pregunta</a></button>";
                                    echo "</form>";
                                }
                                echo "</div><hr>";
                            }
                        } else {
                            echo "<p>No has hecho ninguna pregunta todavía.</p>";
                        }
                    } catch (PDOException $e) {
                        echo "<p>Error al acceder a la base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                } else {
                    echo "<p>Debes iniciar sesión para ver tus preguntas.</p>";
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>