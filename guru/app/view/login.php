<?php
session_name("guru_session");
session_start();
require_once '../../Config/database.php';

$error = null;

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password_input = $_POST['password'];

    // Ambil data guru berdasarkan email
    $stmt = $koneksi->prepare("SELECT * FROM dataguru WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $hash_db = $row['password'];

        // ✅ Jika hash sudah bcrypt
        if (password_verify($password_input, $hash_db)) {
            $_SESSION['guru_login'] = true;
            $_SESSION['guru_id']    = $row['id_guru'];   // simpan id_guru
            $_SESSION['guru_email'] = $row['email'];
            $_SESSION['guru_nama']  = $row['nama_guru']; // opsional
            header("Location: dashboard.php");
            exit;

        // ✅ Jika masih pakai MD5 lama
        } elseif ($hash_db === md5($password_input)) {
            // Upgrade ke bcrypt otomatis
            $new_hash = password_hash($password_input, PASSWORD_BCRYPT);
            $stmt_update = $koneksi->prepare("UPDATE dataguru SET password=? WHERE id_guru=?");
            $stmt_update->bind_param("si", $new_hash, $row['id_guru']);
            $stmt_update->execute();

            $_SESSION['guru_login'] = true;
            $_SESSION['guru_id']    = $row['id_guru'];   // simpan id_guru
            $_SESSION['guru_email'] = $row['email'];
            $_SESSION['guru_nama']  = $row['nama_guru']; // opsional
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "❌ Login gagal. Password salah.";
        }
    } else {
        $error = "❌ Email tidak ditemukan.";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card shadow-lg p-4">
                    <h4 class="text-center mb-4">Login Guru</h4>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
