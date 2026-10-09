<div class="col-md-2 sidebar p-3">
  <h5 class="text-white mb-4">Guru PKL</h5>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'daftar_bimbingan.php' ? 'active' : '' ?>" href="daftar_bimbingan.php">Daftar Bimbingan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'jurnal.php' ? 'active' : '' ?>" href="jurnal.php">Jurnal Siswa</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'absen_siswa.php' ? 'active' : '' ?>" href="absen_siswa.php">Absen Siswa</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'penilaian.php' ? 'active' : '' ?>" href="penilaian.php">Penilaian</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'laporan_siswa.php' ? 'active' : '' ?>" href="laporan_siswa.php">Laporan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="logout.php">Logout</a>
    </li>
  </ul>
</div>
<div class="col-md-10 p-4">
