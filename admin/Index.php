<?php
include './config/database.php';

$controller = $_GET['controller'] ?? 'guru';
$action = $_GET['action'] ?? 'index';

if ($controller == 'guru') {
    include './controller/GuruController.php';
    $ctrl = new GuruController($koneksi);
} elseif ($controller == 'siswa') {
    include './controller/SiswaController.php';
    $ctrl = new SiswaController($koneksi);
}

if ($action == 'index') $ctrl->index();
elseif ($action == 'create') $ctrl->create();
elseif ($action == 'store') $ctrl->store($_POST);
elseif ($action == 'edit') $ctrl->edit($_GET['id']);
elseif ($action == 'update') $ctrl->update($_GET['id'], $_POST);
elseif ($action == 'delete') $ctrl->delete($_GET['id']);
?>
