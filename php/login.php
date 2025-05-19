<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        
        $_SESSION['rol'] = $usuario['rol']; // 'admin' o 'usuario'

        // Guardamos los datos en la sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_correo'] = $usuario['correo'];

    
        header("Location: /Proyecto-Vivero/index.php");

        exit();
    } else {
        echo "❌ Correo o contraseña incorrectos.";
    }
} else {
    echo "❌ Método no permitido.";
}

