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
    $firstname = $_SESSION['firstname'];
    $lastname  = $_SESSION['lastname'];
    $course = $_SESSION['course'];

    //no user looged in
    if(!isset($_SESSION['studentLoggedin']) || $_SESSION['studentLoggedin'] == false || !isset($_SESSION['inQueue'])){
    $bottomPart =  "<br /><br /><br /><h1>You are not logged in. Please wait to be redirected to the login page...</h1><br />";

    header("refresh:3; url=main.php");
  }
    if(isset($_SESSION['inQueue']) && $_SESSION['inQueue'] == false ){
        echo "<br /><br /><br /><h1>You are not already in a queue for a course. Please wait to be redirected to the Student form...</h1><br />";
        header("refresh:1.5; url=Student_Form.php");
    }



    //$class = $_SESSION['course'];
    $whichClass = "officehourqueueFor" . $course;

    //retrieving the rank
    $db = new mysqli($host, $user, $password, $database);

    
    //checking if the Ta has deleted the queue list by login out
    $query = "SELECT * FROM `{$whichClass}` ";
    $yo = $db->query($query);



    /*if(!($query)){
        echo "<br /><br /><br /><h1>The TA has just left. Sorry you missed him. Please wait to be redirected to the Student Home page...</h1><br />";
        $_SESSION['inQueue'] = false;
        header("refresh:3; url=Student_HomePage.php");
    }*/



    $query = "SELECT rank FROM `{$whichClass}` WHERE firstName = '$firstname' AND lastName = '$lastname' ";
    $query2 = $db->query($query);

    if(!($query2)){
        echo "<br /><br /><br /><h1>You have lost your place in the Queue. Please wait to be redirected to the Student Home page...</h1><br />";
        $_SESSION['inQueue'] = false;
        header("refresh:2; url=Student_HomePage.php");
    }else{
        $ranking = $query2->fetch_array(MYSQLI_ASSOC);
        $phrase = "Refresh the page to updapte your rank";
        if($ranking["rank"] == 1){
            $ranking = "1 ";
            $phrase = "Hurry. Go see him before you loose your spot";
        }else{
            $ranking= "no more in line";
            $phrase = ""
        }
    }
    

$body = <<< EOBODY
<body>
<div id="container">
    <header id="logoContainer">
        <span id="logo" onclick="logoClickable()">
        </br>
        <img src="images/University_of_Maryland_logo.svg">
        </span>
    </header>
    <header id="logoutContainer">
        <span id="logoutText" onclick="logoutClickable()">
            <strong>Log out</strong>
        </span>
    </header>
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

    <div id="content">
        <p>
            <h1>$firstname, you are number $ranking in line to meet with the TA. $phrase.
            </h1>
        </p>
        <br>
        <br>
        <form id="rank" action="{$_SERVER['PHP_SELF']}" method="post">
            <input type="submit" value="Exit" id="exit" name="exit">
            <input type="submit" value="Logout" id="logout" name="logout">
            <br>
            <strong>Caution: Logging out will automaticaly remove your name from the queue.</strong></br>
            <strong>Caution: Exit will automaticaly remove your name from the queue and take you back to the Student form.</strong>
        </form>

    </div>
</div>
</body>
EOBODY;

    //$db = new mysqli($host, $user, $password, $database);
    if(isset($_POST['logout'])){
            //$_SESSION['loggedin'] = false;
            $_SESSION['studentLoggedin'] = false;
            $_SESSION['inQueue'] = false;

            //delete the student from the queue
            $query="DELETE FROM `{$whichClass}` WHERE firstName ='$firstname' AND lastName ='$lastname' ";
            $result = $db->query($query);

            //drop the rank table 
            $query = "ALTER TABLE `{$whichClass}` DROP COLUMN rank";
            $result = $db->query($query);


            //put the rank table backkkkk
            $query = "ALTER TABLE `{$whichClass}` ADD COLUMN rank INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
            $result = $db->query($query);


            header('Location: main.php');
    }
    if(isset($_POST['exit'])){
            $_SESSION['inQueue'] = false;

            //the student from the queue
            $query="DELETE FROM `{$whichClass}` WHERE firstName ='$firstname' AND lastName ='$lastname' ";
            $result = $db->query($query);

            //drop the rank table 
            $query = "ALTER TABLE `{$whichClass}` DROP COLUMN rank";
            $result = $db->query($query);


            //put the rank table backkkkk
            $query = "ALTER TABLE `{$whichClass}` ADD COLUMN rank INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
            $result = $db->query($query);

            header('Location: Student_HomePage.php');
    }

echo $body;
?>

</html>
