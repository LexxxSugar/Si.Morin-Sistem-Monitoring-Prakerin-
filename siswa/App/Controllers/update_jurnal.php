<?php
session_name("siswa_session");
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['id_siswa'])) {
    echo json_encode(["pesan" => "Anda belum login."]);
    exit();
}

require_once __DIR__ . "/../../Config/database.php";

// Ambil data dari request JSON
$data = json_decode(file_get_contents("php://input"), true);

$id       = isset($data["id"]) ? (int)$data["id"] : 0;
$tanggal  = $data["tanggal"] ?? null;
$waktu    = $data["waktu"] ?? null;
$kegiatan = $data["kegiatan"] ?? null;
$catatan  = $data["catatan"] ?? "";

if ($id <= 0 || !$tanggal || !$waktu || !$kegiatan) {
    echo json_encode(["pesan" => "Data tidak lengkap."]);
    exit();
}

$id_siswa = (int)$_SESSION['id_siswa'];

$stmt = $conn->prepare("
    UPDATE jurnal 
    SET tanggal = ?, waktu = ?, kegiatan = ?, catatan = ? 
    WHERE id = ? AND id_siswa = ?
");
$stmt->bind_param("ssssii", $tanggal, $waktu, $kegiatan, $catatan, $id, $id_siswa);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["pesan" => "Jurnal berhasil diperbarui."]);
    } else {
        echo json_encode(["pesan" => "Tidak ada perubahan data atau data tidak ditemukan."]);
    }
} else {
    echo json_encode(["pesan" => "Gagal memperbarui jurnal: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
