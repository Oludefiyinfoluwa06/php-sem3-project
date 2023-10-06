<?php
    session_start();
    if (isset($_SESSION["studentId"])) {
        header("Location: dashboard.php");
        exit();
    }
    include "./config.php";

    $studentId = $firstname = $lastname = $gender = $department = $intake = $password = "";

    $studentId_err = $firstname_err = $lastname_err = $gender_err = $department_err = $intake_err = $password_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty(trim($_POST["studentId"]))) {
            $studentId_err = "Please enter your Student ID.";
        } else {
            $sql = "SELECT id FROM students WHERE studentId = ?";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_studentId);
                $param_studentId = trim($_POST["studentId"]);
                
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $studentId_err = "This Student ID is already registered.";
                    } else {
                        $studentId = trim($_POST["studentId"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }
        
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
        
        if (empty(trim($_POST["gender"]))) {
            $gender_err = "Please select your Gender.";
        } else {
            $gender = trim($_POST["gender"]);
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

        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password.";
        } else {
            $password = trim($_POST["password"]);
        }
        
        if (empty($studentId_err) && empty($firstname_err) && empty($lastname_err) && empty($gender_err) && empty($department_err) && empty($intake_err) && empty($password_err)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO students (studentId, firstname, lastname, gender, department, intake, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssssss", $param_studentId, $param_firstname, $param_lastname, $param_gender, $param_department, $param_intake, $param_password);
                
                $param_studentId = $studentId;
                $param_firstname = $firstname;
                $param_lastname = $lastname;
                $param_gender = $gender;
                $param_department = $department;
                $param_intake = $intake;
                $param_password = $hashed_password;
                
                if ($stmt->execute()) {
                    header("location: login.php");
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
    <title>Student  Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
          background-color: #ffffff;
        }
        .container {
          max-width: 500px;
          margin: 0 auto;
          padding: 20px;
          background-color: #fff;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
          border-radius: 5px;
          margin-top: 50px;
        }
        h2 {
          text-align: center;
          color: #ff0000;
          margin-bottom: 20px;
        }
        label {
          font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
        }
        select {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
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
        .alert {
          color: #ff0000;
          font-weight: bold;
          margin-top: 10px;
        }
        a {
          text-decoration: none;
          color: #ff0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Student ID</label>
                <input type="text" name="studentId" class="form-control" value="<?php echo $studentId; ?>">
                <span class="alert"><?php echo $studentId_err; ?></span>
            </div>
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="alert"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="alert"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="" selected disabled>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <span class="alert"><?php echo $gender_err; ?></span>
            </div>
            <div class="form-group">
                <label>Department</label>
                <select name="department" class="form-control">
                <option value="" selected disabled>Select Department</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Computer Software Engineering">Computer Software Engineering</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Mass Communication">Mass Communication</option>
                    <option value="Banking and Operations">Banking and Operations</option>
                    <option value="Medicine">Medicine</option>
                    <option value="Psychology">Psychology</option>
                </select>
                <span class="alert"><?php echo $department_err; ?></span>
            </div>
            <div class="form-group">
                <label>Intake</label>
                <select name="intake" class="form-control">
                <option value="" selected disabled>Select Intake</option>
                    <option value="March 2022">March 2022</option>
                    <option value="November 2022">November 2022</option>
                    <option value="May 2023">May 2023</option>
                    <option value="July 2023">July 2023</option>
                </select>
                <span class="alert"><?php echo $intake_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="alert"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <button type="submit">Create Account</button>
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
