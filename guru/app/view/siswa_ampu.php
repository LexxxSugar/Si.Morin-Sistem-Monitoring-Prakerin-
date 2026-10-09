<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include '../../config/database.php';

$jurusan = $_SESSION['jurusan'] ?? '';

if ($jurusan == '') {
    echo "Jurusan tidak ditemukan.";
    exit();
}

$query = "SELECT * FROM datasiswa WHERE jurusan = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $jurusan);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Siswa Ampu - Jurusan <?php echo htmlspecialchars($jurusan); ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-5 p-4 bg-white rounded shadow-sm">

    <h2>Siswa Ampu Jurusan: <?php echo htmlspecialchars($jurusan); ?></h2>
    <a href="dashboard.php" class="btn btn-outline-primary mb-3">
        &larr; Kembali ke Dashboard
    </a>

    <input
        type="text"
        class="form-control search-input"
        id="searchInput"
        placeholder="Cari nama, email, atau NIS..."
        aria-label="Search students"
    />

    <?php
    $query = "SELECT * FROM datasiswa WHERE jurusan = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $jurusan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-striped table-hover table-sm">
                <thead class="table-primary">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIS</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['nama']) . '</td>
                    <td>' . htmlspecialchars($row['email']) . '</td>
                    <td>' . htmlspecialchars($row['nis']) . '</td>
                </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-info">Tidak ada siswa untuk jurusan ini.</div>';
    }
    $stmt->close();
    ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Search filter for table rows
document.getElementById('searchInput').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#studentTableBody tr');

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const text = Array.from(cells).map(td => td.textContent.toLowerCase()).join(' ');
        if (text.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

</body>
</html>

