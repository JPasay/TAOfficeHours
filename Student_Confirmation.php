<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="pagesStyle.css">
    <title>Maryland</title>
</head>
<?php
$body = "";
$body .= '<body>';
$body .= '<div id="container">';
    $body .= '<header id="logoContainer">';
        $body .= '<span id="logo" onclick="logoClickable()">';
        $body .= '<br>';
        $body .= '<img src="images/University_of_Maryland_logo.svg">';
        $body .= '</span>';
    $body .= '</header>';
    $body .= '<header id="logoutContainer">';
        $body .= '<span id="logoutText" onclick="logoutClickable()">';
        $body .= '<strong>Log out</strong>';
        $body .= '</span>';
    $body .= '</header>';
    $body .= '<div id="content">';
        $body .= '<p>';
        $body .= '<h1>'.$_POST['studentName'].', You are the, '.'***Variable for the student queue number****'.' in line to meet with the ta. Refresh the page to updapte your rank</h1>';
        $body .= '</p>';
        $body .= '</div>';
    $body .= '</div>';
$body .= '</body>';
echo $body;
?>
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
