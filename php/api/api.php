<?php
require_once '../models/Documento.php';
header("Content-Type: application/json");

$doc = new Documento();
$documentos = $doc->obtenerTodos(); // Llamamos al método obtenerTodos()

// Devuelve un formato más estructurado
$response = [
    "status" => "success",
    "data" => $documentos
];

echo json_encode($response);
?>
