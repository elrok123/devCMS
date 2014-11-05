<?php  include('../../../../../dbaccess/index.php');  include('../../../../../dbaccess/modules.php'); 

	session_start();
	
	if(isset($_SESSION["username"]) == false)
	{

		die();	

	}
	
	if(isset($_POST['pageToEdit']))
	{
		$pageToEdit = $_POST['pageToEdit'];
		$mainBlockCode = $_POST['mainBlock-code'];
		$mainBlockDisabled = $_POST['mainBlockDisabled'];
		$footer = $_POST['footer-code'];
		$copyright = $_POST['copyright-code'];
			
		$statement = $conn->prepare("UPDATE pages SET 
											FBL = :mainBlockCode, FBLDisabled = :mainBlockDisabled,  
											Footer = :footer, 
											Copyright = :copyright 
											WHERE ID = :pageToEdit");
		
		$statement->bindParam(":mainBlockCode", $mainBlockCode);
		$statement->bindParam(":mainBlockDisabled", $mainBlockDisabled);
		$statement->bindParam(":footer", $footer);
		$statement->bindParam(":copyright", $copyright);
		$statement->bindParam(":pageToEdit", $pageToEdit);
		$statement->execute();
	}

?>