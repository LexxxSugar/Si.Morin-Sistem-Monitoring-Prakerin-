<?php
session_name("siswa_session"); 
session_start();

if (!isset($_SESSION["id_siswa"])) {
    header("Location: ../../Public/login.php");
    exit();
}

require_once __DIR__ . "/../../Config/database.php";

$id_siswa = $_SESSION["id_siswa"];

// ambil pembimbing berdasarkan id_siswa
$query = "SELECT g.nama_guru, g.email AS email_guru 
          FROM dataguru g
          JOIN bimbingan b ON g.id_guru = b.id_guru
          WHERE b.id_siswa = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$pembimbing = $stmt->get_result()->fetch_assoc();

// ambil chat siswa berdasarkan id_siswa
$query = "SELECT * FROM chat_bimbingan WHERE id_siswa = ? ORDER BY waktu ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$chat_result = $stmt->get_result();
?>


<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<h3>Halaman Bimbingan</h3>

<?php if ($pembimbing): ?>
    <div class="card my-3">
        <div class="card-body">
            <p><strong>Pembimbing:</strong> <?= $pembimbing['nama_guru'] ?> (<?= $pembimbing['email_guru'] ?>)</p>
        </div>
    </div>

    <div class="border p-3 bg-light rounded" style="max-height: 300px; overflow-y: auto;">
        <?php while ($chat = $chat_result->fetch_assoc()): ?>
            <div class="mb-2">
                <strong><?= $chat['pengirim'] ?>:</strong> <?= htmlspecialchars($chat['pesan']) ?>
                <br><small class="text-muted"><?= $chat['waktu'] ?></small>
            </div>
        <?php endwhile; ?>
    </div>

    <form action="../Controllers/kirim_bimbingan.php" method="POST" class="mt-3">
        <textarea name="pesan" class="form-control" required></textarea>
        <input type="hidden" name="email_siswa" value="<?= $email ?>">
        <input type="hidden" name="pengirim" value="Siswa">
        <button type="submit" class="btn btn-primary mt-2">Kirim</button>
    </form>
<?php else: ?>
    <div class="alert alert-warning">Anda belum memiliki pembimbing.</div>
<?php endif; ?>

<?php include 'template/footer.php'; ?>
