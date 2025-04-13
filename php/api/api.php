<?php
require_once '../models/Documento.php';
header("Content-Type: application/json");

$doc = new Documento();
$documentos = $doc->obtenerTodos(); // Llamamos al método obtenerTodos()

// Si quieres devolver un formato más estructurado, puedes hacerlo así:
$response = [
    "status" => "success",
    "data" => $documentos
];

echo json_encode($response);
?>
