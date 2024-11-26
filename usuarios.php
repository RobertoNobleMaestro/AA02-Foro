<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/icono.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/usuarios.css">
    <title>Usuarios - Stack Overflow</title>
</head>
<body>
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
    <div class="usuarios-container">
        <?php
            require_once "./php/conexion.php";

            // Configuración de paginación
            $registrosPorPagina = 9; // Número de usuarios por página
            $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $offset = ($paginaActual - 1) * $registrosPorPagina;

            // Consulta para obtener usuarios con paginación
            $sql = "SELECT * FROM tbl_usuarios LIMIT :offset, :registrosPorPagina";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':registrosPorPagina', $registrosPorPagina, PDO::PARAM_INT);
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Consulta para obtener el total de usuarios
            $sqlTotal = "SELECT COUNT(*) AS total FROM tbl_usuarios";
            $stmtTotal = $conexion->prepare($sqlTotal);
            $stmtTotal->execute();
            $totalRows = $stmtTotal->fetchColumn();
            $totalPaginas = ceil($totalRows / $registrosPorPagina);

            // Mostrar usuarios
            if (count($usuarios) > 0) {
                foreach ($usuarios as $usuario) {
                    echo "<div class='usuario-card'>";
                        echo "<div class='usuario-header'>";
                            echo "<h3>" . htmlspecialchars($usuario['nombre_usuario']) . "</h3>";
                        echo "</div>";
                        echo "<div class='usuario-body'>";
                            echo "<p><strong>Nombre real:</strong> " . htmlspecialchars($usuario['nombre_real']) . "</p>";
                            echo "<p><strong>Email:</strong> " . htmlspecialchars($usuario['email']) . "</p>";
                        echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay usuarios en la base de datos.</p>";
            }
        ?>
    </div>

    <!-- Paginación -->
    <div class="pagination">
        <?php if ($paginaActual > 1): ?>
            <a href="?pagina=<?= $paginaActual - 1 ?>" class="btn">Anterior</a>
        <?php endif; ?>

        <span>Página <?= $paginaActual ?> de <?= $totalPaginas ?></span>

        <?php if ($paginaActual < $totalPaginas): ?>
            <a href="?pagina=<?= $paginaActual + 1 ?>" class="btn">Siguiente</a>
        <?php endif; ?>
    </div>
</body>
</html>