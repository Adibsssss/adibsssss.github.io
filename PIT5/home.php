<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-container">
        <header>
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
            <div class="header-buttons">
                <a href="register.php" class="btn btn-primary">Add</a>
                <a href="logout.php" class="btn btn-danger">Sign Out</a>
            </div>
        </header>

        <main>
            <div class="user-table">
                <h2>Registered Users</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id, username, email, created_at FROM users";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>";
                                    echo "<a href='edit.php?id=". $row['id'] ."' class='btn btn-sm btn-primary edit-link'>Edit</a>";
                                    echo "<a href='delete.php?id=". $row['id'] ."' class='btn btn-sm btn-danger delete-link'>Delete</a>";
                                    echo "</tr>";
                                }
                                mysqli_free_result($result);
                            } else{
                                echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
                            }
                        } else{
                            echo "<tr><td colspan='5' class='text-center'>ERROR: Could not execute $sql. " . mysqli_error($conn) . "</td></tr>";
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>