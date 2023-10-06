<?php
    include "./config.php";

    $sql = "SELECT * FROM students";

    $result = mysqli_query($conn, $sql);
    $firstname = $lastname = $studentId = $department = $intake = $currentSemester = $clearanceReason = $comments = "";

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $studentId = $row['studentId'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $department = $row['department'];
            $intake = $row['intake'];
        }
    } else {
        echo "No student data found.";
    }


    $firstname_err = $lastname_err = $studentId_err = $department_err = $intake_err = $currentSemester_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["firstname"]))) {
            $firstname_err = "Please enter your First Name.";
        } else {
            $firstname = trim($_POST["firstname"]);
        }

        if (empty(trim($_POST["lastname"]))) {
            $lastname_err = "Please enter your Last Name.";
        } else {
            $lastname = trim($_POST["lastname"]);
        }

        if (empty(trim($_POST["studentId"]))) {
            $studentId_err = "Please enter your Student ID.";
        } else {
            $studentId = trim($_POST["studentId"]);
        }

        if (empty(trim($_POST["department"]))) {
            $department_err = "Please select your Department.";
        } else {
            $department = trim($_POST["department"]);
        }

        if (empty(trim($_POST["intake"]))) {
            $intake_err = "Please select your Intake.";
        } else {
            $intake = trim($_POST["intake"]);
        }

        if (empty(trim($_POST["currentSemester"]))) {
            $currentSemester_err = "Please select your Current Semester.";
        } else {
            $currentSemester = trim($_POST["currentSemester"]);
        }

        // Check if there are no validation errors
        if (empty($firstname_err) && empty($lastname_err) && empty($studentId_err) && empty($department_err) && empty($intake_err) && empty($currentSemester_err)) {
            // Insert user data into the database
            $sql = "INSERT INTO clearance_requests (firstname, lastname, studentId, department, intake, currentSemester) VALUES (?, ?, ?, ?, ?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssss", $firstname, $lastname, $studentId, $department, $intake, $currentSemester);
                
                if ($stmt->execute()) {
                    // Redirect to a success page or display a success message
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }
        
        $conn->close();
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Form</title>
    <link rel="stylesheet" href="./static/styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        .profile-container {
            position: absolute;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.9);
            width: 100%;
            height: 100%;
            z-index: 100;
            display: none;
        }
        .profile {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border-radius: 10px;
            padding: 20px;
        }
        .profile h2 {
            color: red;
            margin-bottom: 20px;
            text-align: center;
        }
        .profile p {
            font-size: 20px;
            color: red;
        }
        .show {
            display: block;        
        }
        .close-icon {
            position: absolute;
            top: 35px;
            left: 90%;
        }
        .btns {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
        }
        button {
          background-color: #ff0000;
          color: #fff;
          border: none;
          padding: 10px 20px;
          border-radius: 4px;
          cursor: pointer;
          width: 100%;
        }
        button:hover {
          background-color: #cc0000;
        }
        .btns button a {
            text-decoration: none;
            color: #fff;
        }
        body {
            background-color: #f8f9fa;
        }

        .container1 {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body style="font-family: 'Poppins';">
  <nav class="navbar navbar-expand-lg border px-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="/home">
        <img src="https://img1.wsimg.com/isteam/ip/0d532241-dda1-42d3-9ca9-6c0bd972594a/Logo%20Trans-fde57a7.png/:/rs=w:814,h:160,cg:true,m/cr=w:814,h:160/qt=q:95" alt="Lincoln-Logo" height="40px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 320px; text-transform: uppercase;">
          <li class="nav-item me-4">
            <a class="nav-link link navLink" aria-current="page" href="dashboard.php">Home</a>
          </li>
          <li class="nav-item me-4">
            <a class="nav-link link navLink" aria-current="page" href="#">Overview</a>
          </li>
          <li class="nav-item me-4">
            <a class="nav-link link navLink" aria-current="page" href="#">Report</a>
          </li>
          <li class="nav-item me-4">
            <a class="nav-link link navLink" aria-current="page" href="#">Manage</a>
          </li>
          <li class="nav-item me-4">
            <a class="nav-link active link navLink" aria-current="page" href="clearance_form.php">Clearance</a>
          </li>
        <li class="nav-item me-4">
          <div class="nav-link" aria-current="page" id="profile-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
          </a>
        </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="d-flex justify-content-between mb-3 p-4">
    <div class="p-2 pe-4 me-3 border-end border-danger education">
      <div class="d-flex flex-column align-items-start">
        <h1 class="text-danger" style="font-size: 60px;">Education</h1>
        <h3 style="font-size: 50px;">For all</h3>
      </div>
      <div class="card mb-3 border-0" style="max-width: 25rem; background: pink;">
        <h5 class="card-header border-0 ms-2" style="background: none;">Upcoming Tests</h5>
        <div class="card m-4 mt-2 border-0 rounded-3 shadow-lg" style="width: 80%;">
          <div class="card-body">
            <h5 class="card-title">Get cleared to unlock</h5>
            <p class="card-text">Click to learn more</p>
          </div>
        </div>
      </div>
      <div class="msgs">
        <div class="rows">
            <h3>Messages</h3>
        </div>
        <?php
            include "./admin/message_process.php";

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $sender = $row["sender"];
                    $message = $row["message"];
                    $image = $row["image"];

                    echo '<div class="rows">';
                    echo '<img src="' . $image . '">';
                    echo '<p><b>' . $sender . '</b><br>' . $message . '</p>';
                    echo '</div>';
                }
                mysqli_free_result($result);
            } else {
                echo 'Error: ' . mysqli_error($conn);
            }
        ?>
    </div>
