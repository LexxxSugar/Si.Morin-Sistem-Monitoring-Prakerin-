<?php
session_name("admin_session");
session_start();

// Proteksi admin
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}

require_once dirname(__DIR__) . "/config/database.php";
$result = $koneksi->query("SELECT * FROM dataguru ORDER BY nama_guru ASC");

// Judul halaman
$title = "Kelola Guru";
include "template/header.php";
?>

<h2 class="mb-4">Kelola Guru</h2>

<a href="tambah_guru.php" class="btn btn-primary mb-3">+ Tambah Guru</a>

<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'sukses'): ?>
        <div class="alert alert-success">Data guru berhasil disimpan!</div>
    <?php elseif ($_GET['status'] === 'update_sukses'): ?>
        <div class="alert alert-success">Data guru berhasil diperbarui!</div>
    <?php elseif ($_GET['status'] === 'hapus_sukses'): ?>
        <div class="alert alert-danger">Data guru berhasil dihapus!</div>
    <?php elseif ($_GET['status'] === 'duplikat'): ?>
        <div class="alert alert-warning">Email sudah terdaftar!</div>
    <?php else: ?>
        <div class="alert alert-warning">Terjadi kesalahan.</div>
    <?php endif; ?>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Email</th>
                <th>Jurusan</th>
                <th width="150px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <?php $idg = (int)$row['id_guru']; ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="edit_guru.php?id=<?php echo $idg; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="../controller/HapusGuru.php?id=<?php echo $idg; ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data guru.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "template/footer.php"; ?>
