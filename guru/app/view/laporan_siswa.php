<?php
session_name("guru_session");
session_start();
require_once '../../Config/database.php';

if (!isset($_SESSION['guru_id'])) {
    die("Guru belum login.");
}

$id_guru = $_SESSION['guru_id'];

$sql = "
    SELECT l.id, l.judul, l.file, l.tanggal_upload,
           s.nama, s.email
    FROM laporan l
    INNER JOIN datasiswa s ON l.id_siswa = s.id
    INNER JOIN bimbingan b ON l.id_siswa = b.id_siswa
    WHERE b.id_guru = ?
    ORDER BY l.tanggal_upload DESC
";


$stmt = $koneksi->prepare($sql);   // ✅ pakai $koneksi
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$result = $stmt->get_result();

// Template
include "template/header.php";
include "template/sidebar.php";
?>




<div class="container-fluid px-4">
    <h3 class="mt-4">Daftar Laporan PKL Siswa Bimbingan</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Bimbingan / Laporan Siswa</li>
    </ol>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-file-alt me-1"></i> Laporan PKL
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Judul Laporan</th>
                            <th>Link File</th>
                            <th style="width: 20%">Tanggal Upload</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><?= htmlspecialchars($row['judul']); ?></td>
                                    <td>
                                        <?php if (!empty($row['file'])): ?>
                                            <a href="<?= htmlspecialchars($row['file']); ?>" target="_blank" 
                                               class="btn btn-sm btn-success">
                                                <i class="fas fa-eye"></i> Lihat Laporan
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Belum ada link</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date("d-m-Y H:i", strtotime($row['tanggal_upload'])); ?></td>
                                </tr>
                        <?php } 
                        } else { ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada laporan dikirim</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>
