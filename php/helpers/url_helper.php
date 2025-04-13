<?php
function base_url() {
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = $_SERVER['SCRIPT_NAME'];

    // Obtener la ruta del proyecto (por ejemplo, /Desafio2/)
    $projectPath = explode("/", $scriptName)[1];
    return "http://$host/$projectPath/";
}
