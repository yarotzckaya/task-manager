<?php

// data from the $_POST


$email = $_POST['email'];
$password = md5($_POST['password']);


// validation: if no data was sent from the form

foreach ($_POST as $input) {			
	if(empty($input)){
		$errorMessage = 'The fields should not be empty';
		include 'errors.php';
		exit;
	}
}

// preparation SQL query: check if the user already exists

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
$sql = 'SELECT * from users where email=:email and password=:password';

$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email, ':password' => $password]);

$user = $statement->fetchAll();			// достаем все строки

//var_dump($user);		// распечатывает строки, которые мы достали из БД
//echo "<br>";

// if the user exists - store data to the session

if($user){
	session_start();								// как оказалось, необязательно делать старт сессии в самом начале файла
	 $_SESSION["id"] = $user[0]["id"];
	 $_SESSION['username'] = $user[0]["username"];
	 $_SESSION['email'] = $user[0]["email"];
	 $_SESSION["password"] = md5($user[0]["password"]);

	 header('Location: /task_manager-markup/index.php');
	exit;
} else {
	$errorMessage = "Invalid data.";
	include 'errors.php';
	exit;
}
