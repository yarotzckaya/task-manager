<?php

require_once 'functions.php';

session_start();

if($_SESSION["id"]) {

// this page will be available only for logged in users

$pdo = connect();


// deleting connected file

// find the path to file:


$statement = $pdo->prepare('SELECT filePath FROM posts WHERE id=:id');
$statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);	// post id

$statement->execute();
$result = $statement->fetch();

$filePath = $result["filePath"];

// deleting the file of this post 

unlink($filePath);

// deleting the post 

$statement = $pdo->prepare("DELETE FROM posts where id=:id AND user_id=:user_id");
$statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$statement->bindValue(':user_id', $_SESSION["id"], PDO::PARAM_INT);

$statement->execute();



header('Location: /task_manager-markup/index.php');

} else {
  showErrorMessage("This post was not deleted");
}