<?php
    include "./config.php";

    // Initialize variables
    $studentId = $newPassword = $confirmPassword = $resetError = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $studentId = trim($_POST["studentId"]);
        $newPassword = trim($_POST["newPassword"]);
        $confirmPassword = trim($_POST["confirmPassword"]);

        $sql = "SELECT id FROM students WHERE studentId = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_studentId);
            $param_studentId = $studentId;

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    if ($newPassword === $confirmPassword) {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                        $updateSql = "UPDATE students SET password = ? WHERE studentId = ?";
                        if ($updateStmt = $conn->prepare($updateSql)) {
                            $updateStmt->bind_param("ss", $hashedPassword, $param_studentId);
                            $param_studentId = $studentId;

                            if ($updateStmt->execute()) {
                                $resetError = "Password reset successful. You can now <a href='login.php' style='color: blue;'>login</a> with your new password.";
                            } else {
                                $resetError = "Oops! Something went wrong. Please try again later.";
                            }
                            $updateStmt->close();
                        }
                    } else {
                        $resetError = "Passwords do not match. Please try again.";
                    }
                } else {
                    $resetError = "Student ID not found.";
                }
            } else {
                $resetError = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 400px;
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

        .form-group {
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
        <h2>Password Reset</h2>
        <?php if (empty($resetError)) : ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="studentId">Student ID</label>
                    <input type="text" class="form-control" id="studentId" name="studentId">
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                </div>
                <button type="submit" class="btn btn-danger">Reset Password</button>
            </form>
        <?php else : ?>
            <div class="alert alert-danger" style="text-align: center;"><?php echo $resetError; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
