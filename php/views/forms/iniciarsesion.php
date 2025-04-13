<?php
session_start();

// Si ya está logueado, redirigirlo directamente al dashboard
if (isset($_SESSION['usuario'])) {
    header("Location: ../../views/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Iniciar Sesión</h2>
        <form action="../../controllers/login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
