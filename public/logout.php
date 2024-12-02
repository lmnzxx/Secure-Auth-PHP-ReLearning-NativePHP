<?php
session_start();
session_destroy();
header('Location: /secure-auth/public/index.php');
exit;
?>
