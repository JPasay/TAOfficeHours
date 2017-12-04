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
    //$class = $_SESSION['class'];
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
    </div>
    </body>
EOBODY;
    $bottomPart = "";
    function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
    }

     $db = new mysqli($host, $user, $password, $database);



    if(isset($_SESSION['TaLoggedin']) && $_SESSION['TaLoggedin'] == true){
        if(!isset($_SESSION['workingCourse']) || $_SESSION['workingCourse']==false){

            $bottomPart =  "<br /><br /><br /><h1>You haven't chosen a course. Please wait to be redirected to the Selection Course page...</h1><br />";

            header("refresh:3; url=TA_Page.php");
        }
    }else{

        //No TA user logged in
        $_SESSION['TaLoggedin'] = false;
        $bottomPart =  "<br /><br /><br /><h1>You are not logged in. Please wait to be redirected to the login page...</h1><br />";

            header("refresh:1.5; url=main.php");
    }

    $class = $_SESSION['class'];
    $whichClass = "officehourqueueFor" . $class;

    $query = "SELECT * FROM `{$whichClass}` ";
    $res = $db->query($query);
    $i = $res->num_rows;
    if($i < 1){
        //alert($class);
        //there are no QUEUE list the the Queue doesnt exit YETT
        $topPart .= <<< EOBODY
        <body>
        <div id = "content">
            <p>
            <h1>There is currently no Student in the Queue. Refresh your browser for an update. But for now just CHILLAXX.</h1><br><br>
            <form id = "touch" action="{$_SERVER['PHP_SELF']}" method="post">
        
                <input type="submit" value="Get Next Student" id="nextStudent" name="nextStudent"> &nbsp;&nbsp;
                <input type="submit" value="Clock out" id="clockOut" name="clockOut">&nbsp;&nbsp;
                <input type="submit" value="Logout" id="logout" name="logout">
                <br>
                <strong>Caution: Logging out will automaticaly delete the table queue list.</strong></br><br>
                <strong>Caution: Clock out will  prevent other students from entering into your queue. But you still have to finish attendng those that remain in your queue.</strong>

            </form>
        </div>
          <script src="bootstrap/jquery-3.2.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
        </body>
    
    </html>

EOBODY;

    }else{
        //retrieve all the data from teh queue table
        
        //$final = $res->fetch_array(MYSQLI_ASSOC);

        //getting the count of the queue 
        $query1 = "SELECT COUNT(*) FROM '{$whichClass}'";
//        $count = $db->query($query1);
        $sql = "SELECT count(rank) AS total FROM $whichClass";
        $result = mysqli_query($db, $sql);
        $values = mysqli_fetch_assoc($result);
        $count=$values['total'];



        $topPart .= <<< EOBODY
        <body>
        <div id = "content">
EOBODY;

            $topPart .= "<h1>There is currently ".$count." students in queue.</h1><br><br>";
            $topPart .= <<< EOBODY
            <div>
                <table class="table table-bordered table-striped table-hover table-condensed text-center table-fit">
                    <strong>QUEUE TABLE</strong><br><br>
                    <tr>
                        <th><strong>Rank</strong></th><th><strong>Student Name</strong></th><th><strong>Subject</strong></th><th><strong>Description</strong></th>
                    </tr>

EOBODY;
                        while ($row = $res->fetch_assoc()) {
                            $topPart .= '<tr>';
                            $topPart .= '<td>'. $row["rank"] .'</td>';
                            $topPart .= '<td>'. $row["firstName"] .'</td>';
                            $topPart .= '<td>'. $row["subject"] .'</td>';
                            $topPart .= '<td>'. $row["description"] .'</td>';
                            $topPart .= '</tr>';
                        }
                    $topPart .= <<<EOBODY
                </table>
                </div>
            <form id = "touch" action="{$_SERVER['PHP_SELF']}" method="post">
        
                <input type="submit" value="Get Next Student" id="nextStudent" name="nextStudent"> &nbsp;&nbsp;
                <input type="submit" value="Clock out" id="clockOut" name="clockOut">&nbsp;&nbsp;
                <input type="submit" value="Logout" id="logout" name="logout">
                <br><br><br>
                <strong>Caution: Logging out will automaticaly delete the table queue list.</strong></br> <br>
                <strong>Caution: Clock out will  prevent other students from entering into your queue. But you still have to finish attendng those that remain in your queue.</strong>

            </form>
            </div>
            
              <script src="bootstrap/jquery-3.2.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
        </body>
    
    </html>

EOBODY;
    


    }

    $name = $_SESSION['firstname'];

    if(isset($_POST['logout'])){
        

        $query = "UPDATE tas SET code=0 WHERE firstName = '$name'";
        $execute = $db->query($query);

        $query2 = "UPDATE tas SET course='cmsctemp' WHERE firstName = '$name'";
        $execute2 = $db->query($query2);

        $query = "DROP TABLE IF EXISTS `{$whichClass}` ";
        $execute2 = $db->query($query);

        $_SESSION['TaLoggedin'] = false;
        $_SESSION['workingCourse'] = false;
        header('Location: main.php');
    }

    if(isset($_POST['clockOut'])){
        $query = "UPDATE tas SET code=0 WHERE firstName = '$name' ";
        $execute = $db->query($query);




        $query2 = "UPDATE tas SET course = 'cmsctemp' WHERE firstName = '$name' ";
        $execute2 = $db->query($query2);



        if($i < 1){
            //Although you clocked out. No more students in the queue. 
            $query = "DROP TABLE IF EXISTS `{$whichClass}` ";
            $execute2 = $db->query($query);

            $_SESSION['TaLoggedin'] = true;
            $_SESSION['workingCourse'] = false;
            header('Location: TA_Page.php');
        }else{
            //Although you clocked out. TA still have students in the queue. 
            $_SESSION['TaLoggedin'] = true;
            $_SESSION['workingCourse'] = true;  
        }
        
    }

    if(isset($_POST['nextStudent'])){
        $query = "DELETE FROM $whichClass LIMIT 1";
        $execute = $db->query($query);
    //drop the rank table
        $query = "ALTER TABLE $whichClass DROP COLUMN rank";
        $result = $db->query($query);


    //put the rank table backkkkk
        $query = "ALTER TABLE $whichClass ADD COLUMN rank INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
        $result = $db->query($query);
        header('Location: TA_Queue_Screen.php');
    }

    echo $topPart.$bottomPart;
?>

