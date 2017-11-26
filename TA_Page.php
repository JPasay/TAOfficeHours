<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pagesStyle.css">
    <title>Maryland</title>
</head>

<?php
  require_once("dbLogin.php");
  session_start();
$topPart = <<<EOBODY
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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script>
      $(document).ready(function () {
          $("select").change(function () {
              if (document.getElementById('classes').value === 'non') {
                  document.getElementById('code').disabled = true;
                  document.getElementById('submit').disabled = true;
              }else{
                  document.getElementById('code').disabled = false;
                  document.getElementById('submit').disabled = false;
              }
          })
      })


      //Need to change this*************************************************
      function logoClickable() {
          window.location.href='https://i.ytimg.com/vi/oqyQKOTTTJo/maxresdefault.jpg';
      }
      //Need to change this*************************************************
      function logoutClickable() {
          window.location.href='https://images-na.ssl-images-amazon.com/images/M/MV5BZjU4ZWYxNDktMDNlMi00YThhLTg3YWEtNTc0Mjg0YzAxM2UwXkEyXkFqcGdeQXVyMjUyNDk2ODc@._V1_.jpg';
      }
      </script>
EOBODY;
  

  if(isset($_SESSION['TaLoggedin']) && $_SESSION['TaLoggedin'] == true){

    $name = $_SESSION['firstname'];
  
    $topPart .= <<<EOBODY
      <body>
        <p>
        <h1>Welcome $namee </h1>
        <div>
          <br/>
          <form id="enterUser" action="{$_SERVER['PHP_SELF']}" method ="post">
            <strong><font size="4">What class are you checking in for</font></strong>
              &nbsp;&nbsp;
            <select id="classes" name ="course">
              <option value="non">Please select a class</option>
              <option value="cmsc131">CMSC131</option>
              <option value="cmsc132">CMSC132</option>
              <option value="cmsc330">CMSC330</option>
            </select>
            <br><br>
            <strong><font size="4">Please set a code</font></strong>
            <input type="text" maxlength="5" id="code" name="code" disabled required>
            <br><br>
            <input type="submit" value="Start Session" id="submit" name="submit" disabled>&nbsp;&nbsp; &nbsp;&nbsp;
            <input type="submit" value="Logout" id="submit" name="logout">

          </form>
        </div>
        </p>
      
    </body>
    </html>
EOBODY;
    $bottomPart ="";
    $db = new mysqli($host, $user, $password, $database);
    if(isset($_POST['submit'])) {
      $code = $_POST["code"];
      $course =$_POST["course"];

      $query = "UPDATE tas SET code='$code' WHERE firstName = '$name'";
      $execute = $db->query($query);

      $query2 = "UPDATE tas SET course='$course' WHERE firstName = '$name'";
      $execute2 = $db->query($query2);

      $_SESSION['workingCourse']=true;

      header('Location: TA_Queue_Screen.php');

      //create database for that actually has the queue.

    }

    //TA logs out

    if(isset($_POST['logout'])) {
      $query = "UPDATE tas SET code=0 WHERE firstName = '$name'";
      $execute = $db->query($query);

      $query2 = "UPDATE tas SET course='cmsctemp' WHERE firstName = '$name'";
      $execute2 = $db->query($query2);

      //$_SESSION['loggedin'] = false;
      $_SESSION['TaLoggedin'] = false;

      header('Location: main.php');

      //create database for that actually has the queue.

    }
  }else{
    $bottomPart .=  "<br /><br /><br /><h1>You are not logged in. Please wait to be redirected to the login page...</h1><br />";

      header("refresh:3; url=main.php");

    

      
  }
  echo $topPart.$bottomPart;
?>
