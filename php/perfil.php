<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];


$stmt = $pdo->prepare("SELECT nombre, correo, rol, telefono, direccion FROM usuarios WHERE id = ?");

$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$nombre = $usuario['nombre'] ?? '';
$correo = $usuario['correo'] ?? '';
$rol = $usuario['rol'] ?? 'usuario';
$telefono = $usuario['telefono'];
$direccion = $usuario['direccion'];

$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto-Vivero/css/estilos.css">
</head>
<body class="perfil-body">

    <header class="perfil-header">
        <a href="logout.php" class="btn logout-btn">Cerrar sesión</a>
        <h1>👤 Perfil de <?php echo htmlspecialchars($nombre); ?></h1>
        <p><strong>Correo:</strong> <?php echo htmlspecialchars($correo); ?></p>
    </header>

    <nav class="perfil-nav">
        <a href="../index.php" class="btn home-btn">🏠 Volver al inicio</a>
        <?php if ($rol === 'admin'): ?>
            <a href="admin_products.php" class="btn admin-btn">🛠 Panel de administración</a>
        <?php endif; ?>
    </nav>

    <section class="perfil-actualizar">
    <button onclick="toggleFormulario()" class="btn toggle-btn">✏️ Actualiza Tus Datos</button>

    <div id="formulario-actualizar" style="display: none;">
        <form action="actualizar_usuario.php" method="post" class="form-actualizar">
            <label for="nuevo_nombre">Nuevo nombre:</label>
            <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="nueva_contrasena">Nueva contraseña:</label>
            <input type="password" id="nueva_contrasena" name="nueva_contrasena">

            <label for="confirmar">Confirmar contraseña:</label>
            <input type="password" name="confirmar" id="confirmar" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" id="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" value="<?php echo htmlspecialchars($direccion); ?>" required>

            <button type="submit" class="btn actualizar-btn">Actualizar</button>
        </form>
    </div>
</section>


    <section class="pedidos">
        <h2>📦 Tus pedidos:</h2>
        <?php if (count($pedidos) > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?php echo $pedido['id']; ?></td>
                                <td><?php echo $pedido['fecha']; ?></td>
                                <td><?php echo htmlspecialchars($pedido['detalle']); ?></td>
                                <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-pedidos">🚫 No tienes pedidos registrados.</p>
        <?php endif; ?>
    </section>
    <script>
function toggleFormulario() {
    const form = document.getElementById('formulario-actualizar');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>

</body>
</html>
