<?php
include "config.php";
?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin | student list</title>
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

        <h1>Students List</h1>
       

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
        <th scope="col">Student ID</th>
        <th scope="col">Gender</th>
        <th scope="col">Intake</th>
        <th scope="col">Dept.</th>
        <th scope="col"></th>
        <!-- gender, intake, department -->
      </tr>
    </thead>
    <tbody>

    <?php
      $sql = "SELECT * FROM `students`";
      $query = mysqli_query($conn, $sql);
      $i = 1;

      while($student = mysqli_fetch_array($query)){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $student["firstname"];?> <?php echo $student["lastname"];?></td>
        <td><?php echo $student["studentId"];?></td>
        <td><?php echo $student["gender"];?></td>
        <td><?php echo $student["intake"];?></td>
        <td><?php echo $student["department"];?></td>
        <td> <a href="delete.php?&id=<?php echo $student["id"];?>">Delete</a> </td>
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
<!-- <a class="btn btn-danger" href="logout.php" role="button">Logout</a> -->
</body>
  </html>
