<?php
session_name("siswa_session");
session_start();
require_once __DIR__ . "/../../Config/database.php";

if (!isset($_SESSION['id_siswa'])) {
    header("Location: ../../Public/login.php");
    exit();
}

$id_siswa = (int)$_SESSION['id_siswa'];
$tanggal = $_POST['tanggal'] ?? date("Y-m-d");

// Cek apakah sudah absen hari ini
$cek = $conn->prepare("SELECT id, valid FROM absen WHERE id_siswa = ? AND tanggal = ?");
$cek->bind_param("is", $id_siswa, $tanggal);
$cek->execute();
$hasil = $cek->get_result();

if ($hasil->num_rows > 0) {
    $data = $hasil->fetch_assoc();
    $status = $data['valid'] == 1 ? 'valid' : 'belum_valid';
    header("Location: ../Views/absen.php?status=$status");
    exit();
}

// Simpan absen baru
$waktu = date("Y-m-d H:i:s");
$status = "Hadir";
$valid = 0;

$stmt = $conn->prepare("INSERT INTO absen (id_siswa, tanggal, waktu, status, valid) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isssi", $id_siswa, $tanggal, $waktu, $status, $valid);

if ($stmt->execute()) {
    header("Location: ../Views/absen.php?status=sukses");
} else {
    header("Location: ../Views/absen.php?status=gagal");
}
exit();
