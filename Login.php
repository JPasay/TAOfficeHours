<?php
include_once('support.php');
$body = <<<EOBODY
  <h1>TA Office Hours Queue</h1>
  <form action="main.php" method="post">
  <div class="credential"
    <label><b>Username</b></label>
    <input type ="text" placeholder="Enter UID" name = "username" required/>

    <label><b>Password</b></label>
    <input type ="text" placeholder="Enter Password" name="password" required/>
  </div>
  <div class="button">
    <input type="submit" class="submitButton" name ="submit" value="Login">
  </div>
  </form>
EOBODY;

echo generatePage($body,"Login Page");
?>
