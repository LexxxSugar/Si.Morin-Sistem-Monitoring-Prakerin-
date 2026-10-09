<?php
session_name("siswa_session"); 
session_start();

if (!isset($_SESSION["id_siswa"])) {
    header("Location: ../../Public/login.php");
    exit();
}

require_once __DIR__ . "/../../Config/database.php";

$id_siswa = $_SESSION["id_siswa"];

// Ambil data siswa berdasarkan id
$query = "SELECT * FROM datasiswa WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Ambil jurnal siswa berdasarkan id_siswa
$stmt = $conn->prepare("SELECT * FROM jurnal WHERE id_siswa = ? ORDER BY tanggal DESC");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result_jurnal = $stmt->get_result();
?>



<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<div class="container mt-4">
    <div class="card p-4 shadow-sm mb-4">
        <h2 class="text-center text-primary mb-4">Input Jurnal Kegiatan</h2>
        <input type="hidden" id="jurnal_id" value="">
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal:</label>
            <input type="date" id="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="waktu" class="form-label">Waktu:</label>
            <input type="time" id="waktu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="kegiatan" class="form-label">Kegiatan:</label>
            <textarea id="kegiatan" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Tambahan:</label>
            <textarea id="catatan" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary" id="simpan">Simpan Jurnal</button>
        <div id="pesan" class="mt-3 fw-semibold"></div>
    </div>

    <div class="card p-4 shadow-sm">
        <h3 class="mb-3 text-primary text-center">Daftar Jurnal Saya</h3>
        <div id="tabelJurnal">
            <?php if ($result_jurnal->num_rows > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Kegiatan</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataJurnal">
                        <?php while ($row = $result_jurnal->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['waktu']) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['kegiatan'])) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['catatan'])) ?></td>
                            <td>
                            <button class="btn btn-sm btn-warning" 
                                onclick='editJurnal(<?= json_encode([
                                    "id"       => (int)$row["id"],
                                    "tanggal"  => htmlspecialchars($row["tanggal"]),
                                    "waktu"    => htmlspecialchars($row["waktu"]),
                                    "kegiatan" => htmlspecialchars($row["kegiatan"]),
                                    "catatan"  => htmlspecialchars($row["catatan"])
                                ], JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                Edit
                            </button>

                            <button class="btn btn-sm btn-danger" 
                                onclick='hapusJurnal(<?= json_encode((int)$row["id"]) ?>)'>
                                Hapus
                            </button>
                        </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted text-center">Belum ada jurnal disimpan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.getElementById('simpan').addEventListener('click', function () {
    const id = document.getElementById('jurnal_id').value;
    const tanggal = document.getElementById('tanggal').value;
    const waktu = document.getElementById('waktu').value;
    const kegiatan = document.getElementById('kegiatan').value;
    const catatan = document.getElementById('catatan').value;
    const pesan = document.getElementById('pesan');

    if (!tanggal || !waktu || !kegiatan) {
        pesan.innerText = "Harap isi semua field wajib!";
        pesan.className = "text-danger mt-3";
        return;
    }

    const url = id ? '../Controllers/update_jurnal.php' : '../Controllers/simpan_jurnal.php';

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, tanggal, waktu, kegiatan, catatan })
    })
    .then(res => res.json())
    .then(data => {
        pesan.innerText = data.pesan;
        pesan.className = data.pesan.includes("berhasil") ? "text-success mt-3" : "text-danger mt-3";
        if (data.pesan.includes("berhasil")) location.reload();
    })
    .catch(err => {
        console.error("Error:", err);
        pesan.innerText = "Gagal mengirim data ke server.";
        pesan.className = "text-danger mt-3";
    });
});

function editJurnal(data) {
    document.getElementById('jurnal_id').value = data.id;
    document.getElementById('tanggal').value = data.tanggal;
    document.getElementById('waktu').value = data.waktu;
    document.getElementById('kegiatan').value = data.kegiatan;
    document.getElementById('catatan').value = data.catatan;
    document.getElementById('simpan').innerText = 'Update Jurnal';
}

function hapusJurnal(id) {
    if (!confirm('Yakin ingin menghapus jurnal ini?')) return;
    fetch('../Controllers/hapus_jurnal.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.pesan);
        location.reload();
    })
    .catch(err => alert('Terjadi kesalahan saat menghapus.'));
}
</script>

<?php include 'template/footer.php'; ?>
