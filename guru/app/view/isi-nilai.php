<?php
include '../../config/database.php';
session_start();

$id_siswa = $_GET['id_siswa'] ?? null;

if (!$id_siswa) {
    die("ID Siswa tidak ditemukan.");
}

$query = mysqli_query($koneksi, "SELECT * FROM datasiswa WHERE id = '$id_siswa'");
$data_siswa = mysqli_fetch_assoc($query);

if (!$data_siswa) {
    die("Data siswa tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Nilai Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #4CAF50;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Input Nilai untuk <?= htmlspecialchars($data_siswa['nama']) ?></h2>

<form action="proses-nilai.php" method="POST">
  <input type="hidden" name="id_siswa" value="<?= htmlspecialchars($data_siswa['id']) ?>">
  
  <label>Nilai Aspek 1:</label>
  <input type="number" name="aspek1" required>

  <label>Nilai Aspek 2:</label>
  <input type="number" name="aspek2" required>

  <label>Nilai Aspek 3:</label>
  <input type="number" name="aspek3" required>

  <label>Nilai Aspek 4:</label>
  <input type="number" name="aspek4" required>

  <label>Komentar:</label>
  <input type="text" name="komentar" required>
  
  <button type="submit">Simpan Nilai</button>
  <div class="form-group">      
</div>
</form>
<form action="proses-nilai.php" method="POST">
    <div class="form-group">
    <button type="submit">Simpan</button>
</form>

<a class="back-link" href="penilaian-tkrs.php">← Kembali ke Daftar Siswa</a>

</body>
</html>
