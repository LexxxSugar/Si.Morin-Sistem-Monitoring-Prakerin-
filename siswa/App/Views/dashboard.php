<?php
session_name("siswa_session"); 
session_start();

if (!isset($_SESSION["id_siswa"])) {
    header("Location: ../../Public/login.php");
    exit();
}

require_once __DIR__ . "/../../Config/database.php";

$id_siswa = $_SESSION["id_siswa"];

// Ambil data siswa berdasarkan id
$query = "SELECT * FROM datasiswa WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$jurusan = $data['jurusan'] ?? null;

// Ambil data pembimbing jika ada
$pembimbing = null;
$stmt = $conn->prepare("
    SELECT g.nama_guru, g.email 
    FROM bimbingan b 
    JOIN dataguru g ON b.id_guru = g.id_guru 
    WHERE b.id_siswa = ?
");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$pembimbing_result = $stmt->get_result();
if ($pembimbing_result->num_rows > 0) {
    $pembimbing = $pembimbing_result->fetch_assoc();
}
?>


<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<h3>Selamat datang, <?= htmlspecialchars($data['nama']) ?>!</h3>
<p>Jurusan: <?= htmlspecialchars($jurusan) ?></p>

<?php if ($pembimbing): ?>
    <div class="alert alert-info mt-3">
        <h6>Pembimbing PKL Anda</h6>
        <p>
            <strong>Nama:</strong> <?= htmlspecialchars($pembimbing['nama_guru']) ?><br>
            <strong>Email:</strong> <?= htmlspecialchars($pembimbing['email']) ?>
        </p>
    </div>
<?php else: ?>
    <div class="alert alert-warning mt-3">
        Anda belum memiliki pembimbing PKL.
    </div>
<?php endif; ?>

<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Informasi</h5>
        <p class="card-text">Selamat datang di sistem PKL siswa. Gunakan menu di samping untuk mengakses fitur-fitur seperti jurnal, penilaian, dan lainnya.</p>
    </div>
</div>

<?php include 'template/footer.php'; ?>
