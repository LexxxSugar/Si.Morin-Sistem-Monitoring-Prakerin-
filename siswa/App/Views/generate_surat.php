<?php
session_name("siswa_session"); 
session_start();
require_once '../../Config/database.php';

if (!isset($_SESSION['id_siswa'])) {
    die("<h3 style='color:red;'>⚠️ Akses ditolak. Silakan login terlebih dahulu.</h3>");
}

$id_siswa = (int)$_SESSION['id_siswa'];

// Ambil data siswa
$stmt = $conn->prepare("SELECT nama, nis, jurusan, email FROM datasiswa WHERE id = ?");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$siswa = $stmt->get_result()->fetch_assoc();

// Ambil mitra yang dipilih siswa dari tabel lamaran
$stmt = $conn->prepare("
    SELECT m.nama_perusahaan, m.alamat 
    FROM lamaran pm 
    JOIN mitra m ON pm.id_mitra = m.id 
    WHERE pm.id_siswa = ?
");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$mitra = $stmt->get_result()->fetch_assoc();

if (!$mitra || !$siswa) {
    die("<h3 style='color:red;'>⚠️ Data siswa atau mitra tidak ditemukan.</h3>");
}

// Format tanggal Indonesia
setlocale(LC_TIME, 'id_ID.utf8');
$tanggal = strftime("%d %B %Y");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Surat Lamaran PKL</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 50px;
        }
        .tanda-tangan {
            margin-top: 50px;
            text-align: right;
        }
        .kop {
            text-align: center;
            font-size: 18px;
            margin-bottom: 40px;
        }
        .konten {
            font-size: 16px;
            line-height: 1.7;
        }
    </style>
</head>
<body>
<div class="kop">
    <strong>SMK Negeri Suka-Suka</strong><br>
    Jl. Pendidikan No. 123, Indonesia
</div>

<div class="konten">
    <p><?= $tanggal ?></p>

    <p>Kepada Yth.<br>
    HRD <?= htmlspecialchars($mitra['nama_perusahaan']) ?><br>
    di <?= htmlspecialchars($mitra['alamat']) ?></p>

    <p>Dengan hormat,</p>

    <p>Saya yang bertanda tangan di bawah ini:</p>
    <ul>
        <li>Nama: <?= htmlspecialchars($siswa['nama']) ?></li>
        <li>NIS: <?= htmlspecialchars($siswa['nis']) ?></li>
        <li>Jurusan: <?= htmlspecialchars($siswa['jurusan']) ?></li>
        <li>Asal Sekolah: SMK Negeri Suka-Suka</li>
    </ul>

    <p>Dengan ini mengajukan permohonan untuk dapat melaksanakan Praktik Kerja Lapangan (PKL) di perusahaan yang Bapak/Ibu pimpin.</p>

    <p>Demikian surat ini saya sampaikan. Atas perhatian dan kesempatan yang diberikan, saya ucapkan terima kasih.</p>
</div>

<div class="tanda-tangan">
    Hormat saya,<br><br><br>
    <strong><?= htmlspecialchars($siswa['nama']) ?></strong><br>
    Siswa SMK Negeri Suka-Suka
</div>

<div class="tanda-tangan" style="margin-top: 80px; text-align: left;">
    Mengetahui,<br>
    Kepala Sekolah<br><br><br>
    <strong>Andreas</strong>
</div>

</body>
</html>
