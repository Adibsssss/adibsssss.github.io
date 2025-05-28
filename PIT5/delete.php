<?php
session_start();

require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_POST['delete'])) {
    $user_id_to_delete = $_POST["id"];

    if ($user_id_to_delete == $_SESSION["id"] || $_SESSION["username"] == 'admin') {
        $sql = "DELETE FROM users WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $user_id_to_delete;

            if (mysqli_stmt_execute($stmt)) {
                if ($user_id_to_delete == $_SESSION["id"]) {
                    session_destroy();
                }
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    } else {
        header("location: error.php");
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Delete Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert alert-danger">
                <p>Are you sure you want to delete this account?</p>
                <p>This action cannot be undone.</p>
            </div>
            <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>" />
            <div class="form-group">
                <button type="submit" name="delete" class="btn btn-danger">Yes</button>
                <a href="home.php" class="btn btn-default">No</a>
            </div>
        </form>
    </div>
</body>

</html>