<?php
session_name("admin_session");
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}
require_once dirname(__DIR__) . "/config/database.php";

$id = intval($_GET['id'] ?? 0);
$stmt = $koneksi->prepare("SELECT * FROM dataguru WHERE id_guru=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: kelola_guru.php?status=notfound");
    exit();
}
include "template/header.php";
?>

<div class="container mt-4">
    <h3>Edit Guru</h3>
    <form action="../controller/UpdateGuru.php" method="POST" class="p-4 bg-light rounded shadow-sm">
        <input type="hidden" name="id" value="<?= $data['id_guru'] ?>">
        <div class="mb-3">
            <label>Nama Guru</label>
            <input type="text" name="nama_guru" class="form-control" value="<?= htmlspecialchars($data['nama_guru']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Jurusan</label>
            <select name="jurusan" class="form-select" required>
                <option value="Rekayasa Perangkat Lunak" <?= $data['jurusan']=="Rekayasa Perangkat Lunak"?"selected":"" ?>>Rekayasa Perangkat Lunak</option>
                <option value="Teknik Komputer Jaringan" <?= $data['jurusan']=="Teknik Komputer Jaringan"?"selected":"" ?>>Teknik Komputer Jaringan</option>
                <option value="Desain Produksi Busana" <?= $data['jurusan']=="Desain Produksi Busana"?"selected":"" ?>>Desain Produksi Busana</option>
                <option value="Kuliner" <?= $data['jurusan']=="Kuliner"?"selected":"" ?>>Kuliner</option>
                <option value="Teknik Kendaraan Ringan" <?= $data['jurusan']=="Teknik Kendaraan Ringan"?"selected":"" ?>>Teknik Kendaraan Ringan</option>
                <option value="Teknik Sepeda Motor" <?= $data['jurusan']=="Teknik Sepeda Motor"?"selected":"" ?>>Teknik Sepeda Motor</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="kelola_guru.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include "template/footer.php"; ?>
