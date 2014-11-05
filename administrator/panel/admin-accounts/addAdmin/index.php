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
		if($_POST['adminPass'] == $_POST['adminPassVerify'] && $_POST['adminUsername'] != "" && $_POST['adminFirstname'] != "" && $_POST['adminSurname'] != "" && $_POST['adminEmail'] != "" && $_POST['adminSurname'] != "")
		{
			$statement = $conn->prepare("INSERT INTO users (username, firstname, surname, email, Password) VALUES (:username, :firstname, :surname, :email, :password)");
			$statement->bindParam(":username", $_POST['adminUsername']);
			$statement->bindParam(":firstname", $_POST['adminFirstname']);
			$statement->bindParam(":surname", $_POST['adminSurname']);
			$statement->bindParam(":email", $_POST['adminEmail']);
			$statement->bindParam(":password", crypt($_POST['adminPass'], "\$iLikePotatoes\$"));
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
			<h1 class="title">Add a new administrator account:</h1>
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
												<input type="hidden" value="1" name="saveAdmin" />
												<label>Firstname: </label>
											</td>
											<td style="text-align: left;">
												<input type="text" tag="" alt="" name="adminFirstname" placeholder="Firstname" value="<?php if(isset($_POST['adminFirstname'])){ echo $_POST['adminFirstname']; } ?>" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Surname: </label>
											</td>
											<td style="text-align: left;">
												<input type="text" tag="" alt="" name="adminSurname" placeholder="Surname" value="<?php if(isset($_POST['adminSurname'])){ echo $_POST['adminSurname']; } ?>" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Username: </label>
											</td>
											<td style="text-align: left;">
												<input type="text" tag="" alt="" name="adminUsername" placeholder="Username" value="<?php if(isset($_POST['adminUsername'])){ echo $_POST['adminUsername']; } ?>" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Email: </label>
											</td>
											<td style="text-align: left;">
												<input type="text" tag="" alt="" name="adminEmail" placeholder="Email" value="<?php if(isset($_POST['adminEmail'])){ echo $_POST['adminEmail']; } ?>" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Password:</label>
											</td>
											<td style="text-align: left;">
												<input type="password" tag="" alt="" name="adminPass" placeholder="Password" value="" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<label>Verify Password:</label>
											</td>
											<td style="text-align: left;">
												<input type="password" tag="" alt="" name="adminPassVerify" value="" placeholder="Verify Password" /></br></br>
											</td>
										</tr>
										<tr>
											<td style="text-align: center;">
											</td>
											<td style="text-align: left;">
												<input type="submit" name="newAdminSubmit" value="Create User"/>
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