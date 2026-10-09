<?php
session_name("guru_session");
session_start();
session_destroy();

header("Location:login.php");
exit;
