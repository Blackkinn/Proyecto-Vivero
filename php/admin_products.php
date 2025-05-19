<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$stmt = $pdo->query("SELECT id, nombre, descripcion, precio, stock, imagen FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="https://kit.fontawesome.com/b827c92e90.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/estilos.css">
    
</head>
<body class="admin-body">
    <div class="admin-container"><?php if (isset($_SESSION['mensaje'])): ?>
    <div class="mensaje-flotante">
        <?= htmlspecialchars($_SESSION['mensaje']) ?>
        <?php unset($_SESSION['mensaje']); ?>
    </div>
<?php endif; ?>
        <h1 class="admin-title">🛠️ Panel de Productos</h1>

        <div class="admin-actions">
            <a href="add_product.php" class="btn">➕ Agregar producto</a>
            <a href="logout.php" class="btn logout">Cerrar sesión</a>
            <a href="../index.php" class="btn">🏠 Inicio</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= htmlspecialchars($p['descripcion']) ?></td>
                        <td>$<?= number_format($p['precio'], 2) ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td>
                            <?php if (!empty($p['imagen'])): ?>
                                <img src="/Proyecto-Vivero/<?= htmlspecialchars($p['imagen']) ?>" alt="Producto">
                            <?php else: ?>
                                <span>Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?= $p['id'] ?>" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="eliminar_producto.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar este producto?')" title="Eliminar">
                                🗑️
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
    // Espera 4 segundos y luego oculta el mensaje flotante
    setTimeout(() => {
        const mensaje = document.querySelector('.mensaje-flotante');
        if (mensaje) {
            mensaje.style.transition = 'opacity 0.5s ease';
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.remove(), 500);
        }
    }, 4000); // 4000 ms = 4 segundos
</script>

</body>
</html>
