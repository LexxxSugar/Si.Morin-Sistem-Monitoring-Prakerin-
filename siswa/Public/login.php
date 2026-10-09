<?php
session_name("siswa_session");
session_start();
require_once "../config/database.php";

if (isset($_SESSION['siswa_login']) && $_SESSION['siswa_login'] === true) {
    header("Location: ../App/Views/dashboard.php");
    exit;
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Ambil data siswa berdasarkan email
    $stmt = $conn->prepare("SELECT id, nama, email, password FROM datasiswa WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $siswa = $result->fetch_assoc();

    if ($siswa) {
        // Sesuaikan hash password (kalau masih md5 -> ubah ke md5($password))
        if (password_verify($password, $siswa['password'])) {
            $_SESSION['siswa_login'] = true;
            $_SESSION['id_siswa'] = $siswa['id'];
            $_SESSION['siswa_email'] = $siswa['email'];
            $_SESSION['siswa_nama'] = $siswa['nama'];

            header("Location: ../App/Views/dashboard.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>

<!-- Form login -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow p-4">
                <h4 class="text-center mb-4">Login Siswa</h4>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
