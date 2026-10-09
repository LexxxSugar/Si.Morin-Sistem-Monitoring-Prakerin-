<?php
session_name("admin_session");
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';

// Create
if (isset($_POST['create'])) {
    $stmt = $koneksi->prepare("INSERT INTO admin (nama, email, password) VALUES (?, ?, ?)");
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt->bind_param("sss", $_POST['nama'], $_POST['email'], $hashedPassword);
    $stmt->execute();
    header("Location: kelola_admin.php");
    exit();
}

// Update
if (isset($_POST['update'])) {
    if (!empty($_POST['password'])) {
        $stmt = $koneksi->prepare("UPDATE admin SET nama=?, email=?, password=? WHERE id=?");
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("sssi", $_POST['nama'], $_POST['email'], $hashedPassword, $_POST['id']);
    } else {
        $stmt = $koneksi->prepare("UPDATE admin SET nama=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $_POST['nama'], $_POST['email'], $_POST['id']);
    }
    $stmt->execute();
    header("Location: kelola_admin.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $stmt = $koneksi->prepare("DELETE FROM admin WHERE id=?");
    $stmt->bind_param("i", $_GET['delete']);
    $stmt->execute();
    header("Location: kelola_admin.php");
    exit();
}

// Data
$result = $koneksi->query("SELECT * FROM admin");
include 'template/header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Admin</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Admin</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalEdit<?= $row['id'] ?>">Edit</button>
                    <a href="?delete=<?= $row['id'] ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Hapus admin ini?')">Hapus</a>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Admin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password (kosongkan jika tidak diubah)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="create" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include "template/footer.php"; ?>