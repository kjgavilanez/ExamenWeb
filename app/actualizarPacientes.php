<?php
// Set content type to JSON
header('Content-Type: application/json');

require_once '../conexion/db.php';
// Siempre va a recibir datos por json
$request = json_decode(file_get_contents('php://input'), true);

$id = $request['id'];
$nombre = $request['nombre'];
$correo = $request['correo'];
$telefono = $request['telefono'];
$fecha_nacimiento = $request['fecha_nacimiento'];

//prepara mi query
$consulta = "UPDATE pacientes SET nombre = :nombre, correo = :correo, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento WHERE id = :id";

// ejecutamos la consulta
try {
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

    // ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Paciente actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el paciente']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>