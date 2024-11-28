<?php
require_once './php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $pregunta_id = $_POST['pregunta_id'] ?? null;
    $etiquetas = $_POST['etiquetas'] ?? []; // Un array con los IDs de las etiquetas seleccionadas

    // Verificar que se haya seleccionado una pregunta y al menos una etiqueta
    if (!$pregunta_id || empty($etiquetas)) {
        echo "<p style='color:red;'>Debe seleccionar una pregunta y al menos una etiqueta.</p>";
    } else {
        try {
            // Iniciar una transacción para asegurar la integridad de los datos
            $conexion->beginTransaction();

            // Insertar nuevas etiquetas seleccionadas sin eliminar las existentes
            $insertQuery = "INSERT INTO tbl_preguntas_etiquetas (id_pregunta, id_etiqueta) 
                            SELECT :pregunta_id, :etiqueta_id 
                            WHERE NOT EXISTS (SELECT 1 FROM tbl_preguntas_etiquetas 
                                               WHERE id_pregunta = :pregunta_id AND id_etiqueta = :etiqueta_id)";
            $stmtInsert = $conexion->prepare($insertQuery);

            foreach ($etiquetas as $etiqueta_id) {
                // Asegurarse de que no se dupliquen las etiquetas
                $stmtInsert->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
                $stmtInsert->bindParam(':etiqueta_id', $etiqueta_id, PDO::PARAM_INT);
                $stmtInsert->execute();
            }

            // Confirmar la transacción
            $conexion->commit();
            echo "<p style='color:green;'>Etiquetas asignadas correctamente a la pregunta.</p>";
        } catch (Exception $e) {
            // Si ocurre algún error, revertir los cambios
            $conexion->rollBack();
            echo "<p style='color:red;'>Error al asignar etiquetas: " . $e->getMessage() . "</p>";
        }
    }
}

// Cargar preguntas y etiquetas desde la base de datos
try {
    $preguntasQuery = "SELECT id_preguntas, titulo FROM tbl_preguntas";
    $preguntasStmt = $conexion->query($preguntasQuery);
    $preguntas = $preguntasStmt->fetchAll(PDO::FETCH_ASSOC);

    $etiquetasQuery = "SELECT id_etiqueta, nombre_etiqueta FROM tbl_etiquetas";
    $etiquetasStmt = $conexion->query($etiquetasQuery);
    $etiquetas = $etiquetasStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p style='color:red;'>Error al cargar preguntas o etiquetas: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Etiquetas</title>
</head>
<body>
    <h1>Asignar Etiquetas a Preguntas</h1>
    <form action="" method="POST">
        <label for="pregunta_id">Selecciona una pregunta:</label>
        <select name="pregunta_id" required>
            <option value="">-- Selecciona una pregunta --</option>
            <?php foreach ($preguntas as $pregunta): ?>
                <option value="<?= htmlspecialchars($pregunta['id_preguntas']) ?>">
                    <?= htmlspecialchars($pregunta['titulo']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="etiquetas">Selecciona etiquetas:</label><br><br>
        <?php foreach ($etiquetas as $etiqueta): ?>
            <input type="checkbox" name="etiquetas[]" value="<?= htmlspecialchars($etiqueta['id_etiqueta']) ?>" id="etiqueta_<?= htmlspecialchars($etiqueta['id_etiqueta']) ?>">
            <label for="etiqueta_<?= htmlspecialchars($etiqueta['id_etiqueta']) ?>"><?= htmlspecialchars($etiqueta['nombre_etiqueta']) ?></label><br>
        <?php endforeach; ?>
        <br><br>
        <button type="submit">Asignar etiquetas</button>
    </form>

    <h2>Preguntas con Etiquetas</h2>
    <?php
    // Mostrar preguntas con sus etiquetas asignadas
    try {
        $sql2 = "
            SELECT p.titulo, p.descripcion, e.nombre_etiqueta
            FROM tbl_preguntas_etiquetas tpe
            INNER JOIN tbl_preguntas p ON tpe.id_pregunta = p.id_preguntas
            INNER JOIN tbl_etiquetas e ON tpe.id_etiqueta = e.id_etiqueta
            ORDER BY p.titulo, e.nombre_etiqueta
        ";
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->execute();
        $preguntasEtiquetas = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if (count($preguntasEtiquetas) === 0) {
            echo "<p>No hay etiquetas asignadas.</p>";
        } else {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<thead>
                    <tr>
                        <th>Título Pregunta</th>
                        <th>Descripción</th>
                        <th>Etiqueta</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            foreach ($preguntasEtiquetas as $pe) {
                echo "<tr>
                        <td>" . htmlspecialchars($pe['titulo']) . "</td>
                        <td>" . htmlspecialchars($pe['descripcion']) . "</td>
                        <td>" . htmlspecialchars($pe['nombre_etiqueta']) . "</td>
                      </tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error al cargar preguntas con etiquetas: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>