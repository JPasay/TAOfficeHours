<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pagesStyle.css">
    <title>Maryland</title>
</head>
<?php
  session_start();
  $course = $_SESSION["course"];


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
      <form action="Student_Confirmation.php" method="post">
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
          <strong> Write a brief Description of your issue:</strong>
          <div id="textArea">
              <textarea rows="10" cols="53" name="desc"></textarea>
          </div><br><br>
          <div id="confirmForm">
  <!--            Need to change to the logged in student's name-->
              <input type="hidden" value="StudentNAME" name="studentName">
              <input type="submit" value="Submit">
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



echo $main;
?>
