<?php
    require_once '../php/conexion.php';
    
    session_start();
    
    try {
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
            die("Error: No se ha iniciado sesión o el ID de usuario no es válido.");
        }
    
        // Validar y asignar datos del formulario
        $titulo = htmlspecialchars($_POST['titulo'] ?? '');
        $descripcion = htmlspecialchars($_POST['descripcion'] ?? '');
        $usuario_id = $_SESSION['id_usuario'];
    
        if (empty($titulo) || empty($descripcion)) {
            die("Error: Título y descripción son obligatorios.");
        }
    
        // Iniciar transacción
        $conexion->beginTransaction();
    
        // Insertar la pregunta en la base de datos
        $stmtPregunta = $conexion->prepare(
            "INSERT INTO tbl_preguntas (titulo, descripcion, usuario_id) 
             VALUES (:titulo, :descripcion, :usuario_id)"
        );
        $stmtPregunta->bindParam(':titulo', $titulo);
        $stmtPregunta->bindParam(':descripcion', $descripcion);
        $stmtPregunta->bindParam(':usuario_id', $usuario_id);
    
        if (!$stmtPregunta->execute()) {
            throw new Exception("Error al insertar la pregunta: " . implode(", ", $stmtPregunta->errorInfo()));
        }
    
        // // Obtener el ID de la pregunta recién insertada
        // $pregunta_id = $conexion->lastInsertId();
    
        // // Insertar una respuesta en blanco asociada a la pregunta
        // $contenido = ''; // Respuesta en blanco
        // $stmtRespuesta = $conexion->prepare(
        //     "INSERT INTO tbl_respuestas (pregunta_id, usuario_id, contenido) 
        //      VALUES (:pregunta_id, :usuario_id, :contenido)"
        // );
        // $stmtRespuesta->bindParam(':pregunta_id', $pregunta_id);
        // $stmtRespuesta->bindParam(':usuario_id', $usuario_id);
        // $stmtRespuesta->bindParam(':contenido', $contenido);
    
        // if (!$stmtRespuesta->execute()) {
        //     throw new Exception("Error al insertar la respuesta: " . implode(", ", $stmtRespuesta->errorInfo()));
        // }
    
        // Confirmar transacción
        $conexion->commit();
    
        // Redirigir al índice después de una operación exitosa
        header("Location: ../index.php");
        exit;
    
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        if ($conexion->inTransaction()) {
            $conexion->rollBack();
        }
        echo "Error: " . $e->getMessage();
        exit;
    }