<?php
session_name("siswa_session"); 
session_start();

if (!isset($_SESSION["id_siswa"])) {
    header("Location: ../../Public/login.php");
    exit();
}

require_once __DIR__ . "/../../Config/database.php";

// ambil data siswa
$id_siswa = $_SESSION["id_siswa"];
$query = "SELECT * FROM datasiswa WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$jurusan = $data['jurusan'];

// ambil nilai
$query = "SELECT * FROM penilaian_pkl WHERE id_siswa = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result = $stmt->get_result();
$nilai = $result->fetch_assoc();

// ambil pembimbing
$pembimbing = null;
$stmt = $conn->prepare("
    SELECT g.nama_guru, g.email 
    FROM bimbingan b 
    JOIN dataguru g ON b.id_guru = g.id_guru 
    WHERE b.id_siswa = ?
");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$pembimbing_result = $stmt->get_result();
if ($pembimbing_result->num_rows > 0) {
    $pembimbing = $pembimbing_result->fetch_assoc();
}

// Tentukan label aspek sesuai jurusan
$label_aspek = [
    "Rekayasa Perangkat Lunak" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (rekayasa perangkat lunak, sistem operasi, mengoperasikan program aplikasi, dan produk, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKI.", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Teknik Komputer Jaringan" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat pkl)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (troubleshooting PC/ laptop, sistem operasi, mengoperasikan program aplikasi, instalası perangkat jaringan komputer, dan troubleshooting jaringan komputer, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Desain Produksi Busana" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (gambar mode, persiapan pembuatan busana, menjahit produk busana, dan desain hiasan, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Kuliner" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (sanitasi dan hygiene pemilihan dan penanganan bahan, metode memasak, pemilihan alat pengolahan, kemasan,, penyajian, dan pelayanan, serta pemecahan masalah di tempat PKL))", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Teknik Kendaraan Ringan" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (melaksanakan perbaikan mesin, chasis, dan kelistrikan, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Teknik Sepeda Motor" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (melaksanakan perbaikan mesin, chasis, dan kelistrikan, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    // default kalau jurusan tidak dikenal
    "DEFAULT" => ["Aspek 1", "Aspek 2", "Aspek 3", "Aspek 4", "komentar"]
];

$labels = $label_aspek[$jurusan] ?? $label_aspek["DEFAULT"];
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<h3>Penilaian PKL</h3>

<?php if ($nilai): ?>
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Aspek</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr><td><?= htmlspecialchars($labels[0]) ?></td><td><?= $nilai['aspek_1'] ?></td></tr>
                <tr><td><?= htmlspecialchars($labels[1]) ?></td><td><?= $nilai['aspek_2'] ?></td></tr>
                <tr><td><?= htmlspecialchars($labels[2]) ?></td><td><?= $nilai['aspek_3'] ?></td></tr>
                <tr><td><?= htmlspecialchars($labels[3]) ?></td><td><?= $nilai['aspek_4'] ?></td></tr>
                <tr class="table-success">
                    <td><strong>Rata-rata</strong></td>
                    <td><strong><?= $nilai['rata_rata'] ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <th>Komentar Guru : </th>
<td><?= $nilai['komentar'] ?? ':-' ?></td>
<?php else: ?>
    <div class="alert alert-warning mt-4" role="alert">
        Belum ada penilaian yang tersedia.
    </div>
<?php endif; ?>

<?php include 'template/footer.php'; ?>
