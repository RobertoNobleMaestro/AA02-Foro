<?php
session_start();
require_once 'conexion.php';
if (isset($_POST['id_pregunta']) && isset($_POST['respuesta']) && isset($_SESSION['id_usuario'])) { 
    $id_pregunta = htmlspecialchars($_POST['id_pregunta']);
    $respuesta = htmlspecialchars($_POST['respuesta']);
    $id_usuario = htmlspecialchars($_SESSION['id_usuario']);
    try {
        $stmtRespuesta = $conexion->prepare(
            "INSERT INTO tbl_respuestas (pregunta_id, usuario_id, contenido) 
             VALUES (:pregunta_id, :usuario_id, :contenido)"
        );
        $stmtRespuesta->bindParam(':pregunta_id', $id_pregunta);
        $stmtRespuesta->bindParam(':usuario_id', $id_usuario);
        $stmtRespuesta->bindParam(':contenido', $respuesta);
        $stmtRespuesta->execute();
        header('Location:../index.php');
    } catch (PDOException $e) {
        // Manejo de errores
        echo "<p>Error al acceder a la base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>