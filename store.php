<?php

session_start();

// data from the $_POST
$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);


// uploading files to /uploads

move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);


$title = $_POST['title'];
$text = $_POST['text'];
$filePath = 'uploads/' . $_FILES['file']['name'];

$user_id = $_SESSION['id'];



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

$sql = 'INSERT INTO posts (title, text, filePath, user_id) VALUES (:title, :text, :filePath, :user_id)';
$statement = $pdo->prepare($sql);

$_POST["filePath"] = $filePath;		// add the path to picture to the $_POST, which will be stored to the DB
$_POST["user_id"] = $user_id;

// ! it's possible to add some file with the same name twice, but in the folder it will be an only first file with that name

// execute the query

$result = $statement->execute($_POST);				


header('Location: /task_manager-markup/index.php');
