<?php
include_once('support.php');

	if (isset($_GET['320'])){
		echo "There are 6 people ahead of you";
	}
	if (isset($_GET['433'])){
		echo "There are 2 people ahead of you";
	}
	if (isset($_GET['389'])){
		echo "There are 3 people ahead of you";
	}

?>