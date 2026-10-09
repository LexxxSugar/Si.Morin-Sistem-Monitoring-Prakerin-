<?php
require_once __DIR__ . '/../../Config/database.php';

class User {
    /**
     * Ambil data user (siswa) berdasarkan email.
     *
     * @param string $email
     * @return array|null
     */
    public static function getUserByEmail($email) {
        global $conn;

        if (!$conn) {
            die("Koneksi ke database gagal.");
        }

        $stmt = $conn->prepare("SELECT * FROM datasiswa WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Kembalikan array atau null jika tidak ditemukan
    }
}
