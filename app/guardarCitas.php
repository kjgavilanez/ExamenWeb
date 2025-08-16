<?php
//conectar a base de datos con db.php
require_once '../conexion/db.php';

// recibir los datos del formulario
/* CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    duracion INT NOT NULL, -- en minutos, calculado en PHP
    costo_total DECIMAL(10,2) NOT NULL, -- calculado en PHP
    estado VARCHAR(20) DEFAULT 'programada',

    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE
); */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // recibir los datos del formulario
    $paciente_id = $_POST['paciente_id'];
    $medico_id = $_POST['medico_id'];
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $duracion = $_POST['duracion'];
    $costo_total = $_POST['costo_total'];
    // imprimir los datos recibidos
    // ingresar los datos en nuestra base de datos
    $sql = "INSERT INTO citas (paciente_id, medico_id, fecha, hora_inicio, hora_fin, duracion, costo_total) VALUES (:paciente_id, :medico_id, :fecha, :hora_inicio, :hora_fin, :duracion, :costo_total)";
    // enviar variables con bindParam para evitar inyecciones SQL
    // bindParam vincula una variable a un parámetro de la sentencia SQL
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':paciente_id', $paciente_id);
    $stmt->bindParam(':medico_id', $medico_id);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora_inicio', $hora_inicio);
    $stmt->bindParam(':hora_fin', $hora_fin);
    $stmt->bindParam(':duracion', $duracion);
    $stmt->bindParam(':costo_total', $costo_total);
    // ejecutar la consulta
    if ($stmt->execute()) {
        // redirigir a la página de creación de médicos
        header("Location: ../index.html");
        
    } else {
        echo "Error al crear la cita.";
    }
}
?>