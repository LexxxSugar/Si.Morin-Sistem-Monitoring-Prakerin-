<?php
session_name("siswa_session"); 
session_start();

if (!isset($_SESSION["id_siswa"])) {
    header("Location: ../../Public/login.php");
    exit();
}

require_once "../../config/database.php";

$error = null;
$success = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_siswa = (int)$_SESSION["id_siswa"];
    $judul = trim($_POST["judul"]);
    $link  = trim($_POST["linkFile"]);

    if (!empty($judul) && !empty($link)) {
        // Simpan link ke DB (kolom file diisi link)
        $stmt = $conn->prepare("INSERT INTO laporan (id_siswa, judul, file, tanggal_upload) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $id_siswa, $judul, $link);

        if ($stmt->execute()) {
            $success = "✅ Laporan berhasil dikirim!";
        } else {
            $error = "❌ Gagal menyimpan ke database: " . $stmt->error;
        }
    } else {
        $error = "⚠️ Judul dan Link tidak boleh kosong!";
    }
}
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
    <h3>Kirim Laporan (Link Cloud)</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Laporan</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Contoh: Laporan Minggu 1" required>
        </div>
        <div class="mb-3">
            <label for="linkFile" class="form-label">Link Laporan (Google Drive/OneDrive/Dropbox)</label>
            <input type="url" class="form-control" id="linkFile" name="linkFile" placeholder="https://drive.google.com/..." required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>

<?php include 'template/footer.php'; ?>
