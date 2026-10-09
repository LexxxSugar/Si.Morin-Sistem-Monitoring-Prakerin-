<?php
session_name("siswa_session"); 
session_start();
require_once '../../Config/database.php';

$id_siswa = $_SESSION['id_siswa'];

// Cek apakah siswa sudah memilih mitra
$cek = $conn->prepare("SELECT m.* FROM lamaran pm JOIN mitra m ON pm.id_mitra = m.id WHERE pm.id_siswa = ?");
$cek->bind_param("i", $id_siswa);
$cek->execute();
$mitra_terpilih = $cek->get_result()->fetch_assoc();

// Ambil semua mitra
$mitra = $conn->query("SELECT * FROM mitra");
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container my-4">
    <h4 class="mb-4">Daftar Mitra PKL</h4>

    <?php if ($mitra_terpilih): ?>
        <div class="alert alert-success">
            <strong>Anda telah memilih mitra:</strong> <?= htmlspecialchars($mitra_terpilih['nama_perusahaan']) ?><br>
            <a href="https://drive.google.com/file/d/1EFn0cM4QIxLNWa3gQKCK1QGmuv8YRSSJ/view?usp=sharing" class="btn btn-sm btn-primary mt-2">Download Surat Pengantar PKL</a>
            <a href="https://drive.google.com/file/d/1u6gAx0Vn4CUjGxhxArNm18RJfFzL4IqZ/view?usp=sharing" class="btn btn-sm btn-primary mt-2">Download Surat Pengantar Balasan</a>

        </div>
    <?php endif; ?>

    <div class="row">
        <?php while ($m = $mitra->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5><?= htmlspecialchars($m['nama_perusahaan']) ?></h5>
                        <p><strong>Alamat:</strong> <?= htmlspecialchars($m['alamat']) ?><br>
                           <strong>Deskripsi:</strong> <?= htmlspecialchars($m['deskripsi']) ?><br>
                           <strong>Jurusan:</strong> <?= htmlspecialchars($m['jurusan']) ?></p>

                        <?php if (!$mitra_terpilih): ?>
                            <form method="POST" action="../Controllers/pilih_mitra.php">
                                <input type="hidden" name="id_mitra" value="<?= $m['id'] ?>">
                                <button class="btn btn-primary w-100">Pilih Mitra Ini</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'template/footer.php'; ?>
