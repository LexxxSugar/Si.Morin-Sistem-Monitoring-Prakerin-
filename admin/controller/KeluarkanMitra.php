<?php
session_name("admin_session");
session_start();
require_once dirname(__DIR__) . "/config/database.php";

// Proteksi admin
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../view/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../view/kelola_siswa.php?status=invalid_id");
    exit();
}

$id_siswa = intval($_GET['id']); // keamanan: pastikan integer

// Hapus relasi siswa–mitra
$stmt = $koneksi->prepare("DELETE FROM lamaran WHERE id_siswa = ?");
$stmt->bind_param("i", $id_siswa);

if ($stmt->execute()) {
    header("Location: ../view/kelola_siswa.php?status=keluar_sukses");
} else {
    header("Location: ../view/kelola_siswa.php?status=keluar_error");
}
