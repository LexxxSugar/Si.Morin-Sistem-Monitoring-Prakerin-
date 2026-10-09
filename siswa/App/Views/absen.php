<?php
session_name("siswa_session"); 
session_start();

if (!isset($_SESSION["id_siswa"])) {
    header("Location: ../../Public/login.php");
    exit();
}

require_once __DIR__ . "/../../Config/database.php";

$id_siswa = $_SESSION["id_siswa"];
$tanggal = date("Y-m-d");

// cek apakah sudah absen hari ini
$query = "SELECT valid FROM absen WHERE id_siswa = ? AND tanggal = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $id_siswa, $tanggal); // i = int, s = string
$stmt->execute();
$result = $stmt->get_result();

$sudah_absen = $result->num_rows > 0;
$valid_status = null;

if ($sudah_absen) {
    $data_absen = $result->fetch_assoc();
    $valid_status = $data_absen['valid'];
}
?>


<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
  <h3 class="mb-3">Absensi Kehadiran</h3>

  <?php if (isset($_GET['status'])): ?>
    <div class="alert mt-3 
        <?= $_GET['status'] === 'sukses' ? 'alert-success' : 
            ($_GET['status'] === 'gagal' ? 'alert-danger' : 
            ($_GET['status'] === 'valid' ? 'alert-success' : 'alert-warning')) ?>">
        <?= $_GET['status'] === 'sukses' ? 'Berhasil absen!' :
            ($_GET['status'] === 'gagal' ? 'Gagal menyimpan absen!' :
            ($_GET['status'] === 'valid' ? 'Absensi Anda hari ini sudah tervalidasi oleh guru.' : 'Anda sudah absen, menunggu validasi guru.')) ?>
    </div>
  <?php endif; ?>

  <?php if ($sudah_absen): ?>
    <div class="alert <?= $valid_status ? 'alert-success' : 'alert-warning' ?> mt-4">
        Anda sudah absen hari ini.
        <?= $valid_status ? 'Absensi Anda telah divalidasi oleh guru.' : 'Menunggu validasi dari guru.' ?>
    </div>
  <?php else: ?>
    <form action="../Controllers/proses_absen.php" method="POST" class="mt-4">
    <input type="hidden" name="id_siswa" value="<?= (int)$id_siswa ?>">
    <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
    <button type="submit" class="btn btn-success">Absen Hari Ini</button>
</form>

  <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>
