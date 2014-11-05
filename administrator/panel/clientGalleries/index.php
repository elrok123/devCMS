<?php session_start(); include('../../../dbaccess/index.php');  include('../../../dbaccess/modules.php');

	
	
	$username = $_SESSION['username'];
	
	unset($_SESSION['galleryToEdit']);
	unset($_SESSION['displayOnly']);

	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}
	if(isset($_POST['hiddenDelete']))
	{
				
		$galleryToDelete = $_POST['hiddenDelete'];		
					
		$statement = $conn->prepare("DELETE FROM gallery WHERE ID = :galleryToDelete");
		$statement->bindParam(":galleryToDelete", $galleryToDelete);
		try
		{
			$statement->execute();
			echo "<script type='text/javascript'>setTimeout('showDeleteSuccess()', 1000);</script>";
		}
		catch(PDOException $e)
		{
			echo "<script type='text/javascript'>setTimeout('showDeleteFailure()', 1000);</script>";
			if($e != "" || $e != NULL)
			{
				echo $e;
			}
		}
	}
	
?>
<!DOCTYPE html>
<html>

	<head>

		<link rel="stylesheet" type="text/css" href="../../../css/css.css" />
		<title>KoanSystems Gallery Area</title>
		<link href="../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script type="text/javascript" src="../../../css/js.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="/js/jquery_ui.js" type="text/javascript"></script>
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
		</script>	
	</head>

	<body>
		<div id="user_accepted">
			Your delete was successful!
		</div>
		<div id="user_failed">
			Your delete was not successful!
		</div>
		<div id="main">
			<table style="border-bottom: solid 2px #dadada;">
				<tr>	
					<td style="padding-left: 20px;">
						<a href="../">
							<img src="../../../img/logo.png" style="width: 100px; height: auto; margin-left: auto; margin-right: auto;"/>
						</a>
					</td>
					<td style="width: 80%;">
						
					</td>
					<td>
						<div id="user" onMouseOver="this.style.boxShadow='0px 1px 2px #404040'; this.style.borderLeft='2px solid #00CCFF';" onMouseOut="this.style.boxShadow='none'; this.style.borderLeft='2px solid #dadada';" style="padding: 10px; width: 150px; height: 25px; border-left: solid 2px #dadada; margin-right: 0px; margin-left: auto; margin-top: 0px; margin-bottom: auto;"><h9>Welcome, <?php echo $username; ?>.</h9></br><a href="../../logout/" style="color: #0c0c0c;">Logout...</a></div>
					</td>
				<tr>
			</table>
		<h1 class="title">Galleries</h1>
		<div id="content1" style="text-align: right;">
			<a href="addGallery/">Add a new gallery...</a></br></br>
				
				<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
			
					<tr>
						<td style="width: 20%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Gallery ID:</u></h4>
						</td>
						<td style="width: 20%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Client's Full Name:</u></h4>
							
						</td>
						<td style="width: 20%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Assigned to User: </br>(Click gallery name to view gallery):</u></h4>
						</td>
						<td style="width: 20%; height: 40px;  border-bottom: solid 1px #dadada;">
							<h4><u>Delete Gallery: <?php $userDetails->getID(); ?></u></h4>
						</td>
					</tr>
				
				<?php
					$statement = $conn->prepare("SELECT gallery.*, users.firstname, users.surname FROM gallery JOIN users ON gallery.clientId = users.ID WHERE users.ID = :clientID");
					$statement->bindParam(":clientID", $userDetails->getID());
					$statement->execute();
				
					while($blocks = $statement->fetch())
					{
						?>
						<tr>
							<td style="width: 20%; height: 40px; border-right: solid 1px #dadada;">
								<?php
									echo $blocks['ID'];
								?>
							</td>
							<td style="width: 20%; height: 40px; border-right: solid 1px #dadada;">
								<p>
									<?php echo $blocks['firstname'] . " " . $blocks['surname']; ?>
								</p>
							</td>
							<td style="width: 20%; height: 40px; border-right: solid 1px #dadada;">
								<p>
									<form action="viewGallery/" method="get">
										<input type="hidden" value="<?php echo $blocks['ID']; ?>" name="galleryToEdit" />
										<input type="submit" title="Click to view gallery..." alt="Click to view gallery..." value="<?php echo $blocks['galleryName']; ?>" name="editGallerySubmit" />
									</form>
								</p>
							</td>
							<td style="width: 20%; height: 40px;" >
								<form action="" name="deleteForm" method="post">
									<input type="hidden" style="background: none url('../../../css/delete.png'); border: none;" value="<?php echo $blocks['ID']; ?>" name="hiddenDelete" />
									<input type="submit" name="submitDeletion" style="cursor: pointer; width: 32px; height: 32px; background: none; background-image: url('../../../css/delete.png'); background-position: center center; border: none;" value="" name="hiddenDelete" />
								</form>
							</td>
						</tr>
						<?php
					}
				?>
			
			</table>
						
		</div>
			<div id="footer">

				</br></br>Copyright &copy; KoanSystems 			

			</div>	
		</div>
		<script src="/js/user-list.js" type="text/javascript"></script>
	</body>

</html>
