<?php include('../dbaccess/index.php'); include('../dbaccess/modules.php'); include('../dbaccess/bbcode-parser.php');
	if(isset($_GET["post-id"]))
	{
		$statement = $conn->prepare("SELECT blog.title, blog.posted_by, blog.content, blog.posted_at, blog.posted_by, users.firstname, users.surname FROM blog INNER JOIN users ON blog.posted_by = users.username WHERE blog.id = :postid LIMIT 1");
		$statement->bindParam(":postid", $_GET["post-id"]);
		$statement->execute();
		$retrievedPost = $statement->fetch();
		$retrievedPost['content'] = bbcodeParser($retrievedPost['content']);

		echo json_encode($retrievedPost);
	}
	else
	{
		$statement = $conn->prepare("SELECT blog.id FROM blog ORDER BY posted_at DESC");
		$statement->execute();
		$lastTenPosts = $statement->fetchAll();

		echo json_encode($lastTenPosts);
	}
?>