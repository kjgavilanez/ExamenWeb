<?php
//conectar a base de datos con db.php
require_once '../conexion/db.php';

// recibir los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    // imprimir los datos recibidos
    // ingresar los datos en nuestra base de datos
    $sql = "INSERT INTO pacientes (nombre, correo, telefono, fecha_nacimiento) VALUES (:nombre, :correo, :telefono, :fecha_nacimiento)";
    // enviar variables con bindParam para evitar inyecciones SQL
    // bindParam vincula una variable a un parámetro de la sentencia SQL
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

    // ejecutar la consulta
    if ($stmt->execute()) {
        // redirigir a la página de creación de usuario
        header("Location: ../index.html");
        
    } else {
        echo "Error al crear el usuario.";
    }
}
?>