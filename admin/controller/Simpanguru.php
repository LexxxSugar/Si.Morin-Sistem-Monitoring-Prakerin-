<?php
require_once dirname(__DIR__) . "/config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_guru = trim($_POST['nama_guru']);
    $email     = trim($_POST['email']);
    $jurusan   = trim($_POST['jurusan']);
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // cek duplikat email
    $cek = $koneksi->prepare("SELECT id_guru FROM dataguru WHERE email=?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows > 0) {
        header("Location: ../view/kelola_guru.php?status=duplikat");
        exit;
    }

    $stmt = $koneksi->prepare("INSERT INTO dataguru (nama_guru, email, jurusan, password) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $nama_guru, $email, $jurusan, $password);

    if ($stmt->execute()) {
        header("Location: ../view/kelola_guru.php?status=sukses");
    } else {
        header("Location: ../view/kelola_guru.php?status=error");
    }
}
