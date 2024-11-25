<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="shortcut icon" href="./img/icono.png" type="image/x-icon">
    <script src="./js/validaciones.js" defer></script> <!-- Cambiado href por src y defer para cargar después -->
    <title>Registro</title>
</head>
<body>

    <div class="contenedor-login">
        <form class="formulario-login" action="./php/registrar_insert.php" method="POST" id="formulario">
            <h2>Crear usuario</h2>
            <div class="grid-form">
                <div class="form-item">
                    <label for="nombre_usuario">Nombre de usuario *</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre de usuario">
                    <span class="mensaje-error" id="error-nombre-usuario"></span>
                </div>
                <div class="form-item">
                    <label for="contrasena">Contraseña *</label>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña">
                    <span class="mensaje-error" id="error-contrasena"></span>
                </div>
                <div class="form-item">
                    <label for="nombre_real">Nombre y Apellidos *</label>
                    <input type="text" id="nombre_real" name="nombre_real" placeholder="Nombre y Apellidos">
                    <span class="mensaje-error" id="error-nombre-real"></span>
                </div>
                <div class="form-item">
                    <label for="repetir">Repetir Contraseña *</label>
                    <input type="password" id="repetir" name="repetir" placeholder="Repetir Contraseña">
                    <span class="mensaje-error" id="error-repetir"></span>
                </div>
                <div class="form-item">
                    <label for="email">Correo electrónico *</label>
                    <input type="text" id="email" name="email" placeholder="Correo electrónico">
                    <span class="mensaje-error" id="error-correo"></span>
                </div>
            </div>
            <button type="submit" class="boton-iniciar">Registrar</button>
            <br><br>
            <a href="./login.php" class="enlace-registrar">Iniciar sesión</a>
        </form>
    </div>


</body>
</html>