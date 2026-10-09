<?php
session_name("guru_session");
session_start();

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak.");
}

require_once '../../Config/database.php';

$id_siswa = $_POST['id_siswa'] ?? null;
$aspek_1 = $_POST['aspek_1'] ?? null;
$aspek_2 = $_POST['aspek_2'] ?? null;
$aspek_3 = $_POST['aspek_3'] ?? null;
$aspek_4 = $_POST['aspek_4'] ?? null;
// 1. Perbaikan typo null coalescing
$komentar = $_POST['komentar'] ?? null; 

// Validasi data (menggunakan isset agar 0 tidak dianggap kosong)
if (!isset($id_siswa, $aspek_1, $aspek_2, $aspek_3, $aspek_4, $komentar)) {
    die("Data tidak lengkap.");
}

// Hitung rata-rata
$rata_rata = round(($aspek_1 + $aspek_2 + $aspek_3 + $aspek_4) / 4, 2);

// Cek apakah nilai sudah ada
$cek = $koneksi->prepare("SELECT id FROM penilaian_pkl WHERE id_siswa = ?");
$cek->bind_param("i", $id_siswa);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows > 0) {
    // 2. Perbaikan UPDATE: Urutan variabel dan tipe data ("iiiidsi") disesuaikan
    $stmt = $koneksi->prepare("UPDATE penilaian_pkl 
        SET aspek_1=?, aspek_2=?, aspek_3=?, aspek_4=?, rata_rata=?, komentar=?
        WHERE id_siswa = ?");
    $stmt->bind_param("iiiidsi", $aspek_1, $aspek_2, $aspek_3, $aspek_4, $rata_rata, $komentar, $id_siswa);
} else {
    // 3. Perbaikan INSERT: Tanda tanya (?) ditambah jadi 7, tipe data ("iiiiids") disesuaikan
    $stmt = $koneksi->prepare("INSERT INTO penilaian_pkl 
        (id_siswa, aspek_1, aspek_2, aspek_3, aspek_4, rata_rata, komentar) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiids", $id_siswa, $aspek_1, $aspek_2, $aspek_3, $aspek_4, $rata_rata, $komentar);
}

if ($stmt->execute()) {
    header("Location: ../view/penilaian.php?status=sukses");
    exit();
} else {
    echo "Gagal menyimpan data: " . $stmt->error;
}
?>