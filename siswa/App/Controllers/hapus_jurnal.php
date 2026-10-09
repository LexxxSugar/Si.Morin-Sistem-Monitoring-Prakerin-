<?php
session_name("siswa_session");
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['id_siswa'])) {
    echo json_encode(["pesan" => "Anda belum login."]);
    exit();
}

require_once __DIR__ . "/../../Config/database.php";

// Ambil data dari request
$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data['id']) ? (int)$data['id'] : 0;

if ($id <= 0) {
    echo json_encode(["pesan" => "ID jurnal tidak valid."]);
    exit();
}

$id_siswa = (int)$_SESSION['id_siswa'];

// Hapus berdasarkan ID dan id_siswa untuk keamanan
$stmt = $conn->prepare("DELETE FROM jurnal WHERE id = ? AND id_siswa = ?");
$stmt->bind_param("ii", $id, $id_siswa);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(["pesan" => "Jurnal berhasil dihapus."]);
} else {
    echo json_encode(["pesan" => "Gagal menghapus jurnal atau data tidak ditemukan."]);
}

$stmt->close();
$conn->close();
?>
