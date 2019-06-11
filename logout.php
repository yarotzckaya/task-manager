<?php

// deleting user's data from session

session_start();

session_reset();		// clean the session - an empty array will be set


header('Location: /task_manager-markup/login-form.php');