<?php
session_start();
require_once '../php/conexion.php'; // Ajusta la ruta si es necesario

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../html/login.html");
    exit;
}

// Obtiene datos del formulario
$id_usuario = $_SESSION['usuario_id'];
$nuevo_nombre = $_POST['nuevo_nombre'] ?? '';
$nueva_contrasena = $_POST['nueva_contrasena'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$direccion = $_POST['direccion'] ?? '';

// Validación
if (empty($nuevo_nombre) || empty($confirmar) || empty($telefono) || empty($direccion)) {
    echo "❌ Todos los campos excepto la contraseña son obligatorios.";
    exit;
}

try {
    // Comenzar con la actualización de nombre, teléfono y dirección
    $sql = "UPDATE usuarios SET nombre = ?, telefono = ?, direccion = ?";

    $params = [$nuevo_nombre, $telefono, $direccion];

    // Si se desea cambiar la contraseña, verifica que coincida con confirmar
    if (!empty($nueva_contrasena)) {
        if ($nueva_contrasena !== $confirmar) {
            echo "❌ Las contraseñas no coinciden.";
            exit;
        }
        $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $sql .= ", contrasena = ?";
        $params[] = $hash;
    }

    $sql .= " WHERE id = ?";
    $params[] = $id_usuario;

    // Ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    
    header("Location: /Proyecto-Vivero/php/perfil.php");
        exit();

} catch (PDOException $e) {
    echo "❌ Error al actualizar: " . $e->getMessage();
}
?>
