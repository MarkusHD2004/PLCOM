<?php
session_start();
if (!isset($_SESSION["user"])) {
  header('Location: ../login/login.php');
}
if (isset($_REQUEST["logout"])) {
  unset($_SESSION["user"]);
  header('Location: ../login/login.php');
}
$con = mysqli_connect("127.0.0.1", "root", "rootpw", "PLCOM");
if ($con == NULL) {
  die("FEHLER: Keine Verbindung zum Datenbankserver!");
}
if (isset($_REQUEST["add-project"])) {
  $symbol = str_replace(' ', '', $_REQUEST['add-project-name']);
  $trim_project = preg_replace('/[^A-Za-z0-9]/', '', $symbol);
  $sql = "SELECT * FROM `PLCOM`.`plcs` WHERE `project` = '$trim_project';";
  $result = mysqli_query($con, $sql);
  if (strlen($trim_project) > 14) {
    $_SESSION['error6'] = true;
    header('Location: ./dashboard.php');
  } else if ((int)$result->num_rows > 0) {
    $_SESSION['error2'] = true;
    header('Location: ./dashboard.php');
  } else if ($trim_project != "") {
    $sql = "INSERT INTO `PLCOM`.`plcs` (`name`, `ip`, `username`, `password`, `project`, `plc-name`) VALUES ('{$_SESSION['user']}', '0', '0', '0', '$trim_project', '0');";
    $result = mysqli_query($con, $sql);
    header('Location: ./dashboard.php');
  } else {
    $_SESSION['error4'] = true;
    header('Location: ./dashboard.php');
  }
}
if (isset($_REQUEST["edit-project"])) {
  $symbol = str_replace(' ', '', $_REQUEST['edit-project-name']);
  $trim_project = preg_replace('/[^A-Za-z0-9]/', '', $symbol);
  $sql = "SELECT * FROM `PLCOM`.`plcs` WHERE `plc-name` = '0' AND `project` = '$trim_project';";
  $result = mysqli_query($con, $sql);
  if (strlen($trim_project) > 14) {
    $_SESSION['error6'] = true;
    header('Location: ./dashboard.php');
  } else if ((int)$result->num_rows > 0) {
    $_SESSION['error2'] = true;
    header('Location: ./dashboard.php');
  } else if ($trim_project != "") {
    $sql = "UPDATE `PLCOM`.`plcs` SET `project`='$trim_project' WHERE `project`='{$_REQUEST['temp-project']}';";
    $result = mysqli_query($con, $sql);
    header('Location: ./dashboard.php');
  } else {
    $_SESSION['error4'] = true;
    header('Location: ./dashboard.php');
  }
}
if (isset($_REQUEST["delete-project"])) {
  $sql = "DELETE FROM `PLCOM`.`plcs` WHERE `project`='{$_REQUEST['temp-project']}' LIMIT 1000;";
  $result = mysqli_query($con, $sql);
  header('Location: ./dashboard.php');
}
if (isset($_REQUEST["add-plc"])) {
  $symbol = str_replace(' ', '', $_REQUEST['plc-name']);
  $trim_plc = preg_replace('/[^A-Za-z0-9]/', '', $symbol);
  $sql = "SELECT * FROM `PLCOM`.`plcs` WHERE `plc-name` = '$trim_plc';";
  $result = mysqli_query($con, $sql);
  if (strlen($trim_plc) > 21) {
    $_SESSION['error5'] = true;
    header('Location: ./dashboard.php');
  } else if ((int)$result->num_rows > 0) {
    $_SESSION['error'] = true;
    header('Location: ./dashboard.php');
  } else if ($trim_plc != "") {
    $sql = "INSERT INTO `PLCOM`.`plcs` (`name`, `ip`, `username`, `password`, `project`, `plc-name`) VALUES ('{$_SESSION['user']}', '{$_REQUEST['plc-ip']}', '{$_REQUEST['plc-username']}', '{$_REQUEST['plc-password']}', '{$_REQUEST['temp-project']}', '$trim_plc');";
    $result = mysqli_query($con, $sql);
    header('Location: ./dashboard.php');
  } else {
    $_SESSION['error3'] = true;
    header('Location: ./dashboard.php');
  }
}
if (isset($_REQUEST["edit-plc"])) {
  $symbol = str_replace(' ', '', $_REQUEST['edit-plc-name']);
  $trim_plc = preg_replace('/[^A-Za-z0-9]/', '', $symbol);
  $sql = "SELECT * FROM `PLCOM`.`plcs` WHERE `plc-name` = '$trim_plc';";
  $result = mysqli_query($con, $sql);
  if (strlen($trim_plc) > 21) {
    $_SESSION['error5'] = true;
    header('Location: ./dashboard.php');
  } else if ((int)$result->num_rows > 0) {
    $_SESSION['error'] = true;
    header('Location: ./dashboard.php');
  } else if ($trim_plc != "") {
    $sql = "UPDATE `PLCOM`.`plcs` SET `plc-name`='$trim_plc', `ip`='{$_REQUEST['edit-plc-ip']}', `username`='{$_REQUEST['edit-plc-username']}', `password`='{$_REQUEST['edit-plc-password']}' WHERE  `plc-name`='{$_REQUEST['temp-plc']}' LIMIT 1;";
    $result = mysqli_query($con, $sql);
    $sql = "UPDATE `PLCOM`.`data` SET `plc-name`='$trim_plc' WHERE  `plc-name`='{$_REQUEST['temp-plc']}' LIMIT 1000;";
    $result = mysqli_query($con, $sql);
    header('Location: ./dashboard.php');
  } else {
    $_SESSION['error3'] = true;
    header('Location: ./dashboard.php');
  }
}
if (isset($_REQUEST["delete-plc"])) {
  $sql = "DELETE FROM `PLCOM`.`plcs` WHERE `plc-name`='{$_REQUEST['temp-plc']}' LIMIT 1;";
  $result = mysqli_query($con, $sql);
  header('Location: ./dashboard.php');
}
if (isset($_REQUEST["add-variable"])) {
  $sql = "INSERT INTO `PLCOM`.`data` (`name`, `plc-name`) VALUES ('{$_SESSION['user']}', '{$_REQUEST['plc']}');";
  $result = mysqli_query($con, $sql);
  header('Location: ./dashboard.php?plc=' . $_REQUEST['plc']);
}
if (isset($_REQUEST["edit"])) {
  if (isset($_REQUEST["edit-data"])){
    
  }
  $sql = "UPDATE `PLCOM`.`data` SET `program-block`='{$_REQUEST['program-block']}', `variable`='{$_REQUEST['variable']}' WHERE  `name`='{$_SESSION['user']}' AND `plc-name`='{$_REQUEST['plc']}' AND `id`='{$_REQUEST['id']}' LIMIT 1;";
  $result = mysqli_query($con, $sql);
  header('Location: ./dashboard.php?plc=' . $_REQUEST['plc']);
}
if (isset($_REQUEST["delete-variable"])) {
  $sql = "DELETE FROM `PLCOM`.`data` WHERE `id`='{$_REQUEST['delete-variable']}' LIMIT 1;";
  $result = mysqli_query($con, $sql);
  header('Location: ./dashboard.php?plc=' . $_REQUEST['plc']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./dashboard.css" />
  <link rel="icon" type="image/png" href="../assets/Icon.png" />
  <script src="./dashboard.js" defer></script>
  <title>PLCOM</title>
</head>

<body>
  <header>
    <form method="GET">
      <div class="header-container">
        <label class="header-name">PLCOM</label>
        <button class="logout" name="logout" type="submit">
          <img src="../assets/Logout.png" />
        </button>
      </div>
    </form>
  </header>
  <nav>
    <div class="nav-container">
      <input id="add-project" class="add-project" value="Add project" type="button" onclick="document.getElementById('add-project-main').style.visibility='visible';document.getElementById('add-plc').style.visibility='hidden';document.getElementById('plc-main').style.visibility='hidden';if(document.getElementById('plc-data-column')){document.getElementById('plc-data-column').style.visibility='hidden';}if(document.getElementById('error')){document.getElementById('error').style.visibility='hidden';}">
      <?php
      $sql = "SELECT `name`, `ip`, `username`, `password`, `project`, `plc-name` FROM `PLCOM`.`plcs` WHERE `name`='{$_SESSION['user']}' ORDER BY `project` ASC LIMIT 1000;";
      $result = mysqli_query($con, $sql);
      while ($row = mysqli_fetch_array($result)) {
        if ($row['project'] != $temp) {
          print("<div class='project'><input class='project-name' value='$row[project]  ➕' type='button' onclick=document.getElementById('edit-project').value='$row[project]';document.getElementById('temp-project').value='$row[project]';document.getElementById('add-plc').style.visibility='visible';document.getElementById('add-project-main').style.visibility='hidden';document.getElementById('plc-main').style.visibility='hidden';if(document.getElementById('plc-data-column')){document.getElementById('plc-data-column').style.visibility='hidden';}if(document.getElementById('error')){document.getElementById('error').style.visibility='hidden';}></div>");
        }
        $temp = $row['project'];
        $temp2 = $row['plc-name'];
        if ($temp2 != '0') {
          print("<div class='plc'><input class='plc-name' value='$temp2' type='button' onclick=document.getElementById('edit-plc-name-id').value='$temp2';document.getElementById('edit-plc-ip-id').value='$row[ip]';document.getElementById('edit-plc-username-id').value='$row[username]';document.getElementById('edit-plc-password-id').value='$row[password]';document.getElementById('temp-plc').value='$temp2';document.getElementById('plc-main').style.visibility='visible';document.getElementById('add-project-main').style.visibility='hidden';document.getElementById('add-plc').style.visibility='hidden';if(document.getElementById('plc-data-column')){document.getElementById('plc-data-column').style.visibility='hidden';}if(document.getElementById('error')){document.getElementById('error').style.visibility='hidden';}></div>");
        }
      }
      ?>
    </div>
  </nav>
  <main>
    <div class="main-container">
      <?php
      if ($_SESSION['error'] == true) {
        $_SESSION['count'] += 1;
        print("<p id='error' class='error'>Adding/Editing PLC failed! PLC-Name already exists!</p>");
        if ($_SESSION['count'] % 2 == 0) {
          $_SESSION['error'] = false;
        }
      }
      if ($_SESSION['error2'] == true) {
        $_SESSION['count'] += 1;
        print("<p id='error' class='error'>Adding/Editing project failed! Project-Name already exists!</p>");
        if ($_SESSION['count'] % 2 == 0) {
          $_SESSION['error2'] = false;
        }
      }
      if ($_SESSION['error3'] == true) {
        $_SESSION['count'] += 1;
        print("<p id='error' class='error'>Adding/Editing PLC failed! PLC-Name cannot be empty!</p>");
        if ($_SESSION['count'] % 2 == 0) {
          $_SESSION['error3'] = false;
        }
      }
      if ($_SESSION['error4'] == true) {
        $_SESSION['count'] += 1;
        print("<p id='error' class='error'>Adding/Editing project failed! Project-Name cannot be empty!</p>");
        if ($_SESSION['count'] % 2 == 0) {
          $_SESSION['error4'] = false;
        }
      }
      if ($_SESSION['error5'] == true) {
        $_SESSION['count'] += 1;
        print("<p id='error' class='error'>Adding/Editing PLC failed! PLC-Name is too long! Maximum length is 21 Letters!</p>");
        if ($_SESSION['count'] % 2 == 0) {
          $_SESSION['error5'] = false;
        }
      }
      if ($_SESSION['error6'] == true) {
        $_SESSION['count'] += 1;
        print("<p id='error' class='error'>Adding/Editing project failed! Project-Name is too long! Maximum length is 14 Letters!</p>");
        if ($_SESSION['count'] % 2 == 0) {
          $_SESSION['error6'] = false;
        }
      }
      ?>
      <form method="POST">
        <div id="add-project-main" class="add-project-main">
          <a>Add new project</a>
          <input name="add-project-name" type="text" placeholder="Project name" required />
          <button name="add-project" class="add" type="submit">Add</button>
        </div>
      </form>
      <form method="POST">
        <div id="add-plc" class="add-plc">
          <a>Add new PLC</a>
          <input name="plc-name" type="text" placeholder="PLC-Name" required />
          <input name="plc-ip" type="text" placeholder="IP-Adress" required />
          <input name="plc-username" type="text" placeholder="Username" required />
          <input name="plc-password" type="password" placeholder="Password" required />
          <button name="add-plc" class="add" type="submit">Add</button>
          <a>Edit project</a>
          <input id="edit-project" name="edit-project-name" type="text" required />
          <button name="edit-project" class="add" type="submit" formnovalidate>Edit</button>
          <input id="temp-project" name="temp-project" class="temp">
          <button name="delete-project" class="delete-project" type="submit" formnovalidate>Delete project</button>
      </form>
    </div>
    <form method="GET">
      <div id="plc-main" class="plc-main">
        <a>Edit PLC</a>
        <input id="edit-plc-name-id" name="edit-plc-name" type="text" placeholder="PLC-Name" required />
        <input id="edit-plc-ip-id" name="edit-plc-ip" type="text" placeholder="IP-Adress" required />
        <input id="edit-plc-username-id" name="edit-plc-username" type="text" placeholder="Username" required />
        <input id="edit-plc-password-id" name="edit-plc-password" type="password" placeholder="Password" required />
        <button name="edit-plc" class="add" type="submit">Edit</button>
        <button name="delete-plc" class="delete-plc" type="submit" formnovalidate>Delete PLC</button>
        <input id="temp-plc" name="temp-plc" class="temp">
        <button class="show-plc" type="submit" name="plc">Show PLC data</button>
      </div>
    </form>
    <?php
    if (isset($_REQUEST["plc"])) {
      print("<div id='plc-data-column' class='plc-data-column'>");
      print("<a class='variables'>Variables</a>");
      if (isset($_REQUEST['edit-plc-name'])) {
        $plc_name = $_REQUEST['edit-plc-name'];
      } else {
        $plc_name = $_REQUEST['plc'];
      }
      $sql = "SELECT `id`, `name`, `plc-name`, `program-block`, `variable` FROM `PLCOM`.`data` WHERE `name`='{$_SESSION['user']}' AND `plc-name`='$plc_name' ORDER BY `program-block` ASC LIMIT 1000;";
      $result = mysqli_query($con, $sql);
      while ($row = mysqli_fetch_array($result)) {
        print("<form method='GET'>");
        print("            
                <div class='plc-data'>
                <input value='{$row['program-block']}' name='program-block' id='{$row['program-block']}' placeholder='Program block' type='text'>
                <input value='{$row['variable']}' name='variable' id='{$row['variable']}' placeholder='Variable' type='text'>
                <input id='{$row['data']}' placeholder='Data' type='text' >
                <input name='edit-data' id='edit-data' placeholder='Edit data' type='text'>
                <input name='id' value='{$row['id']}' class='temp'>
                <input name='plc' value='$plc_name' class='temp'>
                <button class='add' type='submit' name='edit'>Edit</button>
                <button name='delete-variable' class='delete-variable' type='submit' value='{$row['id']}'>X</button>
                </div>");
        print("</form>");
      }
      print("<form method='GET'>");
      print("<input name='plc' value='$plc_name' class='temp'>");
      print("<button name='add-variable' class='add' type='submit' >Add</button>");
      print("</form>");
    }
    ?>
  </main>
</body>

</html>