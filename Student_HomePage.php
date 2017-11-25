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

    $db = new mysqli($host, $user, $password, $database);
    $userN = $_SESSION['UID'];
    $query = "SELECT firstName FROM queue_system WHERE directoryID = '$userN'";
    $name2 = $db->query($query);
    $name3 = $name2->fetch_array(MYSQLI_ASSOC);
    $name = $name3["firstName"];
    // if (!$name2) {
  	// 	die("Insertion failed 2: " . $db->error);
  	// } else {
  	// 	echo "Insertion completed.<br>";
  	// }
$main = <<< EOBODY
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

            <div id="content">
        <p>
        <h1>Welcome $name </h1>
        <div>
            <br/>
            <form id="enterUser" action="{$_SERVER['PHP_SELF']}" method="post">
                <strong><font size="4">What class do you need help in</font></strong>
                &nbsp;&nbsp;
                <select id="classes" name="course">
                    <option value="non">Please select a class</option>
                    <option value="cmsc131">CMSC131</option>
                    <option value="cmsc132">CMSC132</option>
                    <option value="cmsc330">CMSC330</option>
                </select>
                <br><br>
                <strong><font size="4">Please enter the code the TA set</font></strong>
                <!--GOING TO NEED TO CHECK IF CODE FOR CLASS IS CORRECT-->
                <input type="text" maxlength="5" id="code" name="code" disabled required>
                <br><br>
                <input type="submit" value="Start Session" id="submit" name="submit" disabled>
            </form>
        </div>
        </p>
    </div>
    </div>
    </body>
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
    </html>
EOBODY;
  $bottomPart="";
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
      $bottomPart = "<strong>Wrong code</strong>";
    }
  }

  $page = generatePage($main.$bottomPart);
  echo $page;
?>
