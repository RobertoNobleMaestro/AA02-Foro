<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/icono.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css">
    <title>Usuarios</title>
</head>
<body>
    <?php

        require_once "./php/conexion.php";

        $sql = "SELECT * FROM tbl_usuarios;";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($usuarios) > 0) {
            echo "<table class='tabla-usuario'>";
                echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Nombre de usuario</th>";
                    echo "<th>Nombre real</th>";
                    echo "<th>Email</th>";
                    echo "<th>Contraseña</th>";
                    echo "<th>Fecha de registro</th>";
                echo "</tr>";
                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                        echo "<td>" . $usuario['id'] . "</td>";
                        echo "<td>" . $usuario['nombre_usuario'] . "</td>";
                        echo "<td>" . $usuario['nombre_real'] . "</td>";
                        echo "<td>" . $usuario['email'] . "</td>";
                        echo "<td>" . $usuario['contrasena'] . "</td>";
                        echo "<td>" . $usuario['fecha_registro'] . "</td>";
                    echo "</tr>";
                }
            echo "</table>";
        }else {
            echo "No hay usuarios en la base de datos.";
        }
    ?>
</body>
</html>
