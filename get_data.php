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
    // 3. Configuración de conexión con SSL obligatorio
    $options = [
        PDO::MYSQL_ATTR_SSL_CA => $ca_path,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);

    // 4. Consulta a la base de datos
    // Cambia "productos" por el nombre de tu tabla real
    $sql = "SELECT * FROM productos"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $resultados = $stmt->fetchAll();

    // 5. Enviar resultados a Android
    echo json_encode($resultados);

} catch (PDOException $e) {
    // Si hay error, enviamos el mensaje en formato JSON también
    echo json_encode([
        "error" => "Error de conexión",
        "mensaje" => $e->getMessage()
    ]);
}
?>
