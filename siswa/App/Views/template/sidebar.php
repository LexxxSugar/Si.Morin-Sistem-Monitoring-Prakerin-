<div class="col-md-2 sidebar p-3">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kegiatan.php' ? 'active' : '' ?>" href="kegiatan.php">Kegiatan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : '' ?>" href="laporan.php">Laporan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pilih_pembimbing.php' ? 'active' : '' ?>" href="pilih_pembimbing.php">Pilih Pembimbing</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'penilaian.php' ? 'active' : '' ?>" href="penilaian.php">Penilaian</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'propkl.php' ? 'active' : '' ?>" href="propkl.php">Proses PKL</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'absen.php' ? 'active' : '' ?>" href="absen.php">Absen</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'bimbingan.php' ? 'active' : '' ?>" href="bimbingan.php">Bimbingan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'mitra.php' ? 'active' : '' ?>" href="mitra.php">Mitra</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="logout.php">Logout</a>
    </li>
  </ul>
</div>
<div class="col-md-10 p-4">
