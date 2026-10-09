<?php
session_name("admin_session");
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}

$jurusanList = ["Rekayasa Perangkat Lunak", "Teknik Komputer Jaringan", "Desain Produksi Busana", "Kuliner", "Teknik Kendaraan Ringan", "Teknik Sepeda Motor"];
$tahunList = range(date('Y') - 3, date('Y') + 1); // Tahun dari 3 tahun lalu hingga 1 tahun ke depan
?>

<?php include 'template/header.php'; ?>

<div class="container mt-5">
    <h2>Tambah Siswa</h2>
    <form method="POST" action="../controller/SimpanSiswa.php">
        <div class="form-group">
            <label for="nis">NIS</label>
            <input type="text" class="form-control" name="nis" required>
        </div>

        <div class="form-group mt-3">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" required>
        </div>

        <div class="form-group mt-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="form-group mt-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="form-group mt-3">
            <label for="jurusan">Jurusan</label>
            <select class="form-control" name="jurusan" required>
                <option value="">-- Pilih Jurusan --</option>
                <option value="Rekayasa Perangkat Lunak">Rekaya Perangkat Lunak (RPL)</option>
                <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan (TKJ)</option>
                <option value="Desain Produksi Busana">Desain Produksi Busana (DPB)</option>
                <option value="Kuliner">Kuliner (KLR)</option>
                <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan (TKR)</option>
                <option value="Teknik Sepeda Motor">Teknik Sepeda Motor (SPM)</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="kelas">Kelas</label>
            <select class="form-control" name="kelas" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="RPL 1">RPL 1</option>
                <option value="RPL 2">RPL 2</option>
                <option value="RPL 2">RPL 3</option>
                <option value="RPL 2">RPL 4</option>
                <option value="TKJ 1">TKJ 1</option>
                <option value="TKJ 2">TKJ 2</option>
                <option value="TKJ 2">TKJ 3</option>
                <option value="TKJ 2">TKJ 4</option>
                <option value="DPB 1">DPB 1</option>
                <option value="DPB 2">DPB 2</option>
                <option value="DPB 2">DPB 3</option>
                <option value="DPB 2">DPB 4</option>
                <option value="KLR 1">KLR 1</option>
                <option value="KLR 2">KLR 2</option>
                <option value="KLR 2">KLR 3</option>
                <option value="KLR 2">KLR 4</option>
                <option value="TKR 1">TKR 1</option>
                <option value="TKR 2">TKR 2</option>
                <option value="TKR 2">TKR 3</option>
                <option value="TKR 2">TKR 4</option>
                <option value="SPM 1">SPM 1</option>
                <option value="SPM 2">SPM 2</option>
                <option value="SPM 2">SPM 3</option>
                <option value="SPM 2">SPM 4</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="tahun_pkl">Tahun PKL</label>
            <input type="number" class="form-control" name="tahun_pkl" min="2020" max="2099" required>
        </div>

        <div class="form-group mt-3">
            <label for="semester_pkl">Semester PKL</label>
            <select class="form-control" name="semester_pkl" required>
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
    </form>
</div>

<?php include 'template/footer.php'; ?>
