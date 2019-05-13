<?php

// data from the $_POST
$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);


// uploading files to /uploads
echo '<pre>';
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    echo "File is uploaded!\n";
} else {
    echo "File uploading error!\n";
}


$title = $_POST['title'];
$text = $_POST['text'];
$file = $_FILES['file'];


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


header('Location: /task_manager-markup/index.php');