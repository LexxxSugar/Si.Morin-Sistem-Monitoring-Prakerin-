<?php
require_once __DIR__ . "/../config/database.php";

class AdminModel {
    public static function getAdminByEmail($email) {
        global $koneksi;
        $stmt = $koneksi->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
