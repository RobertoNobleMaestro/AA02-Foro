<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>

<div class="contenedor-login">
    <form class="formulario-login" action="./php/login_validacion.php" method="POST">
        <h2>Iniciar sesión</h2>

        <label for="nombre_usuario">Nombre de usuario *</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Correo electrónico o nombre de usuario" >

        <label for="nombre_real">Nombre real *</label>
        <input type="text" id="nombre_real" name="nombre_real" placeholder="Nombre real" >

        <label for="email">Correo electrónico *</label>
        <input type="email" id="email" name="email" placeholder="Correo electrónico" >

        <label for="contrasena">Contraseña *</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" >

        <button type="submit" class="boton-iniciar">Registrar</button>
        <br><br>
        <a href="./login.php" class="enlace-registrar">Iniciar sesión</a>
    </form>
</div>

</body>
</html>
