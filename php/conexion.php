<?php
$host = 'localhost';
$db   = 'yggdrasil_garden';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';
$port = '3309';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
    
}
//echo '✅ Conexión exitosa a la base de datos.';

?>


