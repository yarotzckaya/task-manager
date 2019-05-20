<?php

session_start();

if($_SESSION["id"]) {

// this page will be available only for logged in users
 
 // check if the post exists

$id = $_GET['id'];		// post id

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');

$pdo->exec("DELETE FROM posts where id=" . $id . " AND user_id=" . $_SESSION['id']);

echo $id;

header('Location: /task_manager-markup/index.php');

} else {
  $errorMessage = "This post is not deleted.";
  include 'errors.php';
}