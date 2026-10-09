<?php
include '../../config/database.php';
session_start();

// Ambil jurusan guru dari session
$jurusan = $_SESSION['jurusan'] ?? '';

if (!$jurusan) {
    die("Jurusan tidak ditemukan di session. Silakan login ulang.");
}

// Query data siswa sesuai jurusan
$query = mysqli_query($koneksi, "SELECT * FROM datasiswa WHERE jurusan = '$jurusan'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa untuk Penilaian</title>
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

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .back-btn {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            background-color: #333;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<h2>Daftar Siswa untuk Penilaian</h2>
<table>
  <tr>
    <th>No</th>
    <th>Nama Siswa</th>
    <th>Kelas</th>
    <th>Aksi</th>
  </tr>

  <?php
  $no = 1;
  while ($siswa = mysqli_fetch_assoc($query)) {
      echo "<tr>
          <td>{$no}</td>
          <td>{$siswa['nama']}</td>
          <td>{$siswa['jurusan']}</td>
          <td>
              <a class='btn' href='isi-nilai.php?id_siswa={$siswa['id']}'>Isi Nilai</a>
          </td>
      </tr>";
      $no++;
  }
  ?>
</table>

<a href="dashboard.php" class="back-btn">← Kembali ke Dashboard</a>

</body>
</html>
