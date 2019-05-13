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


// preparation SQL query

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');

$sql = 'INSERT INTO posts (title, text) VALUES (:title, :text)';
$statement = $pdo->prepare($sql);

// execute the query

$result = $statement->execute($_POST);				


