<?php
require_once '../models/Usuario.php';
require_once '../models/Documento.php';
require_once '../helpers/url_helper.php';
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['usuario'])) {
    header("Location: forms/iniciarsesion.php");
    exit();
}   

$usuario = new Usuario();
$doc = new Documento();
$usuario_id = $usuario->obtenerID($_SESSION['usuario']);

// Subir documento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['documento'])) {
    $doc->subir($usuario_id, $_FILES['documento']);
}

// Eliminar documento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_id'])) {
    $doc->eliminar($_POST['eliminar_id']);
}

// Obtener documentos del usuario
$documentos = $doc->obtenerPorUsuario($usuario_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="m-0">Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
        <a href="../controllers/logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="documento" class="form-label">Subir Documento</label>
            <input type="file" name="documento" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir</button>
    </form>

    <h4 class="mt-5">Documentos Disponibles</h4>
    <ul class="list-group">
        <?php if (count($documentos) > 0): ?>
            <?php foreach ($documentos as $doc): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?php echo $doc['nombre']; ?> - <?php echo $doc['tipo']; ?></span>
                    <div>
                        <a href="<?php echo base_url() . $doc['ruta']; ?>" target="_blank" class="btn btn-sm btn-info me-2">Ver</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="eliminar_id" value="<?php echo $doc['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este documento?');">Eliminar</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">No tienes documentos disponibles.</li>
        <?php endif; ?>
    </ul>

    <script>
    window.history.pushState(null, "", window.location.href);
    window.addEventListener("popstate", function () {
        window.history.pushState(null, "", window.location.href);
    });

    window.addEventListener("pageshow", function (event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.href = window.location.href;
        }
    });

    window.addEventListener("popstate", function () {
        window.location.href = window.location.href;
    });
    </script>
</body>
</html>
