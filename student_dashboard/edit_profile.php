<?php
    include "./config.php";

    session_start();
    if (!isset($_SESSION['studentId'])) {
        header("Location: login.php");
        exit();
    }

    $studentId = $_SESSION['studentId'];

    $firstName = $lastName = $gender = $department = $intake = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $_POST["firstname"];
        $lastName = $_POST["lastname"];
        $gender = $_POST["gender"];
        $department = $_POST["department"];
        $intake = $_POST["intake"];

        $errors = [];

        if (empty($errors)) {
            $updateSql = "UPDATE students SET firstname = ?, lastname = ?, gender = ?, department = ?, intake = ? WHERE studentId = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("ssssss", $firstName, $lastName, $gender, $department, $intake, $studentId);

            if ($stmt->execute()) {
                header("Location: dashboard.php");
                exit();
            } else {
                $errorMessage = "Failed to update profile.";
            }
        }
    }

    $selectSql = "SELECT firstname, lastname, gender, department, intake FROM students WHERE studentId = ?";
    $stmt = $conn->prepare($selectSql);
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $gender, $department, $intake);
    $stmt->fetch();
    $stmt->close();

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #ff0000;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 93%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            height: 34px;
        }

        input[type="submit"] {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #cc0000;
        }

        .error {
            color: #ff0000;
        }
    </style>
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $firstName; ?>"><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $lastName; ?>"><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br>

        <label for="department">Department:</label>
        <input type="text" id="department" name="department" value="<?php echo $department; ?>"><br>

        <label for="intake">Intake:</label>
        <input type="text" id="intake" name="intake" value="<?php echo $intake; ?>"><br>

        <input type="submit" value="Update" style="width: 100%;">
    </form>

    <?php
    if (!empty($errorMessage)) {
        echo "<p>Error: $errorMessage</p>";
    }
    ?>
</body>
</html>
