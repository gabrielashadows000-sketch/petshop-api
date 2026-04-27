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

    // 1. CREAR LA TABLA CON LA ESTRUCTURA CORRECTA
    $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
        id INT PRIMARY KEY,
        nombre VARCHAR(255),
        precio DECIMAL(10,2),
        marca VARCHAR(100),
        categoria VARCHAR(100)
    )");

    // 2. VACIAR LA TABLA SI YA TIENE DATOS DE PRUEBA (Opcional)
    $pdo->exec("TRUNCATE TABLE productos");

    // 3. INSERTAR TODOS TUS PRODUCTOS DE GOLPE
    $sql = "INSERT INTO productos (id, nombre, precio, marca, categoria) VALUES
    (1, 'Alimento Perro Adulto 15kg', 46, 'Dog Chow', 'Perros'),
    (2, 'Alimento Cachorro 3kg', 13, 'Pro Plan', 'Perros'),
    (3, 'Snack Hueso de Carnaza', 4, 'Petys', 'Perros'),
    (4, 'Galletas Horneadas Pollo', 5, 'Barkys', 'Perros'),
    (5, 'Collar Ajustable Nylon', 8, 'Generic', 'Perros'),
    (6, 'Correa Extensible 5m', 15, 'Flexi', 'Perros'),
    (7, 'Cama Acolchada L', 25, 'SleepyPet', 'Perros'),
    (8, 'Juguete Mordedor Caucho', 8, 'Kong', 'Perros'),
    (9, 'Shampoo Antipulgas', 10, 'CanAmor', 'Perros'),
    (10, 'Cepillo de Cerdas Suaves', 6, 'Furminator', 'Perros'),
    (11, 'Alimento Gato Esterilizado 1.5kg', 19, 'Cat Chow', 'Gatos'),
    (12, 'Arena Sanitaria 5kg', 11, 'Tidy Cats', 'Gatos'),
    (13, 'Rascador Tres Niveles', 40, 'FancyPets', 'Gatos'),
    (14, 'Snack Líquido Salmón', 3, 'Churu', 'Gatos'),
    (15, 'Comedero Cerámica', 10, 'KittyStyle', 'Gatos'),
    (16, 'Caja Arena Básica', 14, 'Van Ness', 'Gatos'),
    (17, 'Hierba Gatera Orgánica', 5, 'SmartyKat', 'Gatos'),
    (18, 'Transportadora Rígida', 30, 'PetMate', 'Gatos'),
    (19, 'Arnés con Pechera', 12, 'CatHarness', 'Gatos'),
    (20, 'Pipeta Antiparasitaria', 14, 'Frontline', 'Gatos'),
    (21, 'Mezcla Semillas Canarios', 4, 'Vitakraft', 'Aves'),
    (22, 'Juguete Láser Automático', 16, 'Frolicat', 'Gatos'),
    (23, 'Columpio de Madera Natural', 4, 'LivingWorld', 'Aves'),
    (24, 'Escamas Peces Tropicales', 6, 'TetraMin', 'Peces'),
    (25, 'Anticloro para Agua', 3, 'Seachem', 'Peces'),
    (26, 'Termómetro Digital Acuario', 6, 'Sera', 'Peces'),
    (27, 'Filtro Interno Acuario', 19, 'Fluval', 'Peces'),
    (28, 'Piedra Calcio Loros', 2, 'LivingWorld', 'Aves'),
    (29, 'Juguete Espejo Aves', 4, 'Penn-Plax', 'Aves'),
    (30, 'Champú en Seco (Espuma)', 11, 'Beaphar', 'Gatos');";

    $pdo->exec($sql);

    echo json_encode(["status" => "¡Base de datos cargada con éxito en Aiven!"]);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
