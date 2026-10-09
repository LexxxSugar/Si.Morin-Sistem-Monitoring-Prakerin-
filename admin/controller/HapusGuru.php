<?php
require_once dirname(__DIR__) . "/config/database.php";

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $koneksi->prepare("DELETE FROM dataguru WHERE id_guru=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: ../view/kelola_guru.php?status=hapus_sukses");
        exit;
    }
}
header("Location: ../view/kelola_guru.php?status=error");