</div>

    <div class="container1">
    <h2>Clearance Form</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name">
            <span class="text-danger"><?php echo $firstname_err; ?></span>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name">
            <span class="text-danger"><?php echo $lastname_err; ?></span>
        </div>
        <div class="form-group">
            <label for="studentId">Student ID</label>
            <input type="text" class="form-control" id="studentId" name="studentId" placeholder="Enter Student ID">
            <span class="text-danger"><?php echo $studentId_err; ?></span>
        </div>
        <div class="form-group">
            <label for="department">Department</label>
            <select class="form-control" id="department" name="department">
                <option value="">Select your Department</option>
                <option value="Department 1">Department 1</option>
                <option value="Department 2">Department 2</option>
                <!-- Add more options as needed -->
            </select>
            <span class="text-danger"><?php echo $department_err; ?></span>
        </div>
        <div class="form-group">
            <label for="intake">Intake</label>
            <select class="form-control" id="intake" name="intake">
                <option value="">Select your Intake</option>
                <option value="Intake 1">Intake 1</option>
                <option value="Intake 2">Intake 2</option>
                <!-- Add more options as needed -->
            </select>
            <span class="text-danger"><?php echo $intake_err; ?></span>
        </div>
        <div class="form-group">
            <label for="currentSemester">Current Semester</label>
            <select class="form-control" id="currentSemester" name="currentSemester">
                <option value="">Select your Current Semester</option>
                <option value="1st Semester">1st Semester</option>
                <option value="2nd Semester">2nd Semester</option>
            </select>
            <span class="text-danger"><?php echo $currentSemester_err; ?></span>
        </div>
        <button type="submit" class="btn btn-danger">Submit</button>
    </form>
</div>

</div>
<div class="profile-container" id="profile">
    <div class="profile">
        <div id="close-icon" class="close-icon">
            <svg viewPort="0 0 12 12" version="1.1"
        xmlns="http://www.w3.org/2000/svg">
                <line x1="1" y1="11" 
                    x2="11" y2="1" 
                    stroke="black" 
                    stroke-width="2"/>
                    <line x1="1" y1="1" 
                    x2="11" y2="11" 
                    stroke="black" 
                    stroke-width="2"/>
            </svg>
        </div>
        <h2>Student Profile</h2>
        <div class="profile-info">
            <p><strong>Student ID: </strong><?php echo $studentId; ?></p>
            <p><strong>Firstname: </strong><?php echo $firstname; ?></p>
            <p><strong>Lastname: </strong><?php echo $lastname; ?></p>
            <p><strong>Gender: </strong><?php echo $gender; ?></p>
            <p><strong>Department: </strong><?php echo $department; ?></p>
            <p><strong>Intake: </strong><?php echo $intake; ?></p>
        </div>
        <div class="btns">
            <button><a href="edit_profile.php">Edit profile</a></button>
            <button><a href="logout.php">Logout</a></button>
        </div>
    </div>
</div>
<script>
    const profileIcon = document.getElementById("profile-icon");
    const profile = document.getElementById("profile");
    const closeIcon = document.getElementById("close-icon");
    profileIcon.addEventListener("click", () => {
        profile.classList.add("show");
    })
    closeIcon.addEventListener("click", () => {
        profile.classList.remove("show");
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>