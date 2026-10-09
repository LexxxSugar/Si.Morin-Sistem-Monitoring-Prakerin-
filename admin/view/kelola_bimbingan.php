<?php
session_name("admin_session");
session_start();
require_once "../config/database.php";

// Cek login admin
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}

// Proses hapus siswa dari bimbingan
if (isset($_GET['hapus'])) {
    $id_bimbingan = intval($_GET['hapus']);
    $sql = "DELETE FROM bimbingan WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_bimbingan);
    if ($stmt->execute()) {
        echo "<script>alert('Siswa berhasil dikeluarkan dari bimbingan.'); window.location='kelola_bimbingan.php?id_guru=".(int)($_GET['id_guru'] ?? 0)."';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }
}

// Ambil daftar guru
$guruQuery = $koneksi->query("SELECT id_guru, nama_guru, jurusan FROM dataguru ORDER BY nama_guru ASC");
$guruList = $guruQuery->fetch_all(MYSQLI_ASSOC);

// Pilih guru
$id_guru = $_GET['id_guru'] ?? null;

include "template/header.php";
?>

<div class="container-fluid">
    <h3 class="mt-4 mb-4">👨‍🏫 Kelola Bimbingan</h3>

    <!-- Dropdown pilih guru -->
    <form method="get" class="mb-4">
        <label><strong>Pilih Guru:</strong></label>
        <select name="id_guru" class="form-select w-50 d-inline" onchange="this.form.submit()">
            <option value="">-- Pilih Guru --</option>
            <?php foreach ($guruList as $g) { ?>
                <option value="<?= $g['id_guru']; ?>" <?= ($id_guru == $g['id_guru']) ? 'selected' : ''; ?>>
                    <?= $g['nama_guru']; ?> (<?= $g['jurusan']; ?>)
                </option>
            <?php } ?>
        </select>
    </form>

    <?php if ($id_guru) { 
        // Ambil siswa bimbingan (pakai id_siswa)
        $sql = "SELECT b.id, s.nama, s.email, s.nis, s.jurusan 
                FROM bimbingan b
                INNER JOIN datasiswa s ON b.id_siswa = s.id
                WHERE b.id_guru = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $id_guru);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Siswa Bimbingan</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIS</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['nis']); ?></td>
                                <td><?= htmlspecialchars($row['jurusan']); ?></td>
                                <td class="text-center">
                                    <a href="kelola_bimbingan.php?id_guru=<?= $id_guru; ?>&hapus=<?= $row['id']; ?>" 
                                       onclick="return confirm('Yakin ingin mengeluarkan siswa ini dari bimbingan?')" 
                                       class="btn btn-sm btn-danger">
                                       ❌ Keluarkan
                                    </a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada siswa bimbingan untuk guru ini.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
</div>

<?php include "template/footer.php"; ?>
