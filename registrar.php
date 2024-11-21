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
    <form class="formulario-login" action="./php/login_validacion.php" method="POST" id="formulario">
        <h2>Crear usuario</h2>

        <label for="nombre_usuario">Nombre de usuario *</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre de usuario">
        <span class="mensaje-error" id="error-nombre-usuario"></span>

        <label for="nombre_real">Nombre y Apelidos *</label>
        <input type="text" id="nombre_real" name="nombre_real" placeholder="Nombre y Apellidos">
        <span class="mensaje-error" id="error-nombre-real"></span>

        <label for="email">Correo electrónico *</label>
        <input type="text" id="email" name="email" placeholder="Correo electrónico">
        <span class="mensaje-error" id="error-correo"></span>

        <label for="contrasena">Contraseña *</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña">
        <span class="mensaje-error" id="error-contrasena"></span>

        <label for="repetir">Repetir Contraseña *</label>
        <input type="password" id="repetir" name="repetir" placeholder="Repetir Contraseña">
        <span class="mensaje-error" id="error-repetir"></span>

        <button type="submit" class="boton-iniciar">Registrar</button>
        <br><br>
        <a href="./login.php" class="enlace-registrar">Iniciar sesión</a>
    </form>
</div>

</body>
</html>