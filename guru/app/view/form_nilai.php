<?php
session_name("guru_session");
session_start();

if (!isset($_SESSION['guru_login']) || $_SESSION['guru_login'] !== true) {
    die("Akses ditolak. Silakan login sebagai guru.");
}

require_once '../../Config/database.php';

$id_siswa = $_GET['id_siswa'] ?? null;
if (!$id_siswa) die("ID siswa tidak ditemukan.");

// Ambil data siswa, jurusan, dan nilai
$query = "SELECT s.nama, s.email, s.jurusan, p.* 
          FROM datasiswa s
          LEFT JOIN penilaian_pkl p ON s.id = p.id_siswa
          WHERE s.id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) die("Data siswa tidak ditemukan.");

$nama       = $data['nama'];
$email      = $data['email'];
$jurusan    = $data['jurusan'];
$aspek_1    = $data['aspek_1'] ?? '';
$aspek_2    = $data['aspek_2'] ?? '';
$aspek_3    = $data['aspek_3'] ?? '';
$aspek_4    = $data['aspek_4'] ?? '';
$rata_rata  = $data['rata_rata'] ?? '';
$komentar   = $data['komentar'] ?? '';

// Mapping label per jurusan
$labelJurusan = [
    "Rekayasa Perangkat Lunak" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (rekayasa perangkat lunak, sistem operasi, mengoperasikan program aplikasi, dan produk, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKI.", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Teknik Komputer Jaringan" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat pkl)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (troubleshooting PC/ laptop, sistem operasi, mengoperasikan program aplikasi, instalası perangkat jaringan komputer, dan troubleshooting jaringan komputer, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Desain Produksi Busana" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (gambar mode, persiapan pembuatan busana, menjahit produk busana, dan desain hiasan, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Kuliner" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (sanitasi dan hygiene pemilihan dan penanganan bahan, metode memasak, pemilihan alat pengolahan, kemasan,, penyajian, dan pelayanan, serta pemecahan masalah di tempat PKL))", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Teknik Kendaraan Ringan" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (melaksanakan perbaikan mesin, chasis, dan kelistrikan, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    "Teknik Sepeda Motor" => ["Memahami alur bisnis dunia kerja tempat PKL dan wawasan wirausaha (pemahaman teori, dan kemampuan adaptasi di tempat PKL)", "Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada dunia kerja di tempat PKL (melaksanakan perbaikan mesin, chasis, dan kelistrikan, serta pemecahan masalah di tempat PKL)", "Menerapkan norma, Prosedur Operasional Standar dan Kesehatan Keselamatan Kerja dan Lingkungan Hidup yang ada pada dunia kerja di Tempat PKL", "Menerapkan soft skills yang dibutuhkan dalam dunia kerja di tempat PKL (menerapkan kedisiplinan, kejujuran, sopan santun, dan tanggung jawab)"],
    
];

// Gunakan default jika jurusan tidak terdaftar
$labels = $labelJurusan[$jurusan] ?? ['Aspek 1','Aspek 2','Aspek 3','Aspek 4'];
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
  <h3 class="mb-4">Form Penilaian Siswa</h3>
  <div class="card p-4">
    <form method="POST" action="../controller/simpan_nilai.php">
      <input type="hidden" name="id_siswa" value="<?= $id_siswa ?>">
      <div class="mb-3">
        <label>Nama</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($nama) ?>" readonly>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($email) ?>" readonly>
      </div>
      <div class="mb-3">
        <label>Jurusan</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($jurusan) ?>" readonly>
      </div>
      <div class="row">
        <div class="col-md-3 mb-3">
          <label><?= htmlspecialchars($labels[0]) ?></label>
          <input type="number" name="aspek_1" class="form-control" value="<?= $aspek_1 ?>" required>
        </div>
        <div class="col-md-3 mb-3">
          <label><?= htmlspecialchars($labels[1]) ?></label>
          <input type="number" name="aspek_2" class="form-control" value="<?= $aspek_2 ?>" required>
        </div>
        <div class="col-md-3 mb-3">
          <label><?= htmlspecialchars($labels[2]) ?></label>
          <input type="number" name="aspek_3" class="form-control" value="<?= $aspek_3 ?>" required>
        </div>
        <div class="col-md-3 mb-3">
          <label><?= htmlspecialchars($labels[3]) ?></label>
          <input type="number" name="aspek_4" class="form-control" value="<?= $aspek_4 ?>" required>
        </div>
        <div class="form-group">
          <label>Komentar/Catatan Guru:</label>
          <input type="text" name="komentar" class="form-control" value="<?= $komentar ?>" required>
        </div>
      </div>
      <button type="submit" class="btn btn-success">Simpan Nilai</button>
      <a href="penilaian.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?php include 'template/footer.php'; ?>
