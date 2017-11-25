<?php
  require_once("dbLogin.php");
  session_start();
$topPart = <<<EOBODY
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Home Page</title>
      <link rel="stylesheet" href="mainPageStyle.css" />
  </head>

  <button id="loginBUtton">Welcome to UMD's queue sytem <br> click me to proceed</button>

  <div id="popUp" class="popUpScreen">
      <form class="loginBox animate" action="{$_SERVER['PHP_SELF']}" method ="post">
          <div class="imgContainer">
              <img id="logo" src="images/logo_top_bottom.png">
          </div>
          <h2><u>Login</u></h2>
          <div class="container">
              <!--<label><b>Username</b></label><br>-->
              <input type="text" placeholder="Enter UID" name="userName" required><br><br>

              <!--<label><b>Password</b></label><br>-->
              <input type="password" placeholder="Enter Password" name="password" required><br><br>

              <input type="submit" name="submit" value="Sign in">
              <br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="http://nooooooooooooooo.com/">Forgot Password</a>
          </div>
      </form>
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
  </html>
EOBODY;
  //DB connection
  $db = new mysqli($host, $user, $password, $database);
  // if ($db->connect_error) {
	// 	die($db->connect_error);
	// } else {
	// 	echo "Connection to database established<br><br>";
	// }

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
    // if (!$result) {
  	// 	die("Insertion failed: " . $db->error);
  	// } else {
  	// 	echo "Insertion completed.<br>";
  	// }
    $hashed = password_hash(123, PASSWORD_DEFAULT);
    $query = "INSERT INTO queue_system values('John', 'Appleseed', 'japple', '$hashed', 0)";
    $res = $db->query($query);
    // if (!$res) {
  	// 	die("Insertion failed: " . $db->error);
  	// } else {
  	// 	echo "Insertion completed.<br>";
  	// }
    $hashed2 = password_hash(1234, PASSWORD_DEFAULT);
    $query2 = "INSERT INTO queue_system values('Bob', 'Smith', 'bsmith', '$hashed2', 0)";
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

  //Queue Database
  if(empty($db -> query("SELECT * FROM queue"))) {
    $sql = "CREATE TABLE queue(
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    directoryID VARCHAR(50) NOT NULL PRIMARY KEY,
    timesMet INT UNSIGNED NOT NULL
    )";
    $result = $db->query($sql);
  }


  $bottomPart="";
  //Verify password to login
  if(isset($_POST["submit"])) {
    $UID = trim($_POST["userName"]);
    $loginPass = trim($_POST["password"]);
    $pass = "SELECT password FROM queue_system where directoryID = '$UID'";
    $loginUID = $db->query($pass);
    $userPass = $loginUID->fetch_array(MYSQLI_ASSOC);
    if(!$pass || !password_verify($loginPass, $userPass['password'])) {
      $bottomPart = "<strong> Incorrect login credentials</strong>";
    }
    if($bottomPart === ""){
      $_SESSION['UID'] = $UID;
      header('Location: Student_HomePage.php');
    }
  }

  echo $topPart.$bottomPart;
?>
