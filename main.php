<?php
require_once("dbLogin.php");
session_start();
if(isset($_SESSION['studentLoggedin']) && $_SESSION['studentLoggedin'] == true){

    //checking if the student has already be put into the quuee for a course
    if($_SESSION['inQueue'] == true){
        echo "<br /><br /><br /><h1>You are already in a queue for a course. Please wait to be redirected...</h1><br />";
        header("refresh:1.5; url=Student_Confirmation.php");
    }else{
        echo "<br /><br /><br /><h1>You are already logged in. Please wait to be redirected...</h1><br />";
        header("refresh:1.5; url=Student_HomePage.php");
    }

}
if(isset($_SESSION['TaLoggedin']) && $_SESSION['TaLoggedin'] == true){
    if(isset($_SESSION['workingCourse']) && $_SESSION['workingCourse'] == true){
        echo "<br /><br /><br /><h1>You are already logged in. Please wait to be redirected...</h1><br />";
        header('Location: TA_Queue_Screen.php');
    }else{
        echo "<br /><br /><br /><h1>You are already logged in. Please wait to be redirected...</h1><br />";
        header("refresh:1.5; url=TA_Page.php");
    }

}
$topPart = <<<EOBODY
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Home Page</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <!--<button id="loginBUtton">Welcome to UMD's queue system <br> click me to proceed</button>-->
  <div class row="row">
  <div class="col-xs-6 col-xs-offset-3 text-center" >
      <form class="loginBox animate" action="{$_SERVER['PHP_SELF']}" method ="post">
      <div class = "img-responsive">
              <img id="logo" src="images/logo_top_bottom.png" height="200" width = "200">
              </div>
          <h2><u>Login</u></h2>
              <!--<label><b>Username</b></label><br>-->
              <input type="text" placeholder="Enter UID" name="userName" required><br><br>
              <!--<label><b>Password</b></label><br>-->
              <input type="password" placeholder="Enter Password" name="password" required><br><br>
              <input type="submit" name="submit" value="Sign in as Student"> &nbsp;&nbsp;&nbsp;&nbsp;
              <input type="submit" name="submitTA" value="Sign in as TA">
              <br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="http://nooooooooooooooo.com/">Forgot Password</a>
      </form>
  </div>
  </div>
  <script>
      let button = document.getElementById('loginBUtton');
      button.addEventListener('click', loginButton, false);
      function loginButton() {
          document.getElementById('popUp').style.display='block';
          this.style.display = 'none';
      }
      let pop = document.getElementById('popUp');
      window.onclick = function(event) {
          if (event.target == pop) {
              pop.style.display = "none";
              button.style.display = "block";
          }
      }
  </script>
  <script src="bootstrap/jquery-3.2.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  </html>
EOBODY;
//DB connection
$db = new mysqli($host, $user, $password, $database);
// if ($db->connect_error) {
// 	die($db->connect_error);
// } else {
// 	echo "Connection to database established<br><br>";
// }
//Create a Student db if it doesn't exist with test student info.
if(empty($db -> query("SELECT * FROM queue_system"))){
    $sql = "CREATE TABLE queue_system(
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    directoryID VARCHAR(50) NOT NULL PRIMARY KEY,
    email VARCHAR(50),
    password VARCHAR(200) NOT NULL,
    timesMet INT UNSIGNED NOT NULL
    )";
    $result = $db->query($sql);
    // if (!$result) {
    // 	die("Insertion failed: " . $db->error);
    // } else {
    // 	echo "Insertion completed.<br>";
    // }
    $hashed = password_hash(123, PASSWORD_DEFAULT);
    $query = "INSERT INTO queue_system values('John', 'Appleseed', 'japple', 'john.appleseed@gmail.com', '$hashed', 0)";
    $res = $db->query($query);
    // if (!$res) {
    // 	die("Insertion failed: " . $db->error);
    // } else {
    // 	echo "Insertion completed.<br>";
    // }
    $hashed2 = password_hash(1234, PASSWORD_DEFAULT);
    $query2 = "INSERT INTO queue_system values('Bob', 'Smith', 'bsmith', 'bob.smith@yahoo.com', '$hashed2', 0)";
    $res2 = $db->query($query2);
    // if (!$res2) {
    // 	die("Insertion failed 2: " . $db->error);
    // } else {
    // 	echo "Insertion completed.<br>";
    // }
}
//creates ta database
if(empty($db -> query("SELECT * FROM tas"))) {
    $sql = "CREATE TABLE tas(
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    directoryID VARCHAR(50) NOT NULL PRIMARY KEY,
    email VARCHAR(50),
    password VARCHAR(300) NOT NULL,
    course VARCHAR(100) NOT NULL,
    code INT UNSIGNED NOT NULL
    )";
    $result = $db->query($sql);
    $hashed = password_hash(111, PASSWORD_DEFAULT);
    $query = "INSERT INTO tas values('Lady', 'Gaga', 'lgaga', 'lady.gaga@gmail.com', '$hashed', 'cmsctemp', 0)";
    $res = $db->query($query);
    $hashed2 = password_hash(222, PASSWORD_DEFAULT);
    $query2 = "INSERT INTO tas values('John', 'Cena', 'jcena', 'john.cena@gmail.com', '$hashed2', 'cmsctemp', 0)";
    $res2 = $db->query($query2);
}
//Queue Database
/* if(empty($db -> query("SELECT * FROM queue"))) {
   $sql = "CREATE TABLE queue(
   firstName VARCHAR(50) NOT NULL,
   lastName VARCHAR(50) NOT NULL,
   directoryID VARCHAR(50) NOT NULL PRIMARY KEY,
   timesMet INT UNSIGNED NOT NULL
   )";
   $result = $db->query($sql);
 }
*/
$bottomPart="";



 if(empty($db -> query("SELECT * FROM imageContainer"))) {
   $sql = "CREATE TABLE imageContainer(
   id INT UNSIGNED NOT NULL,
   image BLOB
   )";
   $result = $db->query($sql);

   $imgQuery = "INSERT INTO imageContainer(id, image) VALUES (1, 'images/logo_top_bottom.png')";
   $imgRes = $db->query($imgQuery);
   $imgQuery2 = "INSERT INTO imageContainer(id, image) VALUES (1, 'images/Lady_Gaga.jpg')";
   $imgRes2 = $db->query($imgQuery2);
   $imgQuery3 = "INSERT INTO imageContainer(id, image) VALUES (1, 'images/John_Cena.jpg')";
   $imgRes3 = $db->query($imgQuery3);
 }



//Verify if either submit button were pressed/
if(isset($_POST["submit"]) || isset($_POST["submitTA"])) {
    $UID = trim($_POST["userName"]);
    $loginPass = trim($_POST["password"]);
    //checking the the login info are right for STUDENTS
    if(isset($_POST["submit"])) {
        $pass = "SELECT password FROM queue_system where directoryID = '$UID'";
        $loginUID = $db->query($pass);
        $userPass = $loginUID->fetch_array(MYSQLI_ASSOC);
        if(!$pass || !password_verify($loginPass, $userPass['password'])) {
            $bottomPart = "<h1>Incorrect login credentials</h1>";
        }else{
            $query = "SELECT firstName FROM queue_system WHERE directoryID = '$UID'";
            $name2 = $db->query($query);
            $name3 = $name2->fetch_array(MYSQLI_ASSOC);
            $name = $name3["firstName"];
            //$_SESSION['loggedin'] = true;
            $_SESSION['firstname'] = $name;
            $_SESSION['studentLoggedin'] = true;
            //Getting the last name and store it in the session
            $query1 = "SELECT lastName FROM queue_system WHERE directoryID = '$UID'";
            $lname2 = $db->query($query1);
            $lname3 = $lname2->fetch_array(MYSQLI_ASSOC);
            $lname = $lname3["lastName"];
            $_SESSION['lastname'] = $lname;
            header('Location: Student_HomePage.php');
        }
    }
    //checking the the login info are right for TA
    else{
        $pass = "SELECT password FROM tas where directoryID = '$UID'";
        $loginUID = $db->query($pass);
        $userPass = $loginUID->fetch_array(MYSQLI_ASSOC);
        if(!$pass || !password_verify($loginPass, $userPass['password'])) {
            $bottomPart = "<br /><h1> Incorrect login credentials</h1><br />";
        }else{
            $query = "SELECT firstName FROM tas WHERE directoryID = '$UID'";
            $name2 = $db->query($query);
            $name3 = $name2->fetch_array(MYSQLI_ASSOC);
            $name = $name3["firstName"];
            //$_SESSION['loggedin'] = true;
            $_SESSION['firstname'] = $name;
            $_SESSION['TaLoggedin'] = true;
            header('Location: TA_Page.php');
        }
    }
}
echo $topPart.$bottomPart;
?>
