<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Validar ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "❌ ID de producto inválido.";
    header("Location: admin_products.php");
    exit;
}

$id = $_GET['id'];

// Obtener imagen del producto
$stmt = $pdo->prepare("SELECT imagen FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($producto) {
    $rutaImagen = '../' . $producto['imagen'];

    // Eliminar imagen si existe
    if (!empty($producto['imagen']) && file_exists($rutaImagen)) {
        unlink($rutaImagen);
    }

    // Eliminar producto
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    
    $_SESSION['mensaje'] = "<div class='alert alert-info' role='alert'>
  A simple info alert—check it out!
</div>";

} else {
    $_SESSION['mensaje'] = "❌ Producto no encontrado.";
}

header("Location: admin_products.php");
exit;
