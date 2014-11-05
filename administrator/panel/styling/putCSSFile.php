<?php
	session_start();
	
	if(isset($_SESSION["username"]) == false)
	{

		die();

	}

	if(isset($_POST['cssCode']))
	{
		try {

			$cssContents = $_POST['cssCode'];
		
			$cssContents = stripslashes($cssContents);
			
			file_put_contents("../../../css/pageCSS.css", stripslashes($cssContents));

			echo 1;

		} catch (Exception $e) {
			echo "There was a problem:  " . $e;

		}
	}
	else
	{
		echo "No content provided. This page should not be accessed manually.";
	}
?>