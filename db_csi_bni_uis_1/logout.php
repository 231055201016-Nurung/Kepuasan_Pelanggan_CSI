<?php
session_start();
// Hancurkan semua session
session_unset();
session_destroy();

// Kembali ke halaman login
header("Location: login.php");
exit;
?>
