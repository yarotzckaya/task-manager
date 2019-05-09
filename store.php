<?php

// data from the $_POST


$title = $_POST['title'];
$text = $_POST['text'];


// validation: if no data was sent from the form

foreach ($_POST as $input) {			
	if(empty($input)){
		$errorMessage = 'The fields should not be empty';
		include 'errors.php';
		exit;
	}
}
