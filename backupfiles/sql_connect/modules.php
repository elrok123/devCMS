<?php 

		// Date in the past
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

		// always modified
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

		// HTTP/1.1
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);

		// HTTP/1.0
		header("Pragma: no-cache"); 
		
		function totalPercentageUsed($conn)
		{
			$statement = $conn->prepare("SELECT id FROM users WHERE emailverified = 1"); 
			$statement->execute(); 
			$userCount = $statement->rowCount(); 
			$statement = $conn->prepare("SELECT * FROM files"); 
			$statement->execute(); 
			$fileCount = $statement->rowCount(); 
			return array("userCount" => $userCount, "fileCount" => $fileCount);
		}
		function calculatePercent($element1, $element2)
	    {
	        $percentageComplete = ($element1 / $element2) * 100;
	        return ceil($percentageComplete);
	    }
?>
