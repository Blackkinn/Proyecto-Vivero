<?php
require_once '../php/conexion.php'; // Asegúrate de que la ruta de conexión es correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (!empty($nombre) && !empty($correo) && !empty($contrasena)) {
        // Verificar si el correo ya existe
        $checkStmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $checkStmt->execute([$correo]);

        if ($checkStmt->fetch()) {
            echo "❌ El correo ya está registrado. <a href='../html/login.html'>¿Ya tienes cuenta? Inicia sesión</a>";
        } else {
            // Encriptar contraseña
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
            if ($stmt->execute([$nombre, $correo, $hash])) {
                // Redirigir a login.html después de un registro exitoso
                header("Location: ../html/login.html");
                exit();
            } else {
                echo "❌ Error al registrar el usuario.";
            }
        }
    } else {
        echo "❌ Todos los campos son obligatorios.";
    }
} else {
    echo "❌ Método no permitido.";
}
?>
