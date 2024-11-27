<?php
    session_start();
    require_once './php/conexion.php';
    date_default_timezone_set("Europe/Madrid");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_usuario'])) {
        try {
            $id_pregunta = $_POST['id'] ?? null;
            $titulo = $_POST['titulo'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;

            if ($id_pregunta && $titulo && $descripcion) {
                $sql = "UPDATE tbl_preguntas 
                        SET titulo = ?, descripcion = ?, fecha_publicacion = ? 
                        WHERE id_preguntas = ? AND usuario_id = ?";
                $stmt = $conexion->prepare($sql);

                $strDate = date('Y-m-d H:i:s');
                $stmt->bindParam(1, $titulo);
                $stmt->bindParam(2, $descripcion);
                $stmt->bindParam(3, $strDate);
                $stmt->bindParam(4, $id_pregunta);
                $stmt->bindParam(5, $_SESSION['id_usuario']);

                $stmt->execute();

                // Redirigir al historial con mensaje de éxito
                header('Location: ./historial.php?msg=updated');
                exit;
            } else {
                echo "Error: Faltan datos necesarios.";
            }
        } catch (PDOException $e) {
            echo 'Error al actualizar la pregunta: ' . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Acción no permitida.";
    }