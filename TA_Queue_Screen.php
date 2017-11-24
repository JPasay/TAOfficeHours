<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pagesStyle.css">
    <title>Maryland</title>
</head>

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
        <h1>There is currently ${number} in queue.</h1><br><br>
        <div>
            <table style="float: left;" border="1" >
                <strong>Displaying the top 10 in queue.</strong><br><br>
                <tr>
                    <td><strong>Student Id</strong></td><td><strong>Student Name</strong></td><td><strong>Category</strong></td><td><strong>Desc</strong></td>
                </tr>
                <?php
//                Change this so you can ouput the top 10 in queue***************************************************
                $arr = array("Jane", "Bob", "Steve", "Chris", "Mary", "Susie", "Anna", "Brian", "Rob", "Alex");
                for ($x = 0; $x < count($arr); $x++) {
                    echo "<tr>";
                    echo "<td>" . $x . "</td>" . "<td>" . $arr[$x] . "</td>" . "<td>" ."debug" ."</td>" . "<td>" . "Some type of string" . "</td>";
                    echo "</tr>";
                }
//                So once you click the start session button you instantly grab the email of the first student
//                and send an email notification. When the ta presses next pop the current student and refresh page
//                then email next student
//                mail(someEmail@gmail.com, "TA appointment", "some message");
                ?>
            </table>
        </div>
        <div style="padding-left: 50em">
            <h3>Current Student Information:</h3>
            <h4>Name: ${name}</h4>
            <strong>Student Id: ${id}</strong>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Help topic: ${category}</strong>
            <h4>Description:</h4>
            <p><?php echo nl2br("
            I happened to see a one day cricket match between Pakistan and Australia at Wankhade
            Stadium, Mumbai. I went for a fun. But I wit­nessed a horrible sight. Two thousand ticketless
            cricket fans gate crashed. There was a stampede. Three persons died and twenty were injured.
            Administration was responsible for it.");
            ?>
            </p>
            <br><br><br><br><br><br><br><br><br><br>
        </div>
        <div>
            <input type="submit" value="Get Next Student" onclick="getNext()" >
        </div>
        </p>
    </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>

    //Need to change this*************************************************
    function getNext() {
        window.location.href='https://youtu.be/5LitDGyxFh4?t=11s';
    }

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
</html>


<?php
/**
 * Created by PhpStorm.
 * User: JeanClaude
 * Date: 11/22/2017
 * Time: 7:33 PM
 */