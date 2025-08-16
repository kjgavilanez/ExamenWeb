<?php
// Set content type to JSON
header('Content-Type: application/json');

require_once '../conexion/db.php';
// Siempre va a recibir datos por json
$request = json_decode(file_get_contents('php://input'), true);

$id = $request['id'];
$paciente_id = $request['paciente_id'];
$medico_id = $request['medico_id'];
$fecha = $request['fecha'];
$hora_inicio = $request['hora_inicio'];
$hora_fin = $request['hora_fin'];
$duracion = $request['duracion'];
$costo_total = $request['costo_total'];
$estado = $request['estado'];

//prepara mi query
$consulta = "UPDATE citas SET paciente_id = :paciente_id, medico_id = :medico_id, fecha = :fecha, hora_inicio = :hora_inicio, hora_fin = :hora_fin, duracion = :duracion, costo_total = :costo_total, estado = :estado WHERE id = :id";

// ejecutamos la consulta
try {
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':paciente_id', $paciente_id);
    $stmt->bindParam(':medico_id', $medico_id);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora_inicio', $hora_inicio);
    $stmt->bindParam(':hora_fin', $hora_fin);
    $stmt->bindParam(':duracion', $duracion);
    $stmt->bindParam(':costo_total', $costo_total);
    $stmt->bindParam(':estado', $estado);

    // ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cita actualizada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la cita']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>