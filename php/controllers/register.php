<?php
require_once '../models/Usuario.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validaciones básicas
    if (!preg_match("/^[a-zA-ZÁÉÍÓÚáéíóúñÑ ]{2,100}$/", $nombre)) {
        die("Nombre inválido. Usa solo letras y espacios (mínimo 2 caracteres).");
    }

    if (!preg_match("/^[\w.-]+@[\w.-]+\.\w{2,4}$/", $email)) {
        die("Correo inválido");
    }

    if (!preg_match("/.{6,}/", $password)) {
        die("La contraseña debe tener al menos 6 caracteres");
    }

    $usuario = new Usuario();
    
    // Llamamos al método registrar pasando nombre, email y password
    if ($usuario->registrar($nombre, $email, $password)) {
        $_SESSION['usuario'] = $email;
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        die("Error al registrar usuario. Es posible que el correo ya esté registrado.");
    }
}
?>
