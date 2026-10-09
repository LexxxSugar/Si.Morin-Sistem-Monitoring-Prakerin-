<?php
session_name("admin_session");
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}

require_once dirname(__DIR__) . "/config/database.php";

$jurusanList = ["Rekayasa Perangkat Lunak", "Teknik Komputer Jaringan", "Desain Produksi Busana", "Kuliner", "Teknik Kendaraan Ringan", "Teknik Sepeda Motor"];
$tahunList = range(date('Y') - 3, date('Y') + 1); // Tahun dari 3 tahun lalu hingga 1 tahun ke depan

$id = $_GET['id'] ?? 0;
if ($id == 0) {
    header("Location: kelola_siswa.php?status=gagal");
    exit();
}

$stmt = $koneksi->prepare("SELECT * FROM datasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) {
    header("Location: kelola_siswa.php?status=gagal");
    exit();
}
?>

<?php include 'template/header.php'; ?>

<div class="container mt-4">
    <h3>Edit Siswa</h3>
    <form action="../controller/UpdateSiswa.php" method="POST" class="p-4 bg-light rounded shadow-sm">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        
        <div class="mb-3">
            <label>NIS</label>
            <input type="text" name="nis" class="form-control" value="<?= htmlspecialchars($data['nis']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Password (Kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Jurusan</label>
            <select name="jurusan" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($jurusanList as $j): ?>
                    <option value="<?= $j ?>" <?= $data['jurusan'] == $j ? 'selected' : '' ?>><?= $j ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
    <label>Kelas</label>
    <select class="form-control" name="kelas" required>
        <option value="">-- Pilih Kelas --</option>
        <?php
        $kelasList = ["RPL 1", "RPL 2", "RPL 3", "RPL 4", "TKJ 1", "TKJ 2", "TKJ 3", "TKJ 4", 
                      "DPB 1", "DPB 2", "DPB 3", "DPB 4", "KLR 1", "KLR 2", "KLR 3", "KLR 4", 
                      "TKR 1", "TKR 2", "TKR 3", "TKR 4", "SPM 1", "SPM 2", "SPM 3", "SPM 4"];
        $kelasDipilih = $data['kelas'] ?? '';
        foreach ($kelasList as $kelas) {
            $selected = ($kelasDipilih == $kelas) ? 'selected' : '';
            echo "<option value=\"$kelas\" $selected>$kelas</option>";
        }
        ?>
    </select>
</div>


        <div class="mb-3">
            <label>Semester PKL</label>
            <select name="semester_pkl" class="form-select" required>
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil" <?= $data['semester_pkl'] == 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                <option value="Genap" <?= $data['semester_pkl'] == 'Genap' ? 'selected' : '' ?>>Genap</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tahun PKL</label>
            <select name="tahun_pkl" class="form-select" required>
                <option value="">-- Pilih Tahun --</option>
                <?php foreach ($tahunList as $tahun): ?>
                    <option value="<?= $tahun ?>" <?= ($data['tahun_pkl'] == $tahun) ? 'selected' : '' ?>><?= $tahun ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="kelola_siswa.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include 'template/footer.php'; ?>
