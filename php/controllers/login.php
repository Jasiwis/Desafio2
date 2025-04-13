<?php
require_once '../models/Usuario.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $usuario = new Usuario();

    if ($usuario->autenticar($email, $password)) {
        $_SESSION['usuario'] = $email;
        setcookie("usuario", $email, time() + (86400 * 30), "/"); 
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        echo "Credenciales incorrectas.";
    }
}
exit();
?>
