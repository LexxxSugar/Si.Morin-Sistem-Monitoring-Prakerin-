<?php
session_name("guru_session");
session_start();

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak.");
}

require_once '../../Config/database.php';
$email_guru = $_SESSION['guru_email'];

// Ambil id guru dari email login
$stmt = $koneksi->prepare("SELECT id_guru FROM dataguru WHERE email = ?");
$stmt->bind_param("s", $email_guru);
$stmt->execute();
$id_guru = $stmt->get_result()->fetch_assoc()['id_guru'] ?? 0;

$filter_nama = $_GET['nama'] ?? '';
$filter_tanggal = $_GET['tanggal'] ?? '';

// Query filter (pakai id_siswa)
$query = "SELECT j.*, s.nama 
          FROM jurnal j
          JOIN datasiswa s ON j.id_siswa = s.id
          JOIN bimbingan b ON s.id = b.id_siswa
          WHERE b.id_guru = ?";
$params = [$id_guru];
$types = "i";

if ($filter_nama) {
    $query .= " AND s.nama LIKE ?";
    $params[] = "%$filter_nama%";
    $types .= "s";
}
if ($filter_tanggal) {
    $query .= " AND j.tanggal = ?";
    $params[] = $filter_tanggal;
    $types .= "s";
}

$query .= " ORDER BY j.tanggal DESC, j.waktu DESC";

$stmt = $koneksi->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>


<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
  <h3 class="mb-4">Jurnal Kegiatan Siswa</h3>

  <form class="row g-3 mb-4" method="GET">
    <div class="col-md-4">
      <label class="form-label">Filter Nama Siswa</label>
      <input type="text" name="nama" class="form-control" placeholder="Cari nama siswa..." value="<?= htmlspecialchars($filter_nama) ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Filter Tanggal</label>
      <input type="date" name="tanggal" value="<?= htmlspecialchars($filter_tanggal) ?>" class="form-control">
    </div>
    <div class="col-md-4 d-flex align-items-end">
      <button class="btn btn-primary me-2" type="submit">Terapkan Filter</button>
      <a href="<?= basename(__FILE__) ?>" class="btn btn-secondary">Reset</a>
    </div>
  </form>

  <?php if ($result->num_rows > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Nama Siswa</th>
          <th>Tanggal</th>
          <th>Waktu</th>
          <th>Kegiatan</th>
          <th>Catatan</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['tanggal']) ?></td>
          <td><?= htmlspecialchars($row['waktu']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['kegiatan'])) ?></td>
          <td><?= nl2br(htmlspecialchars($row['catatan'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <div class="alert alert-info">Tidak ditemukan jurnal sesuai filter.</div>
  <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>
