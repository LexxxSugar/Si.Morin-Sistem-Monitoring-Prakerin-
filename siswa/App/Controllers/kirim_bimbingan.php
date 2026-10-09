<?php
require_once __DIR__ . "/../../Config/database.php";
session_name("siswa_session");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['id_siswa'])) {
        header("Location: ../../Public/login.php");
        exit();
    }

    $id_siswa = (int)$_SESSION['id_siswa'];
    $pengirim = trim($_POST['pengirim']);
    $pesan    = trim($_POST['pesan']);

    if (!empty($pesan)) {
        $query = "INSERT INTO chat_bimbingan (id_siswa, pengirim, pesan, waktu) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $id_siswa, $pengirim, $pesan);
        $stmt->execute();
    }

    header("Location: ../Views/bimbingan.php");
    exit();
}
