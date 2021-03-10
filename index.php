<?php

include "config/db.php";

// Write query for all employees
$sql = "SELECT id, firstName, lastName, email FROM employees ORDER BY id"; // employees table

// Make query and get the result
// $conn : connect to the database
// $sql : run query
$result = mysqli_query($conn, $sql);

// Fetch the resulting row as an array
$employees = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Free result from memory - it is good coding practice
mysqli_free_result($result);

if (isset($_POST["delete"])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_POST["id_to_delete"]);

    $sql = "DELETE FROM employees WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Query Error: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);

// print_r($employees);

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
        <h1>Employee List</h1>
            <button class="btn btn-lg btn-success">
                <a href="add.php" style="text-decoration:none;color:black">Add</a>
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee["id"]); ?></td>
                        <td><?php echo htmlspecialchars($employee["firstName"]); ?></td>
                        <td><?php echo htmlspecialchars($employee["lastName"]); ?></td>
                        <td><?php echo htmlspecialchars($employee["email"]); ?></td>
                        <td>
                            <button class="btn btn-success">
                                <a href="update.php?id=<?php echo $employee["id"] ?>" style="text-decoration:none;color:white">Edit</a>
                            </button>
                        </td>
                        <td>
                            <form action="index.php" method="POST">
                                <input type="hidden" name="id_to_delete" value="<?php echo $employee["id"] ?>">
                                <input name="delete" class="btn btn-danger" type="submit" value="Remove">
                            </form>

                        </td>
                    </tr>
                <?php endforeach?>

                </tbody>
            </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>
