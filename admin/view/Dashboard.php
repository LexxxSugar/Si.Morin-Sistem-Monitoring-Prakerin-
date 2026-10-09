<?php
session_name("admin_session");
session_start();
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<?php include 'template/header.php'; ?>

<div class="container mt-5">
    <h3>Selamat Datang, Admin</h3>
    <p>Email: <?= htmlspecialchars($_SESSION['admin_email']); ?></p>
    <a href="../controller/Logout.php" class="btn btn-danger">Logout</a>
</div>

<?php include 'template/footer.php'; ?>
