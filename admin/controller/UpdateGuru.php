<?php
require_once dirname(__DIR__) . "/config/database.php";

if (isset($_POST['update'])) {
    $id        = intval($_POST['id']);
    $nama_guru = trim($_POST['nama_guru']);
    $email     = trim($_POST['email']);
    $jurusan   = trim($_POST['jurusan']);
    $password  = $_POST['password'];

    if (!empty($password)) {
        // Hash password baru
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $koneksi->prepare("UPDATE dataguru SET nama_guru=?, email=?, jurusan=?, password=? WHERE id_guru=?");
        $stmt->bind_param("ssssi", $nama_guru, $email, $jurusan, $hashedPassword, $id);
    } else {
        // Jika password kosong → jangan diubah
        $stmt = $koneksi->prepare("UPDATE dataguru SET nama_guru=?, email=?, jurusan=? WHERE id_guru=?");
        $stmt->bind_param("sssi", $nama_guru, $email, $jurusan, $id);
    }

    if ($stmt->execute()) {
    header("Location: ../view/kelola_guru.php?status=update_sukses");
} else {
    header("Location: ../view/kelola_guru.php?status=error");
}


    $stmt->close();
    $koneksi->close();
}
?>
