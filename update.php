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


//var_dump($_POST);

$title = $_POST['title'];
$text = $_POST['text'];
$user_id = $_SESSION['id'];

$_POST['user_id'] = $user_id;

// preparation SQL query

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');

if(empty($_FILES['name'])){
	// don't change filepath
	$sql = 'UPDATE posts SET title= :title, text= :text, user_id= :user_id WHERE user_id=' . $_SESSION['id'] . ' AND id= ' . $_POST['post_id'];
} else {
	$filePath = 'uploads/' . $_FILES['file']['name'];
	$_POST['filePath'] = $filePath;	
	$sql = 'UPDATE posts SET title= :title, text= :text, filePath= :filePath, user_id= :user_id WHERE user_id=' . $_SESSION['id'] . 'AND id= ' . $_POST['post_id'];
}

unset($_POST['post_id']);		// we don't need the id in overwriting the data
//var_dump($_POST);

$statement = $pdo->prepare($sql);

// execute the query

$result = $statement->execute($_POST);		


header('Location: /task_manager-markup/index.php');