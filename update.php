<?php

require_once 'functions.php';

session_start();

// data from the $_POST
$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);

//var_dump($_FILES);		// empty array

// validation: if no data was sent from the form

validateEmptyFields();

$pdo = connect();
$post_id = intval($_POST['post_id']);


// uploading files to /uploads (if() statement was needed for refactoring)

if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    echo "File is uploaded!\n";

    // if new file was uploaded - it's needed to delete an old version of this fale from the '/uploads'

    $statement = $pdo->prepare('SELECT filePath FROM posts WHERE id=:id');
    $statement->bindValue(':id', $post_id);		

    $statement->execute();
    $oldFilePath = $statement->fetch();

    $oldFilePath = $oldFilePath['filePath'];	

    unlink($oldFilePath);

    // creating new filePath

    $filePath = 'uploads/' . $_FILES['file']['name'];
    
} else {
    echo "File uploading error!\n";

    // if the file was not change - keep an old filePath

    $statement = $pdo->prepare('SELECT filePath FROM posts WHERE id=:id');
    $statement->bindValue(':id', $post_id);		

    $statement->execute();
    $filePath = $statement->fetch();

    $filePath = $filePath['filePath'];		
}


$title = $_POST['title'];
$text = $_POST['text'];
$user_id = $_SESSION['id'];

$_POST['user_id'] = $user_id;

// preparation SQL query
	

	$statement = $pdo->prepare('UPDATE posts SET title= :title, text= :text, filePath= :filePath WHERE user_id=:user_id AND id=:id');
	$statement->bindValue(':title', $title);
	$statement->bindValue(':text', $text);

	$statement->bindValue(':filePath', $filePath);

	$statement->bindValue(':id', intval($_POST['post_id']));
	$statement->bindValue(':user_id', $user_id);



unset($_POST['post_id']);		// we don't need the id in overwriting the data

// execute the query
	
$statement->execute();


header('Location: /task_manager-markup/index.php');