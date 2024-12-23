<?php   
session_start();
require_once('./conexion.php');         
if (isset($_POST['btn_login'])) {
    $nombre_usuario = htmlspecialchars($_POST['correo']);  
    $contrasena_ingresada = htmlspecialchars($_POST['contrasena']);
try {
    $sql = "SELECT * FROM tbl_usuarios WHERE nombre_usuario = :nombre_usuario OR email = :email";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->bindParam(':email', $nombre_usuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuario) {
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
        $_SESSION['id_usuario'] = $usuario['id_usuario'];

        if (password_verify($contrasena_ingresada, $usuario['contrasena'])) {
            header('Location:../index.php');
        } else {
            header('Location:../login.php?error=contra_incorrecta');
        }
    } else {
        header('Location:../login.php?error=usuario_no_encontrado');
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
} else {
    header('../login.php');
}
?>