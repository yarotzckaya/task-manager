<?php

session_start();

if($_SESSION["id"]) {

// this page will be available only for logged in users

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
$id = $_GET['id'];		// post id
$user_id = $_SESSION["id"];


// deleting connected file

// find the path to file:


$statement = $pdo->prepare('SELECT filePath FROM posts WHERE id=:id');
$statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

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
  $errorMessage = "This post is not deleted.";
  include 'errors.php';
}