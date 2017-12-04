<?php
include_once('support.php');
require_once("dbLogin.php");
session_start();
$body = <<<EOBODY
  <h1>TA Office Hours Queue</h1>
  <form action="{$_SERVER['PHP_SELF']}" method="post">
  <div class="credential"
    <label><b>Username</b></label>
    <input type ="text" placeholder="Enter UID" name = "username" required/>

    <label><b>Password</b></label>
    <input type ="text" placeholder="Enter Password" name="password" required/>
  </div><br>
  <div class="button">
    <input type="submit" class="submitButton" name ="submit" value="Login">
  </div>
  </form>
EOBODY;

//DB connection
$db = new mysqli($host, $user, $password, $database);

if(empty($db -> query("SELECT * FROM tas"))) {
  $sql = "CREATE TABLE tas(
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  directoryID VARCHAR(50) NOT NULL PRIMARY KEY,
  password VARCHAR(300) NOT NULL,
  course VARCHAR(100) NOT NULL,
  code INT UNSIGNED NOT NULL
  )";
  $result = $db->query($sql);

  $hashed = password_hash(111, PASSWORD_DEFAULT);
  $query = "INSERT INTO tas values('Lady', 'Gaga', 'lgaga', '$hashed', 'cmsctemp', 0)";
  $res = $db->query($query);

  $hashed2 = password_hash(222, PASSWORD_DEFAULT);
  $query2 = "INSERT INTO tas values('John', 'Cena', 'jcena', '$hashed2', 'cmsctemp', 0)";
  $res2 = $db->query($query2);
}

//Create a db if it doesn't exist with test student info.
if(empty($db -> query("SELECT * FROM queue_system"))){
  $sql = "CREATE TABLE queue_system(
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  directoryID VARCHAR(50) NOT NULL PRIMARY KEY,
  password VARCHAR(200) NOT NULL,
  timesMet INT UNSIGNED NOT NULL
  )";
  $result = $db->query($sql);

  $hashed = password_hash(123, PASSWORD_DEFAULT);
  $query = "INSERT INTO queue_system values('John', 'Appleseed', 'japple', '$hashed', 0)";
  $res = $db->query($query);

  $hashed2 = password_hash(1234, PASSWORD_DEFAULT);
  $query2 = "INSERT INTO queue_system values('Bob', 'Smith', 'bsmith', '$hashed2', 0)";
  $res2 = $db->query($query2);

}

//Queue database
if(empty($db -> query("SELECT * FROM queue"))) {
  $sql = "CREATE TABLE queue(
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  directoryID VARCHAR(50) NOT NULL PRIMARY KEY,
  timesMet INT UNSIGNED NOT NULL
  )";
  $result = $db->query($sql);
}

  $bottomPart = "";

  if(isset($_POST['submit'])) {
    $UID = trim($_POST["username"]);
    $loginPass = trim($_POST["password"]);
    $pass = "SELECT password FROM tas where directoryID = '$UID'";
    $loginUID = $db->query($pass);
    $userPass = $loginUID->fetch_array(MYSQLI_ASSOC);
    if(!$loginUID || !password_verify($loginPass, $userPass['password'])) {
      $bottomPart = "<strong> Incorrect login credentials</strong>";
    }
    if($bottomPart === ""){
      $_SESSION['UID'] = $UID;
      header('Location: TA_Page.php');
    }
  }

echo generatePage($body.$bottomPart,"Login Page");
?>
