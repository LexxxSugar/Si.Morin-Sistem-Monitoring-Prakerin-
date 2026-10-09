<?php
session_name("siswa_session"); 
session_start();

// Hapus semua data session
session_unset();     
session_destroy();    

// Arahkan kembali ke halaman login
header("Location: ../../Public/login.php"); 
exit;
?>

