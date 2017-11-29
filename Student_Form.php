<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pagesStyle.css">
    <title>Maryland</title>
</head>
<?php
  require_once ("support.php");
  require_once ("dbLogin.php");
  session_start();

$main = <<<EOBODY
  <body>
  <div id="container">
      <header id="logoContainer">
          <span id="logo" onclick="logoClickable()">
          <br>
          <img src="images/University_of_Maryland_logo.svg">
          </span>
      </header>
      <header id="logoutContainer">
          <span id="logoutText" onclick="logoutClickable()">
              <strong>Log out</strong>
          </span>
      </header>

      

      <form action="{$_SERVER['PHP_SELF']}" method="post">
        <div id="content">
          <span id="course"><strong>Subject: $course</strong></span>
          <span id="category">
              <select id="categoryList" name="selectedCourse">
                <option value="non">Please select a category</option>
                <option value="debug">Debug</option>
                <option value="concepts">Concepts</option>
                <option value="assignment">Assignment Questions</option>
                <option value="other">Other</option>
              </select>
          </span><br><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <strong> Write a brief Description of your issue (99 characters or less):</strong>
          <div id="textArea">
              <textarea rows="5" cols="60" name="desc" maxlength="98"></textarea>
          </div><br><br>
          <div id="confirmForm">
  <!--            Need to change to the logged in student's name-->
            <input type="hidden" value="StudentNAME" name="studentName">
            <input type="submit" value="Submit" id="submit" name="submit">
            <input type="submit" value="Back" id="back" name="back">
            <input type="submit" value="Logout" id="logout" name="logout">
          </div>
        </div>
      </form>
  </div>
  </body>

  <script>

      //Need to change this*************************************************
      function logoClickable() {
          window.location.href='https://i.ytimg.com/vi/oqyQKOTTTJo/maxresdefault.jpg';
      }
      //Need to change this*************************************************
      function logoutClickable() {
          window.location.href='https://images-na.ssl-images-amazon.com/images/M/MV5BZjU4ZWYxNDktMDNlMi00YThhLTg3YWEtNTc0Mjg0YzAxM2UwXkEyXkFqcGdeQXVyMjUyNDk2ODc@._V1_.jpg';
      }
  </script>
  </html>
EOBODY;
  $bottomPart = "";
  $course = $_SESSION['course'];
  $name = $_SESSION['firstname'];
  $lname = $_SESSION['lastname'];

  if(!isset($_SESSION['studentLoggedin']) || $_SESSION['studentLoggedin'] == false){
    $bottomPart =  "<br /><br /><br /><h1>You are not logged in. Please wait to be redirected to the login page...</h1><br />";

    header("refresh:3; url=main.php");
  }

  if(isset($_SESSION['inQueue']) && $_SESSION['inQueue'] == true ){
        echo "<br /><br /><br /><h1>You are already in a queue for a course. Please wait to be redirected...</h1><br />";
        header("refresh:1.5; url=Student_Confirmation.php");
  }

  //create database for that actually has the queue.

    //Queue Database
  //DB connection
  $db = new mysqli($host, $user, $password, $database);
  if(empty($db -> query("SELECT * FROM officehourqueue"))) {
        //alert("good");
    $sql = "CREATE TABLE officehourqueue(
      firstName VARCHAR(50) NOT NULL,
      lastName VARCHAR(50) NOT NULL,
      course VARCHAR(10),
      subject VARCHAR(30),
      description VARCHAR(100),
      timesMet INT UNSIGNED NOT NULL
      )" ;
    $result = $db->query($sql);
  } 
  
  //submit button clickecd
  if(isset($_POST['submit'])){
    //we retrieve the choice of course user chose with the description
    
    $subject = $_POST['selectedCourse'];
    $desc = $_POST['desc'];
    $sql1 = "INSERT INTO officehourqueue values('$name', '$lname', '$course', '$subject', '$desc', 0) ";
    $result = $db->query($sql1);
    $_SESSION['inQueue'] = true;
    
      header('Location: Student_Confirmation.php');
      
  }
  if(isset($_POST['logout'])){
            //$_SESSION['loggedin'] = false;
            $_SESSION['studentLoggedin'] = false;
            header('Location: main.php');
  }
  if(isset($_POST['back'])){
            //$_SESSION['loggedin'] = false;
            
            header('Location: Student_HomePage.php');
  }

$page = generatePage($main.$bottomPart);
echo $page;
?>
