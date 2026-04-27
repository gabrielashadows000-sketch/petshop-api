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
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [
        PDO::MYSQL_ATTR_SSL_CA => $ca_path,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 1. Crear la tabla con todas tus columnas
    $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
        id INT PRIMARY KEY,
        nombre VARCHAR(255),
        precio DECIMAL(10,2),
        marca VARCHAR(100),
        categoria VARCHAR(100)
    )");

    // 2. Insertar tus productos (He puesto los primeros de tu imagen)
    $pdo->exec("INSERT IGNORE INTO productos VALUES 
        (1, 'Alimento Perro Adulto 15kg', 46, 'Dog Chow', 'Perros'),
        (2, 'Alimento Cachorro 3kg', 13, 'Pro Plan', 'Perros'),
        (3, 'Snack Hueso de Carnaza', 4, 'Petys', 'Perros'),
        (4, 'Galletas Horneadas Pollo', 5, 'Barkys', 'Perros')");

    echo "✅ ¡DATOS SUBIDOS A AIVEN CON ÉXITO!";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
