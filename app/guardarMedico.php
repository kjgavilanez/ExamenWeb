<?php
//conectar a base de datos con db.php
require_once '../conexion/db.php';

// recibir los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $especialidad = $_POST['especialidad'];
    $tarifa_por_hora= $_POST['tarifa_por_hora'];
    // imprimir los datos recibidos
    // ingresar los datos en nuestra base de datos
    $sql = "INSERT INTO medicos (nombre, especialidad, tarifa_por_hora) VALUES (:nombre, :especialidad, :tarifa_por_hora)";
    // enviar variables con bindParam para evitar inyecciones SQL
    // bindParam vincula una variable a un parámetro de la sentencia SQL
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':especialidad', $especialidad);
    $stmt->bindParam(':tarifa_por_hora', $tarifa_por_hora);

    // ejecutar la consulta
    if ($stmt->execute()) {
        // redirigir a la página de creación de médicos
        header("Location: ../index.html");
        
    } else {
        echo "Error al crear el médico.";
    }
}
?>