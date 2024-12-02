<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inicio de Sesión</title>
    <link rel="stylesheet" href="css/login.css">
    <script defer src="js/login_validaciones.js"></script> <!-- Archivo JavaScript con los errores -->
</head>
<body>
    <div class="contenedor-login">
        <form class="formulario-login" method="POST" action="./php/login_validacion.php" id="formulario-login">
            <h2>Iniciar sesión</h2>
            <div class="form-item">
                <label for="correo">Correo electrónico o nombre de usuario <span>*</span></label>
                <input type="text" id="correo" name="correo" placeholder="Correo electrónico o nombre de usuario">
                <span id="correoError" class="mensaje-error"></span> <!-- Error para correo -->
            </div>
            <br><br>
            <div class="form-item">
                <label for="contrasena">Contraseña <span>*</span></label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña">
                <span id="contrasenaError" class="mensaje-error"></span> <!-- Error para contraseña -->
            </div>
            <br><br>
            <div class="form-item">
                <a href="./registrar.php" class="enlace-registrar">¿Es tu primera vez en StackOverflow? Regístrate</a>
            </div>
            <br><br>
            <button type="submit" class="boton-iniciar" name="btn_login">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>
