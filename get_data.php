<?php
// 1. Encabezados para que Android reciba JSON y no haya problemas de permisos (CORS)
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// 2. Datos de conexión (Basados en tu imagen de Aiven)
$host = 'mysql-48801a3-petshop.c.aivencloud.com';
$port = '16781';
$db   = 'defaultdb';
$user = 'avnadmin';
$pass = 'AVNS_WmMSQFNpYD3AIkKzPGJ'; // Pon aquí la contraseña de Aiven
$ca_path = __DIR__ . '/ca.pem'; // Asegúrate de subir el ca.pem a Render

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    // Configuración limpia de la conexión
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [
        PDO::MYSQL_ATTR_SSL_CA => $ca_path,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Esto quita los números repetidos
    ]);

    $stmt = $pdo->query("SELECT * FROM productos");
    $datos = $stmt->fetchAll();

    echo json_encode($datos);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
