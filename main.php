<?php
session_start();
include_once('support.php');

$host = "localhost";
$user = "dbuser";
$password = "goodbyeWorld";
$database = "tabledb";
$table = "students";
$body="";
$db= connectToDB($host, $user, $password, $database);

$pass=$_POST['password'];
$sqlQuery= sprintf("select * from %s where UID='%s' and password='%s' ",$table, $_POST['username'],$_POST['password']);
$result= mysqli_query($db, $sqlQuery);
if($result){
	$numberOfRows= mysqli_num_rows($result);
	if($numberOfRows==0){
		$body= "<h2> No entry exits in the database with the specified UID or Password</h2>";
	}else{
		$body=<<<EOBODY
  		<h2>List of Registered Classes</h2>
  		<form action="queue.php" method="get">
  			<ul>

 	 		<li>CMSC 320 &nbsp; &nbsp; &nbsp; <input type="submit" name ="320" value="Enter QUEUE"/>
  			</li>
  			</br>
  			<li>CMSC 389 &nbsp; &nbsp; &nbsp; <input type="submit" 	name ="389" value="Enter QUEUE"/>
  			</li>
  			</br>
  			<li>CMSC 433 &nbsp; &nbsp; &nbsp; <input type="submit" name ="433" value="Enter QUEUE"/>
  			</li>


  			</ul>
  		</form>
  		</br>
 		<input type="submit" name ="submit" value="logout"/>
EOBODY;
	}
}else{
	$body= "<h2> Error/h2>";
}


echo generatePage($body,"Main");
?>
