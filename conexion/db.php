<?php
//conexion/db.php
$host = 'localhost';
$dbname = 'citas';
$username = 'citas';
$password = '12345';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try{
    //la variable $pdo se utiliza para crear una coexión a la base de datos
    //PDO es una extensión de PHP que proporciona una interfaz para acceder a bases de datos de manera segura y eficiente.
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Conexión exitosa - no imprimimos nada para evitar interferir con respuestas JSON
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>