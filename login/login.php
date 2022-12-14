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
    $hash = md5($_REQUEST["password"]);
    $sql = "SELECT * FROM users WHERE users.name = '{$_REQUEST['name']}' AND users.password = '$hash';";
    $result = mysqli_query($con, $sql);
    if ((int)$result->num_rows > 0) {
        $_SESSION["user"] = $_REQUEST['name'];
        header('Location: ../dashboard/dashboard.php');
    } else {
        header('Location: ./login.php?error=');
    }
}
if (isset($_REQUEST["error"])) {
    $error = true;
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
                <span>Login</span>
            </div>
            <div class="name">
                <input name="name" type="text" placeholder="Username" required>
            </div>
            <div class="password">
                <input name="password" type="password" placeholder="Password" required>
            </div>
            <div class="button">
                <button name="button" type="submit">Submit</button>
            </div>
            <div class="register">
                <a href="./register.php">Register User</a>
            </div>
            <div>
                <?php if ($error == true) {
                    print("<p class='error'>Login failed! Either name or password is wrong!</p>");
                    $error = false;
                } ?>
            </div>
        </main>
    </form>
</body>

</html>