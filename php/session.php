<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    // Si no hay sesión, redirigimos al login
    header("Location: /Proyecto-Vivero/login.html");
    exit();
}
