<?php include('../../../../dbaccess/index.php');  include('../../../../dbaccess/modules.php');

	session_start();
	
	$username = $_SESSION['username'];
	
	unset($_SESSION['pageEdit']);
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}
	if(isset($_POST['savePage']) && $_POST['pageName'] != "")
	{		
	
		$pageToSave = $_POST['pageName'];
		$pageVisible = $_POST['pageVisible'];		
								
		$statement = $conn->prepare("INSERT INTO pages (Visible, pageName) VALUES (:pageVisible, :pageToSave)");
		$statement->bindParam(":pageVisible", $pageVisible);
		$statement->bindParam(":pageToSave", $pageToSave);
		$statement->execute();

		$returnToPageList++;
		if(isset($returnToPageList))
		{
			header("Location: ../");
		}
			

	}
	else if(isset($_POST['savePage']))
	{
		$displayError++;
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
					echo "document.getElementById('user_failed').style.display='block';";
				}
			

			?>
		</script>	
	</head>

	<body>
		<div id="user_accepted">
			Your delete was successful!
		</div>
		<div id="user_failed">
			Please enter a valid name for the page!
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
			<h1 class="title">New Page</h1>
			<div id="content1">
				<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
						<tr>
							<td style="width: 70%; text-align: left; height: 40px; padding: 10px; border-right: solid 1px #dadada;">
								<form action="../newPage/" method="post">
									<input type="hidden" value="1" name="savePage" />
									<label>Page Name: </label>
									<input type="text" tag="Please make sure that you do not use a name already assigned to another page." alt="Please make sure that you do not use a name already assigned to another page." name="pageName" value="" /></br></br>
									<label>Select Visibility: </label>
									<select name="pageVisible">
										<option value="1" selected> Visible</option>
										<option value="0">Not Visible</option>
										
									</select></br></br>
									<input type="submit" name="newPageSubmit" value="Save Page"/>
								</form>
							</td>

							<td style="width: 30%; height: 40px;">
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