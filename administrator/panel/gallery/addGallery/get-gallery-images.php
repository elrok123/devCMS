<?php session_start(); include('../../../../dbaccess/index.php');  include('../../../../dbaccess/modules.php');
	
	$username = $_SESSION['username'];
	
	unset($_SESSION['postEdit']);
	
	if(isset($_SESSION["username"]) == false)
	{
		header("Location: ../");
	}
	$galleryName = $_GET['galleryName'];

	$statement = $conn->prepare("SELECT image.location FROM image LEFT JOIN gallery ON gallery.ID = image.galleryId WHERE gallery.galleryName = :galleryName"); 
    $statement->bindParam(":galleryName", $galleryName);
    $statement->execute();
    $results = $statement->fetchAll();
    echo stripcslashes(json_encode($results));
?>