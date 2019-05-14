<?php

session_start();

// data from the $_POST
$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);



// validation: if no data was sent from the form

foreach ($_POST as $input) {			
	if(empty($input)){
		$errorMessage = 'The fields should not be empty';
		include 'errors.php';
		exit;
	}
}


// uploading files to /uploads
echo '<pre>';
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    echo "File is uploaded!\n";
} else {
    echo "File uploading error!\n";
}


$title = $_POST['title'];
$text = $_POST['text'];
$user_id = $_SESSION['id'];
$filePath = 'uploads/' . $_FILES['file']['name'];
$_POST['filePath'] = $filePath;	
$_POST['user_id'] = $user_id;

// preparation SQL query

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');

$sql = 'UPDATE posts SET [title= :title, text= :text, filePath= :filePath, user_id= :user_id]';
$statement = $pdo->prepare($sql);

//var_dump($_POST);

// execute the query

$result = $statement->execute($_POST);		


