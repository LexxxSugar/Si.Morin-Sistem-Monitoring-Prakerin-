<?php
session_name("guru_session");
session_start();
require_once "../../Config/database.php";

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak.");
}

$email_guru = $_SESSION['guru_email'];

if (isset($_POST['pesan'], $_POST['email_siswa'])) {
    $pesan = trim($_POST['pesan']);
    $email_siswa = $_POST['email_siswa'];

    $stmt = $koneksi->prepare("INSERT INTO chat_bimbingan (email_siswa, pengirim, pesan) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email_siswa, $email_guru, $pesan);
    $stmt->execute();
}

// Redirect kembali ke halaman chat
header("Location: bimbingan_detail.php?email=" . urlencode($email_siswa));
exit;
