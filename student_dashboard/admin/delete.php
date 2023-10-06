<?php
include "config.php";


$id =  $_GET["id"];


$sql = "DELETE FROM students WHERE `id`=$id";
$query = mysqli_query($conn, $sql);

if($query){
    header("location: studentslist.php?&successful");
        }else{
            header("location: index.php?&failed");
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>
<body>
</body>
</html>