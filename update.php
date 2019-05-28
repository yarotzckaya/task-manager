<?php

session_start();

// data from the $_POST
$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);

//var_dump($_FILES);		// empty array

// validation: if no data was sent from the form

foreach ($_POST as $input) {			
	if(empty($input)){
		$errorMessage = 'The fields should not be empty';
		include 'errors.php';
		exit;
	}
}

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');

/*

One thing I cannot do: when the picture is updating, the old version of the picture still 
in the folder. And if I will update the picture for 1 post 100 times - there are 100 pictures 
in folder. I don't know how to fix it now

*/


// uploading files to /uploads (if() statement was needed for refactoring)

if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    echo "File is uploaded!\n";

    $filePath = 'uploads/' . $_FILES['file']['name'];
	$_POST['filePath'] = $filePath;	
} else {
    echo "File uploading error!\n";

    //var_dump($_POST);
    $post_id = intval($_POST['post_id']);

    $sql = 'SELECT filePath FROM posts WHERE id=' . $post_id;
    //$sql->bindValue(':id', $post_id, PDO::PARAM_INT);		/////////////// does not work
   // $statement = $pdo->execute($sql);
    $statement = $pdo->query($sql);
    $filePath = $statement->fetch();

    $filePath = $filePath['filePath'];


}


//var_dump($_POST);

$title = $_POST['title'];
$text = $_POST['text'];
$user_id = $_SESSION['id'];

$_POST['user_id'] = $user_id;

// preparation SQL query


	

	$statement = $pdo->prepare('UPDATE posts SET title= :title, text= :text, filePath= :filePath WHERE user_id=:user_id AND id=:id');
	$statement->bindValue(':title', $title);
	$statement->bindValue(':text', $text);

	$statement->bindValue(':filePath', $filePath);

	$statement->bindValue(':id', $_POST['post_id']);
	$statement->bindValue(':user_id', $user_id);



unset($_POST['post_id']);		// we don't need the id in overwriting the data

// execute the query
	
$statement->execute();


//header('Location: /task_manager-markup/index.php');