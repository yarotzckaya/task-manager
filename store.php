<?php

// data from the $_POST


$title = $_POST['title'];
$text = $_POST['text'];
$file = $_FILES['upload'];


// validation: if no data was sent from the form

foreach ($_POST as $input) {			
	if(empty($input)){
		$errorMessage = 'The fields should not be empty';
		include 'errors.php';
		exit;
	}
}

// check the image

// variables:


$fileName = $_FILES['upload']['name']; 
$fileType = $_FILES['upload']['size'];


// preparation SQL query

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');

$sql = 'INSERT INTO posts (title, text) VALUES (:title, :text)';
$statement = $pdo->prepare($sql);

// execute the query

$result = $statement->execute($_POST);				


header('Location: /task_manager-markup/index.php');