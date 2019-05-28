<?php
// receive data from $_POST and create variables from it

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// validation: if no data found

foreach ($_POST as $input) {			
	if(empty($input)){
		$errorMessage = 'The fields should not be empty';
		include 'errors.php';
		exit;
	}
}

// preparation SQL query: check if the user already exists

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
$sql = 'SELECT id from users where email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetchColumn();


// if the user exists - show error message and exit

if($user){
	$errorMessage = 'This user already exists.';
	include 'errors.php';
	exit;
}

// if the user is new - prepare the query to DB to store the data

$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare($sql);

// password hash

$_POST['password'] = md5($_POST['password']);		
$result = $statement->execute($_POST);				

if(!$result){
	$errorMessage = 'Registration error';
	include 'errors.php';
	exit;
}

// redirection

header('Location: /task_manager-markup/login-form.php');