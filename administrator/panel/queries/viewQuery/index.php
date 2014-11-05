<?php include('../../../../dbaccess/index.php');  include('../../../../dbaccess/modules.php');

	session_start();
	if(isset($_GET['queryToView']))
	{
		$_SESSION['queryToView'] = $_GET['queryToView'];
	}
	else
	{
		header("Location: ../");
	}
	
	$username = $_SESSION['username'];
	
	unset($_SESSION['queryView']);
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}

	$statement = $conn->prepare("SELECT * FROM queries WHERE id = :queryID");
	$statement->bindParam(":queryID", $_SESSION['queryToView']);
	$statement->execute();
	$queryDetails = $statement->fetch();

	$statement = $conn->prepare("UPDATE queries SET viewed = 1 WHERE id = :queryID");
	$statement->bindParam(":queryID", $_SESSION['queryToView']);
	$statement->execute();

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
			Please enter a valid title for the query!
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
			<h1 class="title">View Query</h1>
			<div id="content1">
				<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
						<tr>
							<td style="width: 70%; text-align: left; height: 40px; padding: 10px; border-right: solid 1px #dadada;">
									<input type="hidden" value="1" name="saveQuery" />
									<label>Client Name: </label>
									<div style="border: 1px solid #ababab; padding: 10px;"><?php echo $queryDetails['clientName']; ?></div></br>
									<label>Client Email: </label>
									<div style="border: 1px solid #ababab; padding: 10px;"><?php echo $queryDetails['email']; ?></div></br>
									<label>Client Company: </label>
									<div style="border: 1px solid #ababab; padding: 10px;"><?php echo (isset($queryDetails['companyName']) ? $queryDetails['companyName'] : "No company name provided..."); ?></div></br>
									<label>Client Website: </label>
									<div style="border: 1px solid #ababab; padding: 10px;"><?php echo (isset($queryDetails['website']) ? $queryDetails['website'] : "No website provided..."); ?></div></br>
									<label>Client Telephone: </label>
									<div style="border: 1px solid #ababab; padding: 10px;"><?php echo $queryDetails['telephone']; ?></div></br>
									<label>Message:</label>
									<div style="border: 1px solid #ababab; padding: 20px;"><?php echo nl2br($queryDetails['message']); ?></div></br>
									<label>Date Posted:</label>
									<div style="border: 1px solid #ababab; padding: 10px;"><?php echo date( "d-M-Y H:i:s", strtotime( $queryDetails['dateAdded'] ) + 5 * 3600 ); ?></div></br>
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