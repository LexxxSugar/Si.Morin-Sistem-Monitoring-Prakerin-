<?php
session_name("siswa_session"); 
session_start();
require_once '../../Config/database.php';

if (!isset($_SESSION['siswa_login']) || !isset($_SESSION['id_siswa'])) {
    die("Akses ditolak.");
}

$id_siswa = (int)$_SESSION['id_siswa'];
$id_mitra = $_POST['id_mitra'] ?? null;

if (!$id_mitra) {
    die("ID mitra tidak ditemukan.");
}

// Cek apakah siswa sudah memilih mitra sebelumnya
$cek = $conn->prepare("SELECT * FROM lamaran WHERE id_siswa = ?");
$cek->bind_param("i", $id_siswa);
$cek->execute();
$res = $cek->get_result();

if ($res->num_rows > 0) {
    die("Anda sudah memilih mitra PKL.");
}

// Simpan pilihan mitra
$simpan = $conn->prepare("INSERT INTO lamaran (id_siswa, id_mitra, tanggal_lamar) VALUES (?, ?, NOW())");
$simpan->bind_param("ii", $id_siswa, $id_mitra);

if ($simpan->execute()) {
    header("Location: ../Views/mitra.php?pesan=sukses");
    exit();
} else {
    die("Gagal menyimpan pilihan: " . $conn->error);
}
