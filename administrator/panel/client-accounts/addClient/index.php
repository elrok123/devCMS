<?php include('../../../../dbaccess/index.php');  include('../../../../dbaccess/modules.php');

	session_start();

	$username = $_SESSION['username'];
	
	unset($_SESSION['postEdit']);
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}
	try
	{
		if($_POST['clientPass'] == $_POST['clientPassVerify'] && $_POST['clientUsername'] != "" && $_POST['clientFirstname'] != "" && $_POST['clientSurname'] != "" && $_POST['clientEmail'] != "" && $_POST['clientSurname'] != "")
		{
			$statement = $conn->prepare("INSERT INTO users (username, firstname, surname, email, Password, type) VALUES (:username, :firstname, :surname, :email, :password, 1)");
			$statement->bindParam(":username", $_POST['clientUsername']);
			$statement->bindParam(":firstname", $_POST['clientFirstname']);
			$statement->bindParam(":surname", $_POST['clientSurname']);
			$statement->bindParam(":email", $_POST['clientEmail']);
			$statement->bindParam(":password", crypt($_POST['clientPass'], "\$iLikePotatoes\$"));
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
		<title>KoanSystems Client Area</title>
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
					echo "alert('Please enter a valid password.');";
				}
			?>
		</script>
		<?php 
			if(isset($error))
				echo "<script type='text/javascript'>alert('".(strpos($error, 'Duplicate') !== false ? "There is another entry with the same title, please change the title..." : "There was an error with your content..." )."');</script>";	
		?>
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
			<h1 class="title">Add a new client account:</h1>
			<div id="content1">
				<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
						<tr>
							<td style="width: 20%; height: 40px;">
							</td>
							<td style="width: 60%; text-align: center; height: 40px; padding: 10px; border-left: solid 1px #dadada; border-right: solid 1px #dadada;">
								<form action="" method="post">
									<table>
										<tr>
											<td style="text-align: right;">
												<input type="hidden" value="1" name="saveClient" />
												<label>Firstname: </label>
											</td>
											<td style="text-align: left;">
												<input type="text" tag="" alt="" name="clientFirstname" placeholder="Firstname" value="<?php if(isset($_POST['clientFirstname'])){ echo $_POST['clientFirstname']; } ?>" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Surname: </label>
											</td>
											<td style="text-align: left;">
												<input type="text" tag="" alt="" name="clientSurname" placeholder="Surname" value="<?php if(isset($_POST['clientSurname'])){ echo $_POST['clientSurname']; } ?>" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Username: </label>
											</td>
											<td style="text-align: left;">
												<input type="text" tag="" alt="" name="clientUsername" placeholder="Username" value="<?php if(isset($_POST['clientUsername'])){ echo $_POST['clientUsername']; } ?>" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Email: </label>
											</td>
											<td style="text-align: left;">
												<input type="text" tag="" alt="" name="clientEmail" placeholder="Email" value="<?php if(isset($_POST['clientEmail'])){ echo $_POST['clientEmail']; } ?>" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Password:</label>
											</td>
											<td style="text-align: left;">
												<input type="password" tag="" alt="" name="clientPass" placeholder="Password" value="" required/></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Verify Password:</label>
											</td>
											<td style="text-align: left;">
												<input type="password" tag="" alt="" name="clientPassVerify" value="" placeholder="Verify Password" required/></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: center;">
											</td>
											<td style="text-align: left;">
												<input type="submit" name="newClientSubmit" value="Create User"/>
											</td>
										</tr>
									</table>
								</form>
							</td>

							<td style="width: 20%; height: 40px;">
							</td>
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