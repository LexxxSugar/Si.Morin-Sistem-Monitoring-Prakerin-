<?php
session_name("guru_session");
session_start();

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak. Silakan login sebagai guru.");
}

require_once '../../Config/database.php';
$email = $_SESSION['guru_email'];

// Ambil data guru (id dan nama)
$stmt = $koneksi->prepare("SELECT id_guru, nama_guru FROM dataguru WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id_guru, $nama_guru);
$stmt->fetch();
$stmt->close();

// Jumlah siswa bimbingan (langsung pakai id_siswa)
$stmt = $koneksi->prepare("SELECT COUNT(*) FROM bimbingan WHERE id_guru = ?");
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$stmt->bind_result($total_siswa);
$stmt->fetch();
$stmt->close();

// Jumlah jurnal siswa bimbingan
$stmt = $koneksi->prepare("
    SELECT COUNT(*) 
    FROM jurnal 
    WHERE id_siswa IN (SELECT id_siswa FROM bimbingan WHERE id_guru = ?)
");
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$stmt->bind_result($total_jurnal);
$stmt->fetch();
$stmt->close();

// Jumlah penilaian siswa bimbingan
$stmt = $koneksi->prepare("
    SELECT COUNT(*) 
    FROM penilaian_pkl 
    WHERE id_siswa IN (SELECT id_siswa FROM bimbingan WHERE id_guru = ?)
");
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$stmt->bind_result($total_nilai);
$stmt->fetch();
$stmt->close();
?>


<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
  <h3 class="mb-4">Selamat Datang, <?= htmlspecialchars($nama_guru) ?> 👋</h3>

  <div class="row">
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Jumlah Siswa Bimbingan</h5>
          <p class="card-text display-6"><?= $total_siswa ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Jurnal Dikirim</h5>
          <p class="card-text display-6"><?= $total_jurnal ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-info mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Penilaian</h5>
          <p class="card-text display-6"><?= $total_nilai ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm mt-4">
    <div class="card-header bg-secondary text-white">
      <strong>Petunjuk Singkat</strong>
    </div>
    <div class="card-body">
      <ul>
        <li>Lihat dan balas pesan siswa di menu <strong>Bimbingan</strong>.</li>
        <li>Beri nilai PKL siswa melalui menu <strong>Penilaian</strong>.</li>
        <li>Periksa jurnal kegiatan dan kehadiran siswa pada menu <strong>Jurnal</strong> dan <strong>Absen</strong>.</li>
      </ul>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
