<?php

function generatePage($body, $title="Example") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>$title</title>
    <link rel = "stylesheet" href = "Login.css" type="text/css"/>
    </head>

    <body>
            $body
    </body>
</html>
EOPAGE;

    return $page;
}
function connectToDB($host, $user, $password, $database) {
  $db = mysqli_connect($host, $user, $password, $database);
  if (mysqli_connect_errno()) {
    echo "<h2>Connect failed.</h2>\n".mysqli_connect_error();
    exit();
  }
  return $db;
}
?>
