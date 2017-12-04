<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pagesStyle.css">
    <title>Maryland</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
    require_once ("support.php");
    require_once ("dbLogin.php");
     session_start();
     $name = $_SESSION['firstname'];
$main = <<< EOBODY
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
         });
        //Need to change this*************************************************
        function logoClickable() {
            window.location.href='https://i.ytimg.com/vi/oqyQKOTTTJo/maxresdefault.jpg';
        }
        //Need to change this*************************************************
        function logoutClickable() {
            window.location.href='https://images-na.ssl-images-amazon.com/images/M/MV5BZjU4ZWYxNDktMDNlMi00YThhLTg3YWEtNTc0Mjg0YzAxM2UwXkEyXkFqcGdeQXVyMjUyNDk2ODc@._V1_.jpg';
        }
        </script>
    </div>
    </body>
EOBODY;
    if(isset($_SESSION['studentLoggedin']) && $_SESSION['studentLoggedin'] == true){
        /*$db = new mysqli($host, $user, $password, $database);
        $userN = $_SESSION['firstname'];
        $query = "SELECT firstName FROM queue_system WHERE directoryID = '$userN'";
        $name2 = $db->query($query);
        $name3 = $name2->fetch_array(MYSQLI_ASSOC);*/
        
    // if (!$name2) {
    //  die("Insertion failed 2: " . $db->error);
    // } else {
    //  echo "Insertion completed.<br>";
    // }
    $main .= <<< EOBODY
        <body>
        <div id ="content">
            <p>
        
            <h2>Welcome  $name</h2>
            
            <br/>
            <form id="enterUser" action="{$_SERVER['PHP_SELF']}" method="post">
                <strong><font size="4">What class do you need help in</font></strong>&nbsp;&nbsp;
                <select id="classes" name="course">
                    <option value="non">Please select a class</option>
                    <option value="cmsc131">CMSC131</option>
                    <option value="cmsc132">CMSC132</option>
                    <option value="cmsc330">CMSC330</option>
                </select>
                <br><br>
                <strong><font size="4">Please enter the code the TA set</font>
                </strong>
                <!--GOING TO NEED TO CHECK IF CODE FOR CLASS IS CORRECT-->
                <input type="text" maxlength="5" id="code" name="code" disabled>
                <br><br>
                <input type="submit" value="Start Session" id="submit" name="submit" disabled> &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Logout" id="logout" name="logout">
            </form>
            
            </p>
        </div>
                      <script src="bootstrap/jquery-3.2.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
        </body> 
    </html>
EOBODY;
        $bottomPart="";
        //echo 'stece';
        $db = new mysqli($host, $user, $password, $database);
        if(isset($_POST['submit'])){
            $enteredCode = $_POST["code"];
            $course = $_POST["course"];
            $query = "SELECT code FROM tas WHERE course = '$course'";
            $query2 = $db->query($query);
            $classCode = $query2->fetch_array(MYSQLI_ASSOC);
            if($enteredCode === $classCode['code']){
                $_SESSION['course'] = $course;
                header('Location: Student_Form.php');
            }
            else{
                $bottomPart .= <<<EOBODY
                <body>
                    <div id ="content">
                    
                     "<strong>There are no TAs available for $course at this time. Please choose a different course, or make sure the code you entered is correct. Ask the Ta for the correct code if you don't have one.</strong>";
                     
                     
                     </div>
                                   <script src="bootstrap/jquery-3.2.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
                     </body>
                     </html>
EOBODY;
            }
        }
        if(isset($_POST['logout'])){
            //$_SESSION['loggedin'] = false;
            //print 'stece';

            $_SESSION['studentLoggedin'] = false;
            header('Location: main.php');
        }
  
  // no user is currentle logged in. 
    }else{

        
        $bottomPart =  "<br /><br /><br /><h1>You are not logged in. Please wait to be redirected to the login page...</h1><br />";
        header("refresh:3; url=main.php");
    }
    $page = generatePage($main.$bottomPart);
    echo $page;
?>