<?php
session_name("siswa_session"); 
session_start();

require_once "../../Config/database.php";

// Pastikan sudah login siswa
if (!isset($_SESSION['id_siswa'])) {
    die("Akses ditolak.");
}

$id_siswa = (int) $_SESSION['id_siswa'];
$id_guru  = isset($_POST['id_guru']) ? (int)$_POST['id_guru'] : 0;

if ($id_siswa <= 0 || $id_guru <= 0) {
    die("Data tidak lengkap atau tidak valid.");
}

// Cek apakah siswa sudah punya pembimbing
$cek = $conn->prepare("SELECT 1 FROM bimbingan WHERE id_siswa = ?");
$cek->bind_param("i", $id_siswa);
$cek->execute();
$res = $cek->get_result();

if ($res->num_rows > 0) {
    die("Anda sudah memilih pembimbing.");
}

// Simpan bimbingan
$simpan = $conn->prepare("INSERT INTO bimbingan (id_siswa, id_guru) VALUES (?, ?)");
$simpan->bind_param("ii", $id_siswa, $id_guru);

if ($simpan->execute()) {
    header("Location: ../Views/dashboard.php?pesan=sukses");
    exit;
} else {
    echo "Gagal simpan: " . $conn->error;
}
