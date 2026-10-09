<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) : '[Si.Morin] Dashboard Admin' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            height: 100vh; background-color: #343a40; color: white; padding: 20px;
        }
        .sidebar h4 { color: #fff; margin-bottom: 30px; text-align: center; }
        .sidebar a {
            color: #fff; text-decoration: none; display: block; padding: 10px; border-radius: 4px;
        }
        .sidebar a:hover, .sidebar a.active { background-color: #495057; }
        .content { padding: 20px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <h4>Admin Panel</h4>
            <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
            <a href="kelola_siswa.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kelola_siswa.php' ? 'active' : '' ?>">Kelola Siswa</a>
            <a href="kelola_guru.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kelola_guru.php' ? 'active' : '' ?>">Kelola Guru</a>
            <a href="kelola_admin.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kelola_admin.php' ? 'active' : '' ?>">Kelola Admin</a>
            <a href="kelola_bimbingan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kelola_bimbingan.php' ? 'active' : '' ?>">Kelola Bimbingan</a>
            <a href="mitra.php" class="<?= basename($_SERVER['PHP_SELF']) == 'mitra.php' ? 'active' : '' ?>">Mitra Sekolah</a>
            <a href="flowchart.php" class="<?= basename($_SERVER['PHP_SELF']) == 'flowchart.php' ? 'active' : '' ?>">FlowChart Siswa</a>
            <a href="../controller/Logout.php" class="text-danger">Logout</a>
        </div>
        <!-- Content -->
        <div class="col-md-10 content">
