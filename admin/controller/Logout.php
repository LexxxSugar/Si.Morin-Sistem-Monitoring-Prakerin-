<?php
session_name("admin_session");
session_start();
session_destroy();
header("Location: ../view/login.php");
exit;
?>
