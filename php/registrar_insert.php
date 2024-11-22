<?php
session_start();
$errores = "";
if (isset($_POST['nombre_usuario']) && !empty($_POST['nombre_usuario'])) {
    $nombre_usuario = htmlspecialchars($_POST['nombre_usuario']);
    if (strlen($nombre_usuario) < 3) {
        if (!$errores) {
            $errores .= "?nombre_usuarioCorto=true";
        } else {
            $errores .= "&nombre_usuarioCorto=true";
        }
    }
} else {
    if (!$errores) {
        $errores .= "?nombreVacio=true";
    } else {
        $errores .= "&nombreVacio=true";
    }
}
if (isset($_POST['nombre_real']) && !empty($_POST['nombre_real'])) {
    $nombre_real = htmlspecialchars($_POST['nombre_real']);
    if (strlen($nombre_real) < 3) {
        if (!$errores) {
            $errores .= "?nombre_realCorto=true";
        } else {
            $errores .= "&nombre_realCorto=true";
        }
    }
} else {
    if (!$errores) {
        $errores .= "?nombre_realVacio=true";
    } else {
        $errores .= "&nombre_realVacio=true";
    }
}

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = htmlspecialchars($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (!$errores) {
            $errores .= "?emailInvalido=true";
        } else {
            $errores .= "&emailInvalido=true";
        }
    }
} else {
    if (!$errores) {
        $errores .= "?emailVacio=true";
    } else {
        $errores .= "&emailVacio=true";
    }
}

if (isset($_POST['contrasena']) && !empty($_POST['contrasena'])) {
    $contra = htmlspecialchars($_POST['contrasena']);
    if (strlen($contra) < 6) {
        if (!$errores) {
            $errores .= "?contraCorta=true";
        } else {
            $errores .= "&contraCorta=true";
        }
    }
} else {
    if (!$errores) {
        $errores .= "?contraVacia=true";
    } else {
        $errores .= "&contraVacia=true";
    }
}

if (isset($_POST['repetir']) && !empty($_POST['repetir'])) {
    $contra_repetir = htmlspecialchars($_POST['repetir']);
    if ($contra !== $contra_repetir) {
        if (!$errores) {
            $errores .= "?contraNoCoinciden=true";
        } else {
            $errores .= "&contraNoCoinciden=true";
        }
    }
} else {
    if (!$errores) {
        $errores .= "?contra_repetirVacio=true";
    } else {
        $errores .= "&contra_repetirVacio=true";
    }
}

if ($errores) {
    header('Location: ../registrar.php' . $errores);
    exit();
} else {
    require_once('../php/conexion.php');
        try {
        $contra_encriptada = password_hash($contra, PASSWORD_BCRYPT);
        $sql = "INSERT INTO tbl_usuarios (nombre_usuario, nombre_real, email, contrasena) VALUES (?, ?, ?, ?);";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $nombre_usuario);
        $stmt->bindParam(2, $nombre_real);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $contra_encriptada);     
        $stmt->execute();
        header('location:../login.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}  
?>