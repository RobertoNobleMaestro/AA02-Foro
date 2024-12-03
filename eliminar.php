<?php
    session_start();

    require_once './php/conexion.php';

    if (isset($_SESSION['id_usuario'])){
        $id_usuario = $_SESSION['id_usuario'];
        $id_pregunta = $_GET['id'];

        try {
            // Eliminar respuestas relacionadas
            $stmt = $conexion->prepare("DELETE FROM tbl_respuestas WHERE pregunta_id = :id_pregunta");
            $stmt->bindParam(':id_pregunta', $id_pregunta);
            $stmt->execute();

            // Eliminar la pregunta
            $stmt = $conexion->prepare("DELETE FROM tbl_preguntas WHERE id_preguntas = :id_pregunta");
            $stmt->bindParam(':id_pregunta', $id_pregunta);
            $stmt->execute();

            header('Location: ./historial.php');
            exit;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'Error: No se ha iniciado sesión';
    }
?>