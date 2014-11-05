<?php session_start();

	if(isset($_GET['download']))
	{
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Transfer-Encoding: binary ");
		$file = $_GET['download'];
		$id = $_SESSION['id'];
		$location = "uploads" . "/" . $id . "/" . $file;
		header("Content-Disposition: attachment;filename=" . $file.";");
		readfile($location);
	}

?>