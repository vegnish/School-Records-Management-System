<?php
	session_start(); 
	if (!isset($_SESSION["username"]) || $_SESSION["role"] != 'Teacher') {   
		header("Location: ../login.php");
	}
?>