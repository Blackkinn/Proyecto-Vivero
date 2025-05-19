<?php
session_start();           // Inicia la sesión
session_unset();           // Elimina todas las variables de sesión
session_destroy();         // Destruye la sesión actual

// Redirige al inicio //
header("Location: /Proyecto-Vivero/index.php");

exit;
?>
