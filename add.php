<?php

include "config/db.php";

$firstName = $lastName = $email = "";
$errors = ["firstName" => "", "lastName" => "", "email" => ""];

if (isset($_POST["submit"])) {

    // check that the first name is entered
    if (empty($_POST["firstName"])) {
        $errors["firstName"] = "A first name is required <br>";
    } else {
        $firstName = $_POST["firstName"];
        // if (!preg_match("/^[a-zA-Z\s]+$/", $firstName)) {
        //     $errors["firstName"] = "First name must be letters and spaces only";
        // }
    }

    // check that the last name is entered
    if (empty($_POST["lastName"])) {
        $errors["lastName"] = "A last name is required <br>";
    } else {
        $firstName = $_POST["lastName"];
        // if (!preg_match("/^[a-zA-Z\s]+$/", $lastName)) {
        //     $errors["lastName"] = "Last name must be letters and spaces only";
        // }
    }

    // check email
    if (empty($_POST["email"])) {
        $errors["email"] = "An email is required <br>";
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Email must be a valid email address.";
        }
    }

    if (array_filter($errors)) {
        echo "There are errors in the form";
    } else {

        $firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
        $lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);

        // Create SQL
        $sql = "INSERT INTO employees(firstName,lastName,email) VALUES('$firstName', '$lastName', '$email')";

        // Save to the DB
        if (mysqli_query($conn, $sql)) {
            // Success
            header("Location: index.php");
        } else {
            // Error
            echo "Query Error: " . mysqli_error($conn);
        }

    }

} // End of POST check

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <button class="btn btn-lg btn-success">
    <a href="index.php" style="text-decoration:none;color:black">Home</a>
    </button>
    <form action="add.php" method="POST">
        <div class="form-group">
            <label for="">Name</label>
            <input class="form-control" type="text" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
            <div class="danger"><?php echo $errors["firstName"]; ?></div>
        </div>
        <div class="form-group">
            <label for="">Surname</label>
            <input class="form-control" type="text" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
            <div class="danger"><?php echo $errors["lastName"]; ?></div>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="danger"><?php echo $errors["email"]; ?></div>
        </div>
        <input class="btn btn-dark" type="submit" name="submit" value="Submit">
    </form>
</div>

</body>
</html>
