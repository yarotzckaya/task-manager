<?php
// receive data from $_POST and create variables from it

require_once 'functions.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// validation: if no data found

validateEmptyFields();

// preparation SQL query: check if the user already exists

$pdo = connect();		// creating new PDO object

$sql = 'SELECT id from users where email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetchColumn();


// if the user exists - show error message and exit

if($user){
	showErrorMessage("This user already exists");
}

// if the user is new - prepare the query to DB to store the data

$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare($sql);

// password hash

$_POST['password'] = md5($_POST['password']);		
$result = $statement->execute($_POST);				

if(!$result){
	showErrorMessage("Registration error");
}

// redirection

header('Location: /task_manager-markup/login-form.php');