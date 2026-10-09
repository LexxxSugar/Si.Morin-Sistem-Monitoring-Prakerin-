<?php
require_once dirname(__DIR__) . "/config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $jurusan = $_POST['jurusan'];
    $kelas = $_POST['kelas'];
    $tahun_pkl = $_POST['tahun_pkl'];
    $semester_pkl = $_POST['semester_pkl'];

    // Cek email duplikat
    $cek = $koneksi->prepare("SELECT id FROM datasiswa WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        header("Location: ../view/tambah_siswa.php?status=duplikat");
        exit();
    }

    $stmt = $koneksi->prepare("INSERT INTO datasiswa (nis, nama, email, password, jurusan, kelas, tahun_pkl, semester_pkl) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nis, $nama, $email, $password, $jurusan, $kelas, $tahun_pkl, $semester_pkl);

    if ($stmt->execute()) {
        header("Location: ../view/kelola_siswa.php?status=sukses");
    } else {
        header("Location: ../view/tambah_siswa.php?status=gagal");
    }
}
?>
