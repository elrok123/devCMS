<?php ob_start(); include ('../dbaccess/index.php'); session_start(); ?>
<!DOCTYPE html>
<html>

	<head>

		<link rel="stylesheet" type="text/css" href="../css/css.css" />
		<title>KoanSystems Admin Area</title>
		<link href="../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />

		<?php 
				
			if(isset($_SESSION["username"]))
			{
				header("Location: panel/");
			}

		?>

	</head>

	<body>


			<div id="loginContent">
				<div id="loginContent2">
					<img src="../img/logo.png" id="logo" />
					</br></br>
				</div>

			<form action="/administrator/" method="post">

			<div id="text-boxes">

					<input type="hidden" value="1" name="submitted" method="POST" />
					<h9>Username:</h9>

					<input type="text" value="" size="39px" name="username" />

				</br>
					<h9>Password:</h9>
					<input type="password" value="" size="39px" name="password" />

			</div>
					<div id="submit-button">

						<input type="submit" value="Submit"/>
						
					</div>

				</form>

			</div>

			<?php

				if(isset($_POST["submitted"]) == 1)
				{

					$username = $_POST["username"];
					$password = $_POST["password"];
					
					if($password == "")
					{
						die ("<script type='text/javascript'>var id = 'loginFail'; var displayType = 'none'; setTimeout('document.getElementById(id).style.display=displayType', 6000); </script><div id='loginFail'><h9>Your username or password is incorrect.</h9></div>");
					}

					$statement = $conn->prepare("SELECT * FROM users");
					$statement->execute();
					$complete = 0;
					$usernameValidated = 0;
					$passSubmitHashed = crypt($password, "\$iLikePotatoes\$");
					
					while($person = $statement->fetch())
					{
						if($username == $person['Username'])
						{
							$passwordcompare = $person['Password'];
							$id = $person['ID'];
							$usernameValidated++;
							$complete++;
							break;
						}
				
					}
					if($complete == 0)
					{
					
						die("<script type='text/javascript'>var id = 'loginFail'; var displayType = 'none'; setTimeout('document.getElementById(id).style.display=displayType', 6000); </script><div id='loginFail'><h9>Your username or password is incorrect.</h9></div>");
					
					}

				
					if($usernameValidated == 1)
					{
						if($passSubmitHashed == $passwordcompare)
						{
						
							$usernameValidated++;
						
						}
					}


					if($usernameValidated < 2)
					{
						die ("<script type='text/javascript'>var id = 'loginFail'; var displayType = 'none'; setTimeout('document.getElementById(id).style.display=displayType', 6000); </script><div id='loginFail'><h9>Your username or password is incorrect.</h9></div>");
					}

				}
					
				if(isset($_POST["submitted"]) == 1 && isset($usernameValidated) == 2)
				{		

					$_SESSION["ID"] = $id;
					$_SESSION["username"] = $username;
					$_SESSION["passed"] = $_POST["submitted"];

					header("Location: panel/");
					
				}
				else
				{
				
					$_SESSION["passed"] = 0;
				}
			?>
		</div>

	
	</body>

</html>