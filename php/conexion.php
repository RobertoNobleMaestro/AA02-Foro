<?php
    $host = "localhost";
    $dbname = "bd_foro";
    $username = "root";
    $password = "1478";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }