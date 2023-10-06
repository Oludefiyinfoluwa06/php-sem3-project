<?php

$servername='localhost';
  $username="godwin";
  $password="12345";
  $dbname="school";

// MySQLi Procedural
//   $conn = mysqli_connect($servername,$username,$password, $dbname);


// MYSQLi Object-oriented
$conn = new mysqli($servername, $username,$password, $dbname);


  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }


//     $firstname = $_POST["firstname"];
// $lastname = $_POST["lastname"];
// $email = $_POST["email"];

//     $mysql  = "INSERT INTO student (firstname, lastname, email)
//     VALUES ('$firstname', '$lastname', '$email')";

//     $query = mysqli_query($conn, $mysql);



    
    // if ($query === TRUE) {
    //   // echo "New record created successfully";
    // } else {
    //   echo "Error: " . $sql . "<br>" . $conn->error;
    // }
    // echo "Connected successfully";
?>

