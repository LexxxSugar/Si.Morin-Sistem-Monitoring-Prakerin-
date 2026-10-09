<?php
session_name("siswa_session");
session_start();

require_once __DIR__ . "/../../Config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    $id_siswa = trim($_POST["email"]);
    $inputPassword = $_POST["password"];

    // Ambil data user dari database
    $stmt = $conn->prepare("SELECT * FROM datasiswa WHERE id_siswa = ?");
    $stmt->bind_param("i", $id_siswa);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Cek apakah user ditemukan dan password cocok
    if ($user && password_verify($inputPassword, $user["password"])) {
        $_SESSION["siswa_login"] = true;
        $_SESSION["siswa_email"] = $id_siswa;

        header("Location: ../../App/Views/dashboard.php");
        exit();
    } else {
        $_SESSION["error"] = "Email atau password salah!";
        header("Location: ../../Public/login.php"); // pastikan nama file login kamu sesuai
        exit();
    }
}
