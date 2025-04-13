<?php
session_start();
session_unset();
session_destroy();

session_start();
$_SESSION['logout_success'] = "¡Has cerrado sesión correctamente!";

// Ajusta el path si index.php está en la raíz del proyecto
header("Location: ../../index.php");
exit();