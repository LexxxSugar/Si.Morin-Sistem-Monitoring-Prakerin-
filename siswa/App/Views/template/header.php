<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : '[Si.Morin] Dashboard Siswa' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: #ddd;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a.active, .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Si.Morin</a>
        <div class="d-flex">
            <span class="navbar-text me-3">
                <?= isset($_SESSION['siswa_email']) ? $_SESSION['siswa_email'] : (isset($_SESSION['guru_email']) ? $_SESSION['guru_email'] : '') ?>
            </span>
            <a href="../../Public/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
  <div class="row">
