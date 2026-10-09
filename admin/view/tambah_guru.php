<?php
session_name("admin_session");
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}
include "template/header.php";
?>

<div class="container mt-4">
    <h3>Tambah Guru</h3>
    <form action="../controller/SimpanGuru.php" method="POST" class="p-4 bg-light rounded shadow-sm">
        <div class="mb-3">
            <label>Nama Guru</label>
            <input type="text" name="nama_guru" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jurusan</label>
            <select name="jurusan" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                <option value="Desain Produksi Busana">Desain Produksi Busana</option>
                <option value="Kuliner">Kuliner</option>
                <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
                <option value="Teknik Sepeda Motor">Teknik Sepeda Motor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="kelola_guru.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include "template/footer.php"; ?>
