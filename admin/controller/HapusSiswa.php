<?php
require_once dirname(__DIR__) . "/config/database.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $koneksi->prepare("DELETE FROM datasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../view/kelola_siswa.php?status=hapus_sukses");
    } else {
        header("Location: ../view/kelola_siswa.php?status=hapus_gagal");
    }
} else {
    header("Location: ../view/kelola_siswa.php?status=hapus_error");
}
exit();
