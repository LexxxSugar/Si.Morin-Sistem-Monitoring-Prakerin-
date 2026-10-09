<?php
session_name("guru_session");
session_start();
require_once "../../Config/database.php";

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak. Silakan login sebagai guru.");
}

$email_guru = $_SESSION['guru_email'];

// Ambil id_guru dari email session
$stmt = $koneksi->prepare("SELECT id_guru FROM dataguru WHERE email = ?");
$stmt->bind_param("s", $email_guru);
$stmt->execute();
$res = $stmt->get_result();
$id_guru = $res->fetch_assoc()['id_guru'] ?? 0;

// Ambil id_siswa dari query string
if (!isset($_GET['id_siswa'])) {
    die("ID siswa tidak ditemukan.");
}
$id_siswa = (int)$_GET['id_siswa'];

// Ambil nama siswa
$stmt = $koneksi->prepare("SELECT nama FROM datasiswa WHERE id = ?");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$siswa = $stmt->get_result()->fetch_assoc();
$nama_siswa = $siswa['nama'] ?? 'Siswa';

// Ambil riwayat chat
$stmt = $koneksi->prepare("SELECT * FROM chat_bimbingan WHERE id_siswa = ? ORDER BY waktu ASC");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$chat = $stmt->get_result();
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
  <h4 class="mb-4">Chat Bimbingan dengan Siswa: <strong><?= htmlspecialchars($nama_siswa) ?></strong></h4>

  <div class="chat-container mb-4 p-3 bg-light rounded shadow-sm" style="max-height: 500px; overflow-y: auto;">
    <?php while ($row = $chat->fetch_assoc()): ?>
      <?php if ($row['pengirim'] === 'guru'): ?>
        <div class="chat-right bg-primary text-white p-2 rounded mb-2" style="max-width: 70%; margin-left: auto;">
          <?= nl2br(htmlspecialchars($row['pesan'])) ?>
          <div class="chat-time small text-end"><?= date("H:i d/m", strtotime($row['waktu'])) ?></div>
        </div>
      <?php else: ?>
        <div class="chat-left bg-secondary-subtle text-dark p-2 rounded mb-2" style="max-width: 70%;">
          <?= nl2br(htmlspecialchars($row['pesan'])) ?>
          <div class="chat-time small text-start"><?= date("H:i d/m", strtotime($row['waktu'])) ?></div>
        </div>
      <?php endif; ?>
    <?php endwhile; ?>
  </div>

  <form method="POST" action="../Controller/balas_bimbingan.php">
    <div class="input-group">
      <input type="hidden" name="id_siswa" value="<?= $id_siswa ?>">
      <input type="hidden" name="pengirim" value="guru">
      <input type="text" name="pesan" class="form-control" placeholder="Ketik pesan..." required>
      <button type="submit" class="btn btn-primary">Kirim</button>
    </div>
  </form>

  <a href="daftar_bimbingan.php" class="btn btn-outline-secondary mt-4">← Kembali ke Daftar</a>
</div>

<?php include "template/footer.php"; ?>
