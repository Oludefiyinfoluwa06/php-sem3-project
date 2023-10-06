<?php
require "config.php";

$retrieveId = $_GET["id"];
$sql = "SELECT * FROM `student` WHERE `id`=$retrieveId";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);

// Check if a valid row was retrieved
if ($row) {
    $firstName = $row["firstname"];
    $lastName = $row["lastname"];
    $email_ = $row["email"];
    $id = $row["id"];
} else {
    // Handle the case where no matching record was found
    // You can redirect to an error page or show an error message here
    echo "Student not found";
}


if(isset($_POST["updaterecord"])){
  
    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $sql = "UPDATE student SET `firstname`='$firstname', `lastname`='$lastname', `email`='$email' WHERE `id`='$id'";
    $query = mysqli_query($conn, $sql);

    if($query){
header("location: index.php?&successful");
    }else{
        header("location: index.php?&failed");
    }
}

?>

<html>
<head>
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>
<body style="padding: 10px;">

<h2>Record Edit Form</h2>
<form style="width: 300px;" action="" method="POST">
    <div class="form-group">
        <label>First Name</label>
        <input name="firstname" class="form-control" placeholder="Enter First Name" value="<?php echo $firstName; ?>">
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input name="lastname" class="form-control" placeholder="Enter Last Name" value="<?php echo $lastName; ?>">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email_; ?>">
    </div>
    <br/>
    <button type="submit" class="btn btn-primary" name="updaterecord">Submit</button>
</form>
</body>
</html>
