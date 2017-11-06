<?php
include_once('support.php');

$body=<<<EOBODY
  <h1>Main Menu</h1>
  <input type="submit" name ="submit" value="logout"/>
EOBODY;

echo generatePage($body,"Main");
?>
