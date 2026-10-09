<?php
session_name("guru_session");
session_start();

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak. Silakan login sebagai guru.");
}

$email_guru = $_SESSION['guru_email'];
require_once '../../Config/database.php';

// ambil id_guru berdasarkan email login
$stmt = $koneksi->prepare("SELECT id_guru FROM dataguru WHERE email = ?");
$stmt->bind_param("s", $email_guru);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();
$id_guru = $data['id_guru'] ?? 0;

// ambil siswa bimbingan berdasarkan id_siswa, bukan email
$stmt = $koneksi->prepare("
    SELECT s.id, s.nama, s.email, s.jurusan 
    FROM bimbingan b 
    JOIN datasiswa s ON b.id_siswa = s.id 
    WHERE b.id_guru = ?
");
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$siswa = $stmt->get_result();
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
  <h3 class="mb-4">Daftar Siswa Bimbingan</h3>
  <?php if ($siswa->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($s = $siswa->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($s['nama']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= htmlspecialchars($s['jurusan']) ?></td>
            <td>
              <a href="bimbingan_detail.php?id_siswa=<?= $s['id'] ?>" 
                 class="btn btn-sm btn-primary">
                 Lihat Chat
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">Belum ada siswa yang memilih Anda sebagai pembimbing.</div>
  <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>
