<?php
include '../../config/database.php';
session_start();

$id_siswa = $_POST['id_siswa'];
$aspek1 = $_POST['aspek1'];
$aspek2 = $_POST['aspek2'];
$aspek3 = $_POST['aspek3'];
$aspek4 = $_POST['aspek4'];
$komentar = $_POST['komentar'];

// Hitung rata-rata
$rata = ($aspek1 + $aspek2 + $aspek3 + $aspek4) / 4;

$query = "INSERT INTO penilaian_pkl (id_siswa, aspek_1, aspek_2, aspek_3, aspek_4, rata_rata, komentar) 
          VALUES (?, ?, ?, ?, ?, ?, ?)
          ON DUPLICATE KEY UPDATE 
            aspek_1 = VALUES(aspek_1), 
            aspek_2 = VALUES(aspek_2), 
            aspek_3 = VALUES(aspek_3), 
            aspek_4 = VALUES(aspek_4), 
            rata_rata = VALUES(rata_rata),
            komentar = VALUES(komentar)";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("idddddd", $id_siswa, $aspek1, $aspek2, $aspek3, $aspek4, $rata, $komentar);

if ($stmt->execute()) {
    header("Location: penilaian-tkrs.php?success=1");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
