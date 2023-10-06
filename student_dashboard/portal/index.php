<?php
include "config.php";
session_start();
$user_id = isset($_SESSION['student_portal']) ? $_SESSION['student_portal'] : 0; 
// echo $user_id;

if ($user_id == 0) {
    header("location: login.php");
} else {
    $sql = "SELECT * FROM `student` WHERE `id`='$user_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) != 1) {
        header("location: login.php");
    }
}

?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  </head>

  <script>
    setTimeout(() => {
        document.getElementById("message").remove()
    }, 5000);
    </script>
  <body>
      <center>

        <h1>ALL DATA ON THE DB</h1>
        <a class="btn btn-primary" href="add.php" role="button">Add</a>
       

          <?php if(isset($_GET["successful"])) {
            echo "<div id='message' class='alert alert-success'>RECORD UPDATED SUCCESSFULLY</div>";
            }
            ?>
          <?php if(isset($_GET["error"])) {
          echo"<div id='message' class='alert alert-danger'>RECORD UPDATING FAILED</div>";
            }
            ?>

          <table class="table">
    <thead>
      <tr>
        <th scope="col">S/N</th>
        <th scope="col">Full Name</th>
        <th scope="col">Email</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>

    <?php
      $sql = "SELECT * FROM `student`";
      $query = mysqli_query($conn, $sql);
      $i = 1;

      while($student = mysqli_fetch_array($query)){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $student["firstname"];?> <?php echo $student["lastname"];?></td>
        <td><?php echo $student["email"];?></td>
        <td><a href="edit.php?&id=<?php echo $student["id"];?>">Edit</a> | <a href="delete.php?&id=<?php echo $student["id"];?>">Delete</a> </td>
      </tr>
      <?php $i++; }?>
      
      <!-- <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
      </tr>  -->
    </tbody>
  </table>

  
  
</center>
<a class="btn btn-danger" href="logout.php" role="button">Logout</a>
</body>
  </html>
