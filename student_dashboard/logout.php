<?php
session_start();

unset($_SESSION['studentId']);
header("location: login.php");
exit();
?>