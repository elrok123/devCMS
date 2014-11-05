<?php include('../../../../dbaccess/index.php');  include('../../../../dbaccess/modules.php');

	session_start();
	if(isset($_GET['postToEdit']))
	{
		$_SESSION['postToEdit'] = $_GET['postToEdit'];
	}
	else
	{
		header("Location: ../");
	}
	
	$username = $_SESSION['username'];
	
	unset($_SESSION['postEdit']);
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}
	if(isset($_POST['savePost']) && $_POST['postTitle'] != "" && $_POST['postContent'] != "")
	{		
		$postTitle = preg_replace("/[^ \w]+/", "", $_POST['postTitle']);	
		$postTags = preg_replace("/[^0-9\, \w]/", "", $_POST['tags']);
		$postContent = $_POST['postContent'];		
		
		$statement = $conn->prepare("UPDATE blog SET title = :postTitle, content = :postContent, tags = :postTags WHERE id = :postID");
		$statement->bindParam(":postTitle", $postTitle);
		$statement->bindParam(":postTags", $postTags);
		$statement->bindParam(":postContent", $postContent);

		$statement->bindParam(":postID", $_SESSION['postToEdit']);
		$statement->execute();
		header("Location: ../");

	}
	else if(isset($_POST['savePost']) && $_POST['postTitle'] == "")
	{
		$displayError = 1;
	}
	else if(isset($_POST['savePost']) && $_POST['postContent'] == "")
	{
		$displayError = 2;
	}

	$statement = $conn->prepare("SELECT * FROM blog WHERE id = :postID");
	$statement->bindParam(":postID", $_SESSION['postToEdit']);
	$statement->execute();
	$postDetails = $statement->fetch();

?>
<!DOCTYPE html>
<html>

	<head>

		<link rel="stylesheet" type="text/css" href="../../../../css/css.css" />
		<title>KoanSystems Admin Area</title>
		<link href="../../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script type="text/javascript" src="../../../../css/js.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			function showDeleteSuccess()
			{
				document.getElementById('user_accepted').style.display="block";
				setTimeout("document.getElementById('user_accepted').style.display='none'", 4000);
			}
			function showDeleteFailure()
			{
				document.getElementById('deleteFailure').style.display="block";
				setTimeout("document.getElementById('deleteFailure').style.display='none'", 4000);
			}
			<?php
			

				if($displayError == 1)
				{
					echo "alert('Please enter a valid title.');";
				}
				else if($displayError == 2)
				{
					echo "alert('Please enter valid content.');";
				}
			?>
		</script>	
	</head>

	<body>
		<div id="user_accepted">
			Your delete was successful!
		</div>
		<div id="user_failed">
			Please enter a valid title for the post!
		</div>
		<div id="main">
			<table style="border-bottom: solid 2px #dadada;">
				<tr>	
					<td style="padding-left: 20px;">
						<a href="../">
							<img src="../../../../img/logo.png" style="width: 100px; height: auto; margin-left: auto; margin-right: auto;"/>
						</a>
					</td>
					<td style="width: 80%;">
						
					</td>
					<td>
						<div id="user" onMouseOver="this.style.boxShadow='0px 1px 2px #404040'; this.style.borderLeft='2px solid #00CCFF';" onMouseOut="this.style.boxShadow='none'; this.style.borderLeft='2px solid #dadada';" style="padding: 10px; width: 150px; height: 25px; border-left: solid 2px #dadada; margin-right: 0px; margin-left: auto; margin-top: 0px; margin-bottom: auto;"><h9>Welcome, <?php echo $username; ?>.</h9></br><a href="../../../logout/" style="color: #0c0c0c;">Logout...</a></div>
					</td>
				<tr>
			</table>
			<h1 class="title">New Post</h1>
			<div id="content1">
				<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
						<tr>
							<td style="width: 70%; text-align: left; height: 40px; padding: 10px; border-right: solid 1px #dadada;">
								<form action="" method="post">
									<input type="hidden" value="1" name="savePost" />
									<label>Post Title: </label>
									<input type="text" tag="Please make sure that you do not use a name already assigned to another post." alt="Please make sure that you do not use a name already assigned to another post." name="postTitle" value="<?php echo $postDetails['title'];  ?>" /></br></br>
									<label>Content:</label>
									<textarea name="postContent" id="fblValue" class="wallPost" onkeydown="insertTab(this, event);" ><?php echo $postDetails['content']; ?></textarea>
									<label>Keywords/Tags:</label>
									<input type="text" tag="Seperate keywords with a comma(,)" alt="Seperate keywords with a comma(,)" name="tags" value="<?php echo $postDetails['tags'];  ?>" />
									<input type="submit" name="newpostSubmit" value="Update post"/>
								</form>
							</td>

							<td style="width: 30%; height: 40px; text-align: left; padding: 10px;">
								<h1 class="title" style="margin-left: 0;">Help:</h1><br/><br/>
								This blog makes use of BBCode formatting, if you are unsure how to use BBCode, please see the link below:-
								</br></br>
								<a alt="BBCode Guide" title="BBCode Guide" href="http://en.wikipedia.org/wiki/BBCode" target="_blank">BBCode Guide</a>
							</td></br></br>
						</tr>
			
			</table>
			
			</div>
			<div id="footer">

				</br></br>Copyright &copy; KoanSystems			

			</div>	
		</div>

	

		<script src="/js/user-list.js" type="text/javascript"></script>
	</body>

</html>