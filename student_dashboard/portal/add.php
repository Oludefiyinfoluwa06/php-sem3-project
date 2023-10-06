<?php
include "config.php";


if(isset($_POST["addrecord"])){

     $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    
        $mysql  = "INSERT INTO student (firstname, lastname, email)
        VALUES ('$firstname', '$lastname', '$email')";
    
        $query = mysqli_query($conn, $mysql);
    
        if($query){
            header("location: index.php?&successful");
                }else{
                    header("location: index.php?&failed");
                }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<form style="width:500px; padding:20px;" method="POST">
  <div class="form-group" >
    <label >Email</label>
    <input type="email" class="form-control" name="email" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label >First Name</label>
    <input type="text" class="form-control" name="firstname" placeholder="First Name">
  </div>
  <div class="form-group">
  <label>Last Name</label>
    <input type="text" class="form-control" name="lastname" placeholder="Last Name">
  </div>
  <br/>
  <button type="submit" class="btn btn-primary" name="addrecord">Submit</button>
</form>
</body>
</html>