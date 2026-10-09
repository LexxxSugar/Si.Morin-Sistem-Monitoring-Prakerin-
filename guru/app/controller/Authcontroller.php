<?php
require_once 'models/User.php';
session_start();

class AuthController {
    public function loginPage() {
        include 'views/login.php';
    }

    public function login() {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = new User();
    $user = $userModel->login($email, $password);

    if ($user) {
        // Simpan data user di session
        $_SESSION['id_guru'] = $user['id_guru']; // tambahkan ini
        $_SESSION['email']   = $user['email'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['jurusan'] = $user['jurusan'];
        $_SESSION['role']    = 'guru'; // opsional, kalau nanti mau bedakan siswa/guru

        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Email atau password salah!";
        header("Location: index.php?page=login");
        exit();
    }
}


    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit();
    }
}
