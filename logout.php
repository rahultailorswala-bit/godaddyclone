<?php
// logout.php - User logout
session_start();
session_destroy();
echo "<script>window.location.href = 'index.php';</script>";
exit;
?>
