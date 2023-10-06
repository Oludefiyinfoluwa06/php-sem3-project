<?php
    include "./config.php";

    $query = "SELECT education_title, education_subtitle, test_title, test_subtitle, test_description FROM sidebar";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Database query failed.");
    }

    $row = mysqli_fetch_assoc($result);

    $educationTitle = $row['education_title'];
    $educationSubtitle = $row['education_subtitle'];
    $testTitle = $row['test_title'];
    $testSubtitle = $row['test_subtitle'];
    $testDescription = $row['test_description'];
?>

