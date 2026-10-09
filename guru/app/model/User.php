<?php
require_once 'config/database.php';

class User {
    private $conn;
    private $table = "dataguru"; // sesuaikan dengan tabel yang ada

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // cek password
            if (password_verify($password, $user['password']) || $user['password'] === md5($password)) {
                // kalau masih MD5, upgrade ke bcrypt
                if ($user['password'] === md5($password)) {
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $update = $this->conn->prepare("UPDATE " . $this->table . " SET password = :password WHERE id_guru = :id");
                    $update->bindParam(":password", $newHash);
                    $update->bindParam(":id", $user['id_guru']);
                    $update->execute();

                    $user['password'] = $newHash;
                }

                return $user;
            }
        }
        return false;
    }
}
