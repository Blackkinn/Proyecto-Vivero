<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $rutaImagen = null;

    
    // Procesar imagen si se sube
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreSeguro = uniqid('img_', true) . '.' . strtolower($extension);
        $rutaImagen = 'images/productos/' . $nombreSeguro;

        // Asegura que la carpeta exista
        $directorioDestino = __DIR__ . '/../images/productos/';
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }
        $destino = $directorioDestino . $nombreSeguro;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            echo "<p>❌ Error al mover la imagen.</p>";
            exit();
        }
    }


    // Insertar producto en la base de datos
    $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$nombre, $descripcion, $precio, $stock, $rutaImagen])) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "<p>❌ Error al agregar el producto.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto-Vivero/css/estilos.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h1 class="login-title">🌱 Agregar Nuevo Producto</h1>
        <form action="/Proyecto-Vivero/php/add_product.php" method="post" enctype="multipart/form-data" class="login-form">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio" required>

            <label for="stock">Stock:</label>
            <input type="number" name="stock" id="stock" required>

            <label for="imagen">Imagen (JPG/PNG):</label>
            <input type="file" name="imagen" id="imagen" accept="image/*" required>

            <button type="submit" class="btn login-btn">Agregar Producto</button>
        </form>

        <a href="admin_products.php" class="login-links">🔙 Volver a productos</a>
    </div>
</body>
</html>
