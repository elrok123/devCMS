<?php session_start(); include("../../../dbaccess/index.php"); include("../../../dbaccess/modules.php");
	
	if(isset($_SESSION["username"]) == false)
	{
		die();
	}

	$username = $_SESSION["username"];
	$statement = $conn->prepare("SELECT Username, firstname, surname, online, last_visited, last_visited_datetime FROM users WHERE type = 0 ORDER BY online DESC");
	$statement->execute();
	$user_details = $statement->fetchAll();
	$json = json_encode($user_details);
	echo $json;
?>