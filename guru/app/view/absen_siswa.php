<?php
session_name("guru_session");
session_start();

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak.");
}

require_once '../../Config/database.php';
$email_guru = $_SESSION['guru_email'];

// Ambil id guru
$stmt = $koneksi->prepare("SELECT id_guru FROM dataguru WHERE email = ?");
$stmt->bind_param("s", $email_guru);
$stmt->execute();
$id_guru = $stmt->get_result()->fetch_assoc()['id_guru'] ?? 0;

// Tangani validasi jika ada permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['absen_id'])) {
    $absen_id = (int)$_POST['absen_id'];
    $valid = ($_POST['valid'] === '1') ? 1 : 0;

    $update = $koneksi->prepare("UPDATE absen SET valid = ? WHERE id = ?");
    $update->bind_param("ii", $valid, $absen_id);
    $update->execute();
}

// Ambil data absen siswa bimbingan
$query = "SELECT a.*, s.nama 
          FROM absen a
          JOIN datasiswa s ON a.id_siswa = s.id
          JOIN bimbingan b ON s.id = b.id_siswa
          WHERE b.id_guru = ?
          ORDER BY a.tanggal DESC, a.jam DESC";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$result = $stmt->get_result();
?>


<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
  <h3 class="mb-4">Riwayat Absensi Siswa</h3>

  <?php if ($result->num_rows > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Nama Siswa</th>
          <th>Tanggal</th>
          <th>Jam</th>
          <th>Status</th>
          <th>Validasi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['tanggal']) ?></td>
          <td><?= htmlspecialchars($row['jam']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
          <td>
            <form method="POST" class="d-flex">
              <input type="hidden" name="absen_id" value="<?= $row['id'] ?>">
              <select name="valid" class="form-select form-select-sm me-2">
                <option value="1" <?= $row['valid'] ? 'selected' : '' ?>>Valid</option>
                <option value="0" <?= !$row['valid'] ? 'selected' : '' ?>>Belum</option>
              </select>
              <button class="btn btn-sm btn-success">Simpan</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <div class="alert alert-info">Belum ada data absensi siswa.</div>
  <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>
