<?php
session_name("guru_session");
session_start();

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak. Silakan login sebagai guru.");
}

require_once '../../Config/database.php';
$email_guru = $_SESSION['guru_email'];

// Ambil id_guru
$stmt = $koneksi->prepare("SELECT id_guru FROM dataguru WHERE email = ?");
$stmt->bind_param("s", $email_guru);
$stmt->execute();
$res = $stmt->get_result();
$id_guru = $res->fetch_assoc()['id_guru'] ?? 0;

// Ambil daftar siswa bimbingan dan nilai jika ada
$query = "SELECT s.nama, s.email, s.jurusan, 
                 p.aspek_1, p.aspek_2, p.aspek_3, p.aspek_4, p.rata_rata, p.komentar,
                 s.id as id_siswa
          FROM bimbingan b
          JOIN datasiswa s ON b.id_siswa = s.id
          LEFT JOIN penilaian_pkl p ON s.id = p.id_siswa
          WHERE b.id_guru = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
  <h3 class="mb-4">Penilaian Siswa</h3>
  <?php if ($result->num_rows > 0): ?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Jurusan</th>
          <th>Aspek 1</th>
          <th>Aspek 2</th>
          <th>Aspek 3</th>
          <th>Aspek 4</th>
          <th>Rata-rata</th>
          <th>Komentar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($s = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($s['nama']) ?></td>
          <td><?= htmlspecialchars($s['email']) ?></td>
          <td><?= htmlspecialchars($s['jurusan']) ?></td>
          <td><?= $s['aspek_1'] ?? '-' ?></td>
          <td><?= $s['aspek_2'] ?? '-' ?></td>
          <td><?= $s['aspek_3'] ?? '-' ?></td>
          <td><?= $s['aspek_4'] ?? '-' ?></td>
          <td><?= $s['rata_rata'] ?? '-' ?></td>
          <td><?= $s['komentar'] ?? '-' ?></td>
          <td>
            <a href="form_nilai.php?id_siswa=<?= $s['id_siswa'] ?>" class="btn btn-sm btn-primary">Beri/Edit Nilai</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <div class="alert alert-warning">Belum ada siswa yang dibimbing.</div>
  <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>
