<?php

include "config/db.php";

$errors = ["firstName" => "", "lastName" => "", "email" => ""];

// Check for updates
if (isset($_POST["update"])) {

    $id_to_update = mysqli_real_escape_string($conn, $_POST["id_to_update"]);

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
        // $sql = "SELECT * FROM employees WHERE id = $id_to_update"; // employees table

        $sql = "UPDATE employees SET firstName = '$firstName', lastName = '$lastName', email = '$email' WHERE id = $id_to_update";

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

// Check GET request in header
if (isset($_GET["id"])) {

    $id = mysqli_real_escape_string($conn, $_GET["id"]);

    // Make SQL
    $sql = "SELECT * FROM employees WHERE id = $id";

    // Get the query result
    $result = mysqli_query($conn, $sql);

    // Fetch result in an array format
    $employee = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    mysqli_close($conn);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <form action="update.php" method="POST">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="firstName" class="form-control" value="<?php echo $employee["firstName"]; ?>">
            </div>
            <div class="form-group">
                <label for="">Surname</label>
                <input type="text" name="lastName" class="form-control" value="<?php echo $employee["lastName"]; ?>">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $employee["email"]; ?>">
            </div>
            <form action="index.php" method="POST">
                <input type="hidden" name="id_to_update" value="<?php echo $employee["id"] ?>">
                <input name="update" class="btn btn-success" type="submit" value="Update">
            </form>
        </form>
    </div>
</body>
</html>
