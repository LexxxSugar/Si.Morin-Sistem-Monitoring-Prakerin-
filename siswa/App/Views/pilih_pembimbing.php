<?php
session_name("siswa_session");
session_start();

if (!isset($_SESSION["id_siswa"])) {
    header("Location: ../../Public/login.php");
    exit();
}

require_once '../../Config/database.php';

$id_siswa = $_SESSION['id_siswa'];

$cek = $conn->prepare("SELECT * FROM bimbingan WHERE id_siswa = ?");
$cek->bind_param("i", $id_siswa);
$cek->execute();
$cek_result = $cek->get_result();

$sudah_pilih = $cek_result->num_rows > 0;

// ambil semua data guru + total bimbingannya
$query = "
    SELECT g.id_guru, g.nama_guru, g.email, g.jurusan, 
    (SELECT COUNT(*) FROM bimbingan b WHERE b.id_guru = g.id_guru) AS total_bimbingan
    FROM dataguru g
";
$guru_result = $conn->query($query);
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container my-4">
    <h4 class="mb-4">Pilih Pembimbing</h4>

    <?php if ($sudah_pilih): ?>
        <div class="alert alert-info">Anda sudah memilih pembimbing. Anda hanya bisa memilih satu pembimbing.</div>
    <?php endif; ?>

    <div class="row">
        <?php while ($guru = $guru_result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($guru['nama_guru']) ?></h5>
                        <p class="card-text">
                            <strong>Email:</strong> <?= htmlspecialchars($guru['email']) ?><br>
                            <strong>Jurusan:</strong> <?= htmlspecialchars($guru['jurusan']) ?><br>
                            <strong>Total Dibimbing:</strong> <?= $guru['total_bimbingan'] ?> siswa
                        </p>
                        <?php if (!$sudah_pilih && $guru['total_bimbingan'] < 10): ?>
                            <form method="POST" action="../Controllers/simpan_pembimbing.php">
                                <input type="hidden" name="id_guru" value="<?= $guru['id_guru'] ?>">
                                <button type="submit" class="btn btn-primary w-100">Pilih Pembimbing</button>
                            </form>
                        <?php elseif ($guru['total_bimbingan'] >= 10): ?>
                            <div class="alert alert-warning p-2 mt-2 text-center">Kuota penuh</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'template/footer.php'; ?>
