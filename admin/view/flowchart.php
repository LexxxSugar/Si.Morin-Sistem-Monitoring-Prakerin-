<?php
session_name("admin_session");
session_start();
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<?php
require_once "../config/database.php";
include "template/header.php";   // header template

$result = $koneksi->query("SELECT * FROM flowchart_pkl ORDER BY id ASC");

// proses update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $label = $_POST['label'];

    $stmt = $koneksi->prepare("UPDATE flowchart_pkl SET label=? WHERE id=?");
    $stmt->bind_param("si", $label, $id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Data berhasil disimpan!'); window.location='flowchart.php';</script>";
        exit;
    } else {
        echo "<script>alert('❌ Gagal menyimpan: " . $stmt->error . "'); window.location='flowchart.php';</script>";
        exit;
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fas fa-project-diagram"></i> Kelola Flowchart PKL</h1>
    </section>

    <section class="content">
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6">
                    <div class="card flow-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-stream"></i> <?php echo $row['id']; ?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <textarea name="label" class="form-control mb-2" rows="4"><?php echo htmlspecialchars($row['label']); ?></textarea>
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="update" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</div>

<?php include "template/footer.php"; ?>

<!-- CSS tambahan -->
<style>
    .flow-card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        margin-bottom: 20px;
    }
    .flow-card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    textarea.form-control {
        border-radius: 8px;
        resize: vertical;
        transition: 0.3s;
    }
    textarea.form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 6px rgba(0,123,255,0.5);
    }
    .btn-primary {
        border-radius: 8px;
        transition: background 0.3s, transform 0.2s;
    }
    .btn-primary:hover {
        background: #0056b3;
        transform: scale(1.05);
    }
</style>
