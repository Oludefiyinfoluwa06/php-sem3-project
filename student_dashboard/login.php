<?php
session_start();
if (isset($_SESSION["studentId"])) {
    header("Location: dashboard.php");
    exit();
}
include "config.php"; // Include the database configuration file

// Initialize variables to store user input
$studentId = $password = "";

// Initialize variables to store error messages
$studentId_err = $password_err = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate Student ID
    if (empty(trim($_POST["studentId"]))) {
        $studentId_err = "Please enter your Student ID.";
    } else {
        $studentId = trim($_POST["studentId"]);
    }

    // Validate Password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Check if there are no validation errors
    if (empty($studentId_err) && empty($password_err)) {
        // Check the database for user
        $sql = "SELECT studentId, password FROM students WHERE studentId = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_studentId);
            
            $param_studentId = $studentId;
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($studentId, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["studentId"] = $studentId;
                            
                            // Redirect to the welcome page
                            header("location: dashboard.php");
                        } else {
                            // Password is not valid
                            $password_err = "The password you entered is not valid.";
                        }
                    }
                } else {
                    // Student ID is not found
                    $studentId_err = "Student ID not found.";
                }
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
    <title>Login</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-heading {
            color: red;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        form {
            padding-right: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            text-transform: uppercase;
            font-weight: bold;
        }

        .form-control {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
        }

        .btn-login {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 105.8%;
        }

        .btn-login:hover {
            background-color: #ff3333;
        }

        .text-danger {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <h2 class="login-heading">Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="studentId">Student ID</label>
                <input type="text" class="form-control" id="studentId" name="studentId" placeholder="Enter Student ID">
                <span class="text-danger"><?php echo $studentId_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                <span class="text-danger"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-login">Login</button>
            </div>
            <p style="text-align: center;">Forgot Password? <a href="change_password.php">Change password</a></p>
            <p style="text-align: center;">Don't have an account? <a href="create_account.php">Sign up here</a></p>
        </form>
    </div>
</body>
</html>
