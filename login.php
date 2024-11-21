<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inicio de Sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="contenedor-login">
        <form class="formulario-login" method="POST" action="./php/login_validacion.php">
            <h2>Iniciar sesión</h2>
            <label for="correo">Correo electrónico o nombre de usuario <span>*</span></label>
            <input type="email" id="correo" name="correo" placeholder="Correo electrónico o nombre de usuario">
            
            <label for="contrasena">Contraseña <span>*</span></label>
            <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña">
            
            <a href="./registrar.php" class="enlace-registrar">¿Es tu primera vez en Reddit? Regístrate</a>
            
            <button type="submit" class="boton-iniciar">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>
