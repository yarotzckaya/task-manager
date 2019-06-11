<?php

function connect()
{
	$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
}

function showErrorMessage($message)
{
	$errorMessage = $message;
    include 'errors.php';
    exit;
}

