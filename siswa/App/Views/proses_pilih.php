<?php
session_name("siswa_session"); 
session_start();
include '../../config/database.php';

if (!isset($_SESSION['siswa_email'])) {
    header("Location: ../../login.php");
    exit();
}

$email_siswa = $_SESSION['siswa_email'];
$id_guru = $_POST['id_guru'] ?? null;

if (!$id_guru) {
    echo "<script>alert('Pembimbing tidak valid.'); window.history.back();</script>";
    exit();
}

$cek = $conn->prepare("SELECT * FROM bimbingan WHERE email_siswa = ?");
$cek->bind_param("s", $email_siswa);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    echo "<script>
        alert('❌ Kamu sudah memilih pembimbing sebelumnya.');
        window.location.href = 'pilih_pembimbing.php';
    </script>";
    exit();
}

$insert = $conn->prepare("INSERT INTO bimbingan (email_siswa, id_guru) VALUES (?, ?)");
$insert->bind_param("si", $email_siswa, $id_guru);

if ($insert->execute()) {
    echo "<script>
        alert('✅ Pembimbing berhasil dipilih!');
        window.location.href = 'pilih_pembimbing.php';
    </script>";
} else {
    echo "<script>
        alert('❌ Gagal memilih pembimbing.');
        window.location.href = 'pilih_pembimbing.php';
    </script>";
}
?>
