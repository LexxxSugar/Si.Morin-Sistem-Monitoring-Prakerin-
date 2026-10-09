<?php
session_name("admin_session");
session_start();

// Proteksi admin
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}

require_once dirname(__DIR__) . "/config/database.php";

// Filter
$where = [];
$params = [];
$types = '';

if (!empty($_GET['kelas'])) {
    $where[] = "kelas = ?";
    $params[] = $_GET['kelas'];
    $types .= 's';
}
if (!empty($_GET['tahun_pkl'])) {
    $where[] = "tahun_pkl = ?";
    $params[] = $_GET['tahun_pkl'];
    $types .= 's';
}
if (!empty($_GET['semester_pkl'])) {
    $where[] = "semester_pkl = ?";
    $params[] = $_GET['semester_pkl'];
    $types .= 's';
}

$sql = "SELECT s.*, l.id_mitra 
        FROM datasiswa s
        LEFT JOIN lamaran l ON s.id = l.id_siswa";

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY s.nama ASC";



$stmt = $koneksi->prepare($sql);
if ($where) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

include 'template/header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Kelola Siswa</h2>

    <a href="tambah_siswa.php" class="btn btn-primary mb-3">+ Tambah Siswa</a>

<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'sukses'): ?>
        <div class="alert alert-success">Data siswa berhasil ditambahkan!</div>
    <?php elseif ($_GET['status'] === 'update_sukses'): ?>
        <div class="alert alert-success">Data siswa berhasil diperbarui!</div>
    <?php elseif ($_GET['status'] === 'hapus_sukses'): ?>
        <div class="alert alert-danger">Data siswa berhasil dihapus!</div>
    <?php elseif ($_GET['status'] === 'duplikat'): ?>
        <div class="alert alert-warning">Email sudah terdaftar!</div>
    <?php elseif ($_GET['status'] === 'keluar_sukses'): ?>
        <div class="alert alert-info">Siswa berhasil dikeluarkan dari mitra.</div>
    <?php elseif ($_GET['status'] === 'keluar_error'): ?>
        <div class="alert alert-danger">Gagal mengeluarkan siswa dari mitra.</div>
    <?php endif; ?>
<?php endif; ?>




    <!-- Filter -->
    <form method="GET" class="row mb-3 g-2">
        <div class="col-md-3">
            <select class="form-control" name="kelas">
    <option disabled <?= empty($_GET['kelas']) ? 'selected' : '' ?>>-- Pilih Kelas --</option>
    <option value="">-- Semua Kelas --</option>
    <?php
    $kelasList = ["RPL 1", "RPL 2", "RPL 3", "RPL 4", "TKJ 1", "TKJ 2", "TKJ 3", "TKJ 4",
                  "DPB 1", "DPB 2", "DPB 3", "DPB 4", "KLR 1", "KLR 2", "KLR 3", "KLR 4",
                  "TKR 1", "TKR 2", "TKR 3", "TKR 4", "SPM 1", "SPM 2", "SPM 3", "SPM 4"];
    $kelasDipilih = $_GET['kelas'] ?? '';
    foreach ($kelasList as $kelas) {
        $selected = ($kelasDipilih == $kelas) ? 'selected' : '';
        echo "<option value=\"$kelas\" $selected>$kelas</option>";
    }
    ?>
</select>


        </div>
        <div class="col-md-3">
            <select name="tahun_pkl" class="form-select">
                <option value="">-- Semua Tahun PKL --</option>
                <?php for ($th = date('Y') - 5; $th <= date('Y') + 1; $th++): ?>
                    <option value="<?= $th ?>" <?= (($_GET['tahun_pkl'] ?? '') == $th) ? 'selected' : '' ?>><?= $th ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="semester_pkl" class="form-select">
                <option value="">-- Semua Semester --</option>
                <option value="Ganjil" <?= (($_GET['semester_pkl'] ?? '') == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                <option value="Genap" <?= (($_GET['semester_pkl'] ?? '') == 'Genap') ? 'selected' : '' ?>>Genap</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Email</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Tahun PKL</th>
                    <th>Semester PKL</th>
                    <th width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['nis']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['jurusan']) ?></td>
                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                            <td><?= htmlspecialchars($row['tahun_pkl']) ?></td>
                            <td><?= htmlspecialchars($row['semester_pkl']) ?></td>
                            <td>
    <div class="d-flex gap-2">
        <a href="edit_siswa.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="../controller/HapusSiswa.php?id=<?= $row['id'] ?>"
           class="btn btn-sm btn-danger"
           onclick="return confirm('Yakin hapus data ini?')">Hapus</a>

        <?php if (!empty($row['id_mitra'])): ?>
    <a href="../controller/KeluarkanMitra.php?id=<?= $row['id'] ?>"
       class="btn btn-sm btn-outline-danger"
       onclick="return confirm('Yakin keluarkan siswa ini dari mitra?')">Keluarkan Mitra</a>
<?php endif; ?>

    </div>
</td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data siswa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'template/footer.php'; ?>
