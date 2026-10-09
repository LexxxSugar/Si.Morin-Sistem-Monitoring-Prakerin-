<?php
require_once __DIR__ . "/../../Config/database.php";
session_name("guru_session");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_siswa = (int)$_POST['id_siswa'];
    $pengirim = $_POST['pengirim']; // "guru" atau "siswa"
    $penerima = !empty($_POST['penerima']) ? $_POST['penerima'] : null;
    $pesan    = trim($_POST['pesan']);

    if (empty($id_siswa) || empty($pengirim) || empty($pesan)) {
        die("Data tidak lengkap.");
    }

    $query = "INSERT INTO chat_bimbingan (id_siswa, pengirim, penerima, pesan, waktu) 
              VALUES (?, ?, ?, ?, NOW())";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("isss", $id_siswa, $pengirim, $penerima, $pesan);

    if ($stmt->execute()) {
        // redirect kembali ke detail chat
        header("Location: ../view/bimbingan_detail.php?id_siswa=" . $id_siswa);
        exit;
    } else {
        die("Gagal menyimpan pesan: " . $stmt->error);
    }
}
?>
