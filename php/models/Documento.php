<?php
class Documento {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "desafio2");
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function subir($usuario_id, $file) {
        $nombre = basename($file["name"]);
        $tipo = $file["type"];

        if (!preg_match("/^[\w\-. ]+\.(pdf|docx|txt)$/i", $nombre)) {
            die("Nombre de archivo inválido");
        }

        $ruta_relativa = "uploads/user_" . $usuario_id . "/" . $nombre;
        $ruta_absoluta = __DIR__ . "/../../" . $ruta_relativa;

        if (!is_dir(dirname($ruta_absoluta))) {
            mkdir(dirname($ruta_absoluta), 0777, true);
        }

        if (move_uploaded_file($file["tmp_name"], $ruta_absoluta)) {
            $stmt = $this->conn->prepare("INSERT INTO documentos (usuario_id, nombre, ruta, tipo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $usuario_id, $nombre, $ruta_relativa, $tipo);
            $stmt->execute();
        }
    }

    public function obtenerPorUsuario($usuario_id) {
        $stmt = $this->conn->prepare("SELECT * FROM documentos WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $documentos = [];
        while ($row = $result->fetch_assoc()) {
            $documentos[] = $row;
        }
        return $documentos;
    }

    public function obtenerTodos() {
        $query = "SELECT * FROM documentos";
        $result = $this->conn->query($query);
        $documentos = [];
        while ($row = $result->fetch_assoc()) {
            $documentos[] = $row;
        }
        return $documentos;
    }

    public function eliminar($documento_id) {
        // Obtener ruta del archivo
        $stmt = $this->conn->prepare("SELECT ruta FROM documentos WHERE id = ?");
        $stmt->bind_param("i", $documento_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($row = $result->fetch_assoc()) {
            $ruta = __DIR__ . "/../../" . $row['ruta'];
    
            // Eliminar archivo físico si existe
            if (file_exists($ruta)) {
                unlink($ruta);
            }
    
            $stmt->close(); // Cerrar el primer statement
    
            // Eliminar registro de la base de datos
            $stmt = $this->conn->prepare("DELETE FROM documentos WHERE id = ?");
            $stmt->bind_param("i", $documento_id);
            $stmt->execute();
            $stmt->close(); // Buena práctica cerrar también el segundo
        }
    }
}
?>
