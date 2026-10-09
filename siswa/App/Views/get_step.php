<?php
require_once "../config/database.php";

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM flow_proses_pkl WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

echo json_encode($res);
