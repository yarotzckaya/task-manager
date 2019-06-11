<?php

require_once 'functions.php';

// data from the $_POST

$email = $_POST['email'];
$password = md5($_POST['password']);


// validation: if no data was sent from the form

validateEmptyFields();

// preparation SQL query: check if the user already exists

$pdo = connect();

$sql = 'SELECT * from users where email=:email and password=:password';

$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email, ':password' => $password]);

$user = $statement->fetch();			// достаем все строки

// if the user exists - store data to the session

if($user){
	session_start();								// как оказалось, необязательно делать старт сессии в самом начале файла
	 $_SESSION["id"] = $user["id"];
	 $_SESSION['username'] = $user["username"];
	 $_SESSION['email'] = $user["email"];
	 
	 header('Location: /task_manager-markup/index.php');
	exit;
} else {
	showErrorMessage("Invalid data");
}
