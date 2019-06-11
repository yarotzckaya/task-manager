<?php

// connection to DB - returns new PDO object
function connect()
{
	$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
	return $pdo;
}

// displaying error message for any case
function showErrorMessage(string $message)
{
	$errorMessage = $message;
    include 'errors.php';
    exit;
}

// shows error message if required filds in POST-form were empty
function validateEmptyFields()
{
	// validation of the fields that should not be empty

	foreach ($_POST as $input) {			
		if(empty($input)){
			showErrorMessage("This field should not be empty");
		}
	}
}

// redirects user using local paths
function redirect(string $uri)
{
	$domainName = '/task_manager-markup/';
	header('Location: ' . $domainName . $uri);
}

