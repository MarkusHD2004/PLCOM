<?php
session_start();
if (isset($_SESSION["user"])) {
    header('Location: ../dashboard/dashboard.php');
}
$con = mysqli_connect("127.0.0.1", "root", "rootpw", "PLCOM");
if ($con == NULL) {
    die("FEHLER: Keine Verbindung zum Datenbankserver!");
}
if (isset($_REQUEST["button"])) {
    $sql = "SELECT * FROM users WHERE users.name = '{$_REQUEST['name']}';";
    $result = mysqli_query($con, $sql);
    if ((int)$result->num_rows > 0) {
        header('Location: ./register.php?error=');
    } else {
        if ($_REQUEST["password"] == $_REQUEST["confirm-password"]) {
            $hash = md5($_REQUEST["password"]);
            $sql = "INSERT INTO `PLCOM`.`users` (`name`, `password`) VALUES ('{$_REQUEST['name']}', '$hash');";
            $result = mysqli_query($con, $sql);
            $_SESSION["user"] = $_REQUEST['name'];
            header('Location: ../dashboard/dashboard.php');
        } else {
            header('Location: ./register.php?error2=');
        }
    }
}
if (isset($_REQUEST["error"])) {
    $error = true;
  }
  if (isset($_REQUEST["error2"])) {
    $error2 = true;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <link rel="icon" type="image/png" href="../assets/Icon.png">
    <title>PLCOM</title>
</head>

<body>
    <form method="POST">
        <main class="container">
            <div class="text">
                <span>Register</span>
            </div>
            <div class="name">
                <input name="name" type="text" placeholder="Username" required>
            </div>
            <div class="password">
                <input name="password" type="password" placeholder="Password" required>
            </div>
            <div class="confirm-password">
                <input name="confirm-password" type="password" placeholder="Confirm Password" required>
            </div>
            <div class="button">
                <button name="button" type="submit">Submit</button>
            </div>
            <div class="register">
                <a href="./login.php">Login</a>
            </div>
            <div>
                <?php if($error1 == true){print("<p class='error'>Register failed! The username already exists!</p>"); $error1 = false;}?>
                <?php if($error2 == true){print("<p class='error'>Register failed! Check the Confirm Password!</p>"); $error2 = false;}?>
            </div>
        </main>
    </form>
</body>

</html>