<?php 
    include "./config.php";

    $sql = "SELECT sender, message, image FROM messages";
    $result = mysqli_query($conn, $sql);
?>