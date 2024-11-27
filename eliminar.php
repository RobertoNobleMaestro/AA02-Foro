<?php
    session_start();

    require_once './php/conexion.php';

    if (isset($_SESSION['id_usuario'])){
        $id_usuario = $_SESSION['id_usuario'];
        $id_pregunta = $_GET['id'];
    }

    try {
        // Eliminar la pregunta
        $stmt = $conexion->prepare("DELETE FROM tbl_preguntas WHERE id_preguntas = :id_pregunta");
        $stmt->bindParam(':id_pregunta', $id_pregunta);
        $stmt->execute();

        // Eliminar respuestas relacionadas
        $stmt = $conexion->prepare("DELETE FROM tbl_respuestas WHERE usuario_id = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        header('Location: ./historial.php');
        exit;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }