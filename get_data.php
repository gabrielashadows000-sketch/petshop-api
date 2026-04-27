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
    $pdo = new PDO($dsn, $user, $pass, $options);

    // 1. Crear la tabla físicamente
    $sql_crear = "CREATE TABLE IF NOT EXISTS productos (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        nombre VARCHAR(100), 
        precio DECIMAL(10,2)
    )";
    $pdo->exec($sql_crear);

    // 2. Insertar un dato real para que no esté vacía
    $pdo->exec("INSERT INTO productos (nombre, precio) VALUES ('Producto Petshop Prueba', 19.99)");

    // 3. Consultar y mostrar el resultado en JSON
    $stmt = $pdo->query("SELECT * FROM productos");
    echo json_encode($stmt->fetchAll());

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
