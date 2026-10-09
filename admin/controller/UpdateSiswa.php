<?php
require_once dirname(__DIR__) . "/config/database.php";

if (isset($_POST['id'])) {
    $id       = intval($_POST['id']);
    $nis      = trim($_POST['nis']);
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $jurusan  = trim($_POST['jurusan']);
    $kelas    = trim($_POST['kelas']);
    $semester = trim($_POST['semester_pkl']);
    $tahun    = trim($_POST['tahun_pkl']);
    $password = $_POST['password'];

    if (!empty($password)) {
        // Hash password baru
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $koneksi->prepare("UPDATE datasiswa 
            SET nis=?, nama=?, email=?, jurusan=?, kelas=?, semester_pkl=?, tahun_pkl=?, password=? 
            WHERE id=?");
        $stmt->bind_param("ssssssssi", $nis, $nama, $email, $jurusan, $kelas, $semester, $tahun, $hashedPassword, $id);
    } else {
        // Jika password kosong → jangan diubah
        $stmt = $koneksi->prepare("UPDATE datasiswa 
            SET nis=?, nama=?, email=?, jurusan=?, kelas=?, semester_pkl=?, tahun_pkl=? 
            WHERE id=?");
        $stmt->bind_param("sssssssi", $nis, $nama, $email, $jurusan, $kelas, $semester, $tahun, $id);
    }

    if ($stmt->execute()) {
        header("Location: ../view/kelola_siswa.php?status=update_sukses");
        exit();
    } else {
        header("Location: ../view/kelola_siswa.php?status=error");
        exit();
    }

    $stmt->close();
    $koneksi->close();
} else {
    header("Location: ../view/kelola_siswa.php?status=invalid");
    exit();
}
?>
