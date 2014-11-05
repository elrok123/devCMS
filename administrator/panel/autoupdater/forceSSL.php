<?php session_start(); include("../../../dbaccess/index.php"); include("../../../dbaccess/modules.php");
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: /administrator/");	
		die();
	}

	if(isset($_GET['sslstate']))
		$sslstate = $_GET['sslstate'];

	$statement = $conn->prepare("UPDATE settings SET sslstate = :sslstate");
	$statement->bindParam(":sslstate", $sslstate);
	
	$statement->execute();

?>