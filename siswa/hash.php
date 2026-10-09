<?php
require_once "Config/database.php"; // Sesuaikan path dengan file koneksi database

$query = "SELECT id, password FROM datasiswa";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $hashedPassword = password_hash($row["password"], PASSWORD_DEFAULT);
    $updateQuery = "UPDATE datasiswa SET password = '$hashedPassword' WHERE id = " . $row["id"];
    $conn->query($updateQuery);
}

echo "Semua password berhasil di-hash!";
?>
