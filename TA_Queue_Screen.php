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

            $bottomPart .=  "<br /><br /><br /><h1>You haven't chosen a course. Please wait to be redirected to the Selection Course page...</h1><br />";

            header("refresh:3; url=TA_Page.php");
        }
    }else{

        //No TA user logged in
        $_SESSION['TaLoggedin'] = false;
        $bottomPart .=  "<br /><br /><br /><h1>You are not logged in. Please wait to be redirected to the login page...</h1><br />";

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
                <strong>Caution: Logging out will automaticaly delete the table queue list.</strong></br>
                <strong>Caution: Clock out will  prevent other students from entering into your queue. But you still have to finish attendng those that remain in your queue.</strong>

            </form>
        </div>
        </body>
    
    </html>

EOBODY;

    }else{
        //retrieve all the data from teh queue table
        
        $final = $res->fetch_array(MYSQLI_ASSOC);

        //getting the count of the queue 
        $query1 = "SELECT COUNT(*) FROM your_table_name";
        $count = $db->query($query1);
        


        $topPart .= <<< EOBODY
        <body>
        <div id = "content">
            <p>
            <h1>There is currently  $count students in queue.</h1><br><br>
            <div>
                <table style="float: left;" border="1" >
                    <strong>QUEUE TABLE</strong><br><br>
                    <tr>
                        <td><strong>Rank</strong></td><td><strong>Student Name</strong></td><td><strong>Subject</strong></td><td><strong>Description</strong></td>
                    </tr>

                    <?php
                        $i = $res->num_rows;
                        
                        while(i > 0){
                            echo "<tr>";
                            echo "<td>" . $final["rank"] . "</td>" . "<td>" . $final["firstName"] . "</td>" . "<td>" . $final["subject"] . "</td>" . "<td>" . $final["description"] . "</td>";
                            echo "</tr>";
                            i = i-1;
                        }

                    ?>
                </table>
            </div>


            <form id = "touch" action="{$_SERVER['PHP_SELF']}" method="post">
        
                <input type="submit" value="Get Next Student" id="nextStudent" name="nextStudent"> &nbsp;&nbsp;
                <input type="submit" value="Clock out" id="clockOut" name="clockOut">&nbsp;&nbsp;
                <input type="submit" value="Logout" id="logout" name="logout">
                <br>
                <strong>Caution: Logging out will automaticaly delete the table queue list.</strong></br>
                <strong>Caution: Clock out will  prevent other students from entering into your queue. But you still have to finish attendng those that remain in your queue.</strong>

            </form>
            </div>
        </body>
    
    </html>

EOBODY;
    


    }


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
        $query = "UPDATE tas SET code=0 WHERE firstName = '$name'";
      $execute = $db->query($query);




      $query2 = "UPDATE tas SET course='cmsctemp' WHERE firstName = '$name'";
      $execute2 = $db->query($query2);




        $query = "DROP TABLE IF EXISTS `{$whichClass}` ";
        $execute2 = $db->query($query);

        $_SESSION['TaLoggedin'] = true;
        $_SESSION['workingCourse'] = false;
        header('Location: TA_Page.php');
    }


    echo $topPart.$bottomPart;
?>

