<?php
require_once "../config/database.php";
$result = $conn->query("SELECT * FROM flowchart_pkl ORDER BY id ASC");
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<div class="container mt-5">
    <div class="row g-4 align-items-start">
        <!-- Kolom gambar -->
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                <div class="card-body text-center">
                    <div class="flowchart-container">
                        <img src="pkl.png" 
                             alt="Flowchart PKL" 
                             class="img-fluid flowchart-img mb-3">
                    </div>

                    <!-- Info detail step -->
                    <div id="info-box" 
                         class="mt-4 p-4 border rounded bg-light shadow-sm" 
                         style="display:none;">
                        <h4 id="info-title" class="fw-bold text-primary"></h4>
                        <p id="info-content" class="text-secondary"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom tombol -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white fw-bold">
                    Daftar Proses PKL
                </div>
                <div class="list-group list-group-flush">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <button type="button" 
                                class="list-group-item list-group-item-action flow-btn fw-semibold" 
                                onclick="showInfo('<?php echo $row['id']; ?>')">
                            <?php echo $row['label']; ?>
                        </button>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Tambahan -->
<style>
/* Efek zoom pada gambar */
.flowchart-container {
    overflow: hidden;
    border-radius: 10px;
}
.flowchart-img {
    transition: transform 0.4s ease;
    cursor: zoom-in;
}
.flowchart-img:hover {
    transform: scale(1.05);
}

/* Tombol cantik */
.flow-btn {
    transition: all 0.3s ease;
    border-left: 5px solid transparent;
}
.flow-btn:hover {
    background: #f0f8ff;
    border-left: 5px solid #0d6efd;
    transform: translateX(5px);
}

/* Animasi info box muncul */
#info-box {
    animation: fadeIn 0.4s ease-in-out;
}
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to   {opacity: 1; transform: translateY(0);}
}
</style>

<!-- Script -->
<script>
function showInfo(id) {
    fetch("get_step.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById("info-title").innerText = data.step;
        document.getElementById("info-content").innerText = data.content;
        document.getElementById("info-box").style.display = "block";
        document.getElementById("info-box").scrollIntoView({behavior: "smooth"});
    });
}
</script>
<?php include 'template/footer.php'; ?>
