<?php
// eliminar.php
header('Content-Type: application/json');

require_once '../conexion/db.php';
// Siempre va a recibir datos por json
try{
    // Leer el contenido JSON enviado
    $data = json_decode(file_get_contents('php://input'), true);
    // Validar que se recibió el ID
    if (!isset($data['id']) || !is_numeric($data['id'])) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit;
    }
    $id = intval($data['id']);
    // Preparar y ejecutar la eliminación
    $stmt = $pdo->prepare("DELETE FROM pacientes WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el paciente']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}
?>