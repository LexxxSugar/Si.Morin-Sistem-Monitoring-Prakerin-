<?php
session_name("siswa_session");
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id_siswa"])) {
    echo json_encode(["pesan" => "Anda belum login."]);
    exit();
}

require_once __DIR__ . "/../Config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$tanggal  = $data["tanggal"] ?? null;
$waktu    = $data["waktu"] ?? null;
$kegiatan = $data["kegiatan"] ?? null;
$catatan  = $data["catatan"] ?? "";

if (!$tanggal || !$waktu || !$kegiatan) {
    echo json_encode(["pesan" => "Data tidak lengkap."]);
    exit();
}

$id_siswa = $_SESSION["id_siswa"];

$query = "INSERT INTO jurnal (id_siswa, tanggal, waktu, kegiatan, catatan) 
          VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("issss", $id_siswa, $tanggal, $waktu, $kegiatan, $catatan);

if ($stmt->execute()) {
    echo json_encode(["pesan" => "Jurnal berhasil disimpan."]);
} else {
    echo json_encode(["pesan" => "Gagal menyimpan jurnal: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
