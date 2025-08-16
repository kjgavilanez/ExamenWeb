<?php
// Set content type to JSON
header('Content-Type: application/json');

require_once '../conexion/db.php';
// Siempre va a recibir datos por json
$request = json_decode(file_get_contents('php://input'), true);

$id = $request['id'];

//prepara mi query
$consulta = "SELECT * FROM citas WHERE id = :id";
// ejecutamos la consulta
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':id', $id);
$stmt->execute();
// obtenemos el resultado
$cita = $stmt->fetch(PDO::FETCH_ASSOC);
//imprimir los datos recibidos
echo json_encode($cita);

?>