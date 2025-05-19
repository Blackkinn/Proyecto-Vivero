<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

$producto = null;
$imagenActual = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        die("Producto no encontrado.");
    }
    $imagenActual = $producto['imagen'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $imagen_path = $_POST['imagen_actual'] ?? null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {

        // Verifica si la imagen es válida
        $tipoArchivo = mime_content_type($_FILES['imagen']['tmp_name']);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            echo "<p>❌ El archivo no es una imagen válida.</p>";
            exit();
        }
        // Nueva ruta para guardar en images/productos/
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreSeguro = uniqid('img_', true) . '.' . strtolower($extension);
        $imagen_path = 'images/productos/' . $nombreSeguro;
        $directorioDestino = __DIR__ . '/../images/productos/';
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }
        $destino = $directorioDestino . $nombreSeguro;

        // Elimina la imagen anterior si existe y no es null ni vacía
        if (!empty($_POST['imagen_actual'])) {
            $rutaAnterior = __DIR__ . '/../' . $_POST['imagen_actual'];
            if (file_exists($rutaAnterior)) {
                unlink($rutaAnterior);
            }
        }

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            echo "<p>❌ Error al mover la nueva imagen.</p>";
            exit();
        }
    }

    $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, stock = ?, imagen = ? WHERE id = ?");
    $stmt->execute([$nombre, $precio, $cantidad, $imagen_path, $id]);

    header('Location: admin_products.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto-Vivero/css/estilos.css">
</head>
<body class="login-body">

    <div class="login-container">
        <h1 class="login-title">✏️ Editar Producto</h1>

        <?php if ($producto): ?>
        <form action="edit_product.php" method="POST" enctype="multipart/form-data" class="login-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
            <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($producto['imagen']) ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required>

            <label for="cantidad">Stock:</label>
            <input type="number" name="cantidad" id="cantidad" value="<?= htmlspecialchars($producto['stock']) ?>" required>

            <label>Imagen actual:</label>
            <div class="current-image">
                <?php if (!empty($producto['imagen'])): ?>
                    <img src="/Proyecto-Vivero/<?= htmlspecialchars($producto['imagen']) ?>" width="100">
                <?php else: ?>
                    <p>Sin imagen</p>
                <?php endif; ?>
            </div>

            <label for="imagen">Cambiar imagen:</label>
            <input type="file" name="imagen" id="imagen">

            <button type="submit" class="btn login-btn">💾 Guardar cambios</button>
        </form>
        <?php else: ?>
            <p>Producto no encontrado.</p>
        <?php endif; ?>

        <div class="login-links">
            <a href="/Proyecto-Vivero/php/admin_products.php">🔙 Volver a productos</a>
        </div>
    </div>

</body>
</html>
