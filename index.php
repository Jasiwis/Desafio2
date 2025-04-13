<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: php/views/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Desafío 2 - Gestión de Documentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Bienvenido a la Gestión de Documentos</h1>

        <?php
        if (isset($_SESSION['logout_success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show mt-3 text-center" role="alert">
                    ' . $_SESSION['logout_success'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            unset($_SESSION['logout_success']);
        }
        ?>

        <div class="text-center mt-4">
            <a href="php/views/forms/registrar.php" class="btn btn-primary me-2">Registrarse</a>
            <a href="php/views/forms/iniciarsesion.php" class="btn btn-success">Iniciar Sesión</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
