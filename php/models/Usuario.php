<?php
class Usuario {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "desafio2");
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function registrar($nombre, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $passwordHash);
        return $stmt->execute();
    }

    public function autenticar($email, $password) {
        $stmt = $this->conn->prepare("SELECT password_hash FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return password_verify($password, $row['password_hash']);
        }
        return false;
    }

    public function obtenerID($email) {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }
        return null;
    }

    public function obtenerNombre($email) {
        $stmt = $this->conn->prepare("SELECT nombre FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['nombre'];
        }
        return null;
    }
}
?>
