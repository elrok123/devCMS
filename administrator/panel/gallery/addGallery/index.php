<?php session_start(); include('../../../../dbaccess/index.php');  include('../../../../dbaccess/modules.php');

	

	$username = $_SESSION['username'];
	
	unset($_SESSION['postEdit']);
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}
	try
	{
		if($_POST['galleryPass'] == $_POST['galleryPassVerify'] && $_POST['galleryUsername'] != "" && $_POST['galleryFirstname'] != "" && $_POST['gallerySurname'] != "" && $_POST['galleryEmail'] != "" && $_POST['gallerySurname'] != "")
		{
			$statement = $conn->prepare("INSERT INTO users (username, firstname, surname, email, Password, type) VALUES (:username, :firstname, :surname, :email, :password, 1)");
			$statement->bindParam(":username", $_POST['galleryUsername']);
			$statement->bindParam(":firstname", $_POST['galleryFirstname']);
			$statement->bindParam(":surname", $_POST['gallerySurname']);
			$statement->bindParam(":email", $_POST['galleryEmail']);
			$statement->bindParam(":password", crypt($_POST['galleryPass'], "\$iLikePotatoes\$"));
			$statement->execute();
			header("Location: ../");
		}
	}
	catch(PDOException $e)
	{
		$error = $e;
		echo $error;
	}

	
?>
<!DOCTYPE html>
<html>

	<head>

		<link rel="stylesheet" type="text/css" href="../../../../css/css.css" />
		<title>KoanSystems Gallery Area</title>
		<link href="../../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <script type="text/javascript" src="/js/jquery-1.3.2.js" ></script>
        <script type="text/javascript" src="/js/ajaxupload.3.5.js" ></script>
		
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
					echo "alert('Please enter a valid password.');";
				}
			?>
		</script>
		
		<?php 
			if(isset($error))
				echo "<script type='text/javascript'>alert('".(strpos($error, 'Duplicate') !== false ? "There is another entry with the same title, please change the title..." : "There was an error with your content..." )."');</script>";	
		?>
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/dark-hive/jquery-ui.css" id="theme">
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
			<h1 class="title">Add a new gallery:</h1>
			<div id="content1" >
				<div id="loading" style="display: none;"><img style="width: 25px; height: auto;" src="https://lh3.googleusercontent.com/-07k8OdPwIBc/VBBhiwXnXrI/AAAAAAAAH90/99Y6GtIYLVY/w1280-h1024/loading.gif" />Uploading the file magically over the internet!</div></br></br>
				<label>Select which client to assign the gallery to:</label>
				<select id="clientID" name="clientID">
					<?php
						$statement = $conn->prepare("SELECT * FROM users WHERE type = 1");
						$statement->execute();
					
						while($clients = $statement->fetch())
						{
							echo "<option value=\"" . $clients['ID'] . "\">" . $clients['firstname'] . " " . $clients['surname'] . "</option>";
						}
					?>
				</select></br></br>
				<label onclick="alert($('#galleryName').val())">Gallery Name:</label></br></br>
				<label>Note: Special characters are not allowed in the text, must be plain text, examples of special characters e.g. & , * % $ £ @ " ? ! .</label> </br></br>
				<input id="galleryName" type="text" style="width: 40%;" placeholder="Enter name of gallery..."></input></br></br>
				<label>Please select a ZIP file of pictures to upload. Once you select a file, it will asynchronously be uploaded and parsed.</label></br></br>
				<button id="zipFile" onclick="submitFile()">Select File...</button></br></br></br></br></br></br></br>

			</div></br></br>
			<div id="files" class="portfolio-content-images" >
        	</div>
			<div id="footer" style="clear: both; margin-bottom: 0px;">
				</br></br>Copyright &copy; KoanSystems
			</div>	
		</div>
		<script src="/js/file-uploader.js" type="text/javascript"></script>
		<script src="/js/user-list.js" type="text/javascript"></script>
	</body>

</html>