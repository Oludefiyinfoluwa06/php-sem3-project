<?php
include "config.php";

session_start(); 
$user_id = isset($_SESSION['student_portal']) ? $_SESSION['student_portal'] : 0; 
// echo $user_id;
 if($user_id != 0) {
  $sql = "SELECT * FROM `student` WHERE `id`='$user_id'";
  $query = mysqli_query($conn, $sql);
  if (mysqli_num_rows($query) == 1) {
      header("location: index.php");
  }
}

if(isset($_POST['login'])){
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn,$_POST['lastname']);

$input_arr = array();

if(empty($email)){
  $input_arr['input_email_error'] = "Mail is Required!";
}
if(empty($password)){
  $input_arr['input_password_error'] = "Password is Required!";
}

if(count($input_arr)==0){
  $sql = "SELECT * FROM `student` WHERE `email`='$email'";
$query = mysqli_query($conn, $sql);
if(mysqli_num_rows($query)==1){
$row = mysqli_fetch_assoc($query);  
if($row['lastname'] == $password){
  $id = $row['id'];       
  $_SESSION['student_portal'] = $id;   
  header("location: index.php");
}else{
  $error = "Incorrect email or password!";
}
}
else{
  $error = "User not found!";
}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script>
    setTimeout(() => {
      const error1 = document.querySelector("#error1");
      const error2 = document.querySelector("#error2");
      if(!error1 || !error2) return;
        error1.remove()
        error2.remove()
    }, 5000);
    </script>

    <style>
      .error{
        color:red;
      }
      </style>
</head>
<body>

<!-- <center> -->
<form style="width:500px; padding:20px;" class="mt-3 m-auto" method="POST">
<h2 class="m-auto">Login to your account</h2>
<h3><?php if(isset($error)){echo $error;} ?></h3>
  <div class="form-group mb-1">
    <label class="align-items-start">Email</label>
    <input type="email" class="form-control" name="email" placeholder="Enter email" required >
   <?php echo isset($input_arr["input_email_error"]) ?
   '<label id="error1"class="error">'.$input_arr["input_email_error"].'</label>':'';
   ?>
  </div>
  <div class="form-group mb-3">
  <label class="align-items-start">Password</label>
    <input type="password" class="form-control" name="lastname" placeholder="Last Name" required>
    <?php echo isset($input_arr["input_password_error"]) ?
   '<label id="error2" class="error">'.$input_arr["input_password_error"].'</label>':'';
   ?>
  </div>
  <button type="submit" class="btn btn-primary m-auto" name="login">Login</button>
</form>
<!-- </center> -->

</body>
</html>