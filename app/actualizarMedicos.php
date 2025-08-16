<?php
// Set content type to JSON
header('Content-Type: application/json');

require_once '../conexion/db.php';
// Siempre va a recibir datos por json
$request = json_decode(file_get_contents('php://input'), true);

$id = $request['id'];
$nombre = $request['nombre'];
$especialidad = $request['especialidad'];
$tarifa_por_hora = $request['tarifa_por_hora'];

//prepara mi query
$consulta = "UPDATE medicos SET nombre = :nombre, especialidad = :especialidad, tarifa_por_hora = :tarifa_por_hora WHERE id = :id";

// ejecutamos la consulta
try {
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':especialidad', $especialidad);
    $stmt->bindParam(':tarifa_por_hora', $tarifa_por_hora);

    // ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Médico actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el médico']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>