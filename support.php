<?php
/**
 * Created by PhpStorm.
 * User: JeanClaude
 * Date: 9/25/2017
 * Time: 7:46 PM
 */

function generatePage($body, $title="Application System") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>$title</title>	
    </head>
            
    <body>
            $body
    </body>
</html>
EOPAGE;

    return $page;
}
?>