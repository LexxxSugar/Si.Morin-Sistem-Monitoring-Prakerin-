<?php
session_start();

if (!isset($_SESSION["user_email"])) {
    header("Location: ../../Public/login.php");
    exit();
}

require_once __DIR__ . "/../../Config/database.php";

$email = $_SESSION["user_email"];
$query = "SELECT * FROM datasiswa WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data siswa tidak ditemukan.");
}

$jurusan = $data['jurusan'];
$id_siswa = $data['id']; // asumsi ada kolom id_siswa di tabel datasiswa

// Ambil nilai PKL dari tabel nilai_pkl (atau nama tabel nilai yang kamu punya)
$queryNilai = "SELECT aspek_1, aspek_2, aspek_3, aspek_4 FROM penilaian_pkl WHERE id_siswa = ?";
$stmtNilai = $conn->prepare($queryNilai);
$stmtNilai->bind_param("i", $id_siswa);
$stmtNilai->execute();
$resultNilai = $stmtNilai->get_result();
$dataNilai = $resultNilai->fetch_assoc();

if (!$dataNilai) {
    // Jika nilai belum ada, kamu bisa set nilai default kosong atau 0
    $dataNilai = [
        'nilai_aspek1' => '',
        'nilai_aspek2' => '',
        'nilai_aspek3' => '',
        'nilai_aspek4' => '',
    ];
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Penilaian PKL</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
    }
    h2 {
      text-align: center;
      text-transform: uppercase;
    }
    .info {
      margin-top: 30px;
      margin-bottom: 20px;
    }
    .info td {
      padding: 4px 10px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #000;
      padding: 10px;
      vertical-align: top;
    }
    th {
      background-color: #f0f0f0;
      text-align: center;
    }
    .center {
      text-align: center;
    }
    .footer {
      margin-top: 40px;
    }
    .footer-table {
      width: 100%;
      margin-top: 20px;
    }
    .footer-table td {
      padding-top: 50px;
      text-align: center;
    }
  </style>
</head>
<body>

  <h2>Daftar Nilai<br>Praktek Kerja Lapangan</h2>

<table class="info">
  <tr><td>Nama Siswa</td><td>: <?php echo htmlspecialchars($data['nama']); ?></td></tr>
  <tr><td>Kelas</td><td>: <?php echo htmlspecialchars($data['jurusan']); ?></td></tr>
  <tr><td>Konsentrasi Keahlian</td><td>: <?php echo htmlspecialchars($jurusan); ?></td></tr>
  <!-- dst -->
</table>

<table>
  <!-- header -->
  <tr>
    <td class="center">1</td>
    <td>Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat pkl)</td>
    <td class="center"><?php echo htmlspecialchars($dataNilai['aspek_1']); ?></td>
  </tr>
  <tr>
    <td class="center">2</td>
    <td>Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (melaksanakan perbaikan mesin, chasis, dan kelistrikan, serta pemecahan masalah di tempat pkl)</td>
    <td class="center"><?php echo htmlspecialchars($dataNilai['aspek_2']); ?></td>
  </tr>
  <tr>
    <td class="center">3</td>
    <td>Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL</td>
    <td class="center"><?php echo htmlspecialchars($dataNilai['aspek_3']); ?></td>
  </tr>
  <tr>
    <td class="center">4</td>
    <td>Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)</td>
    <td class="center"><?php echo htmlspecialchars($dataNilai['aspek_4']); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><strong>Nilai Rata-rata Aspek Penilaian</strong></td>
    <td class="center">
      <?php 
      $rata = 0;
      $count = 0;
      foreach ($dataNilai as $nilai) {
        if (is_numeric($nilai) && $nilai !== '') {
          $rata += $nilai;
          $count++;
        }
      }
      if ($count > 0) {
        echo number_format($rata / $count, 2);
      } else {
        echo '-';
      }
      ?>
    </td>
  </tr>
</table>

  </div>

</body>
</html>

