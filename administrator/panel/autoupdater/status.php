<?php session_start(); include("../../../dbaccess/index.php"); include("../../../dbaccess/modules.php");
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: /administrator/");	

	}

	if(isset($_GET['lastvisited']))
		$lastVisited = $_GET['lastvisited'];

	$username = $_SESSION["username"];

	$statement = $conn->prepare("UPDATE users SET online = 1, last_visited = :lastvisited, last_visited_datetime=NOW() WHERE username = :username");
	$statement->bindParam(":username", $username);
	$statement->bindParam(":lastvisited", $lastVisited);
	
	$statement->execute();

?>