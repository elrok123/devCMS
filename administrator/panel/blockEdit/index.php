<?php include('../../../dbaccess/index.php');  include('../../../dbaccess/modules.php');

	session_start();
	
	$username = $_SESSION['username'];
	
	if(isset($_POST['standardSave']))
	{
		$pageToEdit = $_POST['pageToEdit'];
		$mainBlockCode = $_POST['mainBlock-code'];
		$mainBlockDisabled = $_POST['mainBlockDisabled'];
		$footer = $_POST['footer-code'];
		$copyright = $_POST['copyright-code'];
			
		$statement = $conn->prepare("UPDATE pages SET 
											FBL = :mainBlockCode, FBLDisabled = :mainBlockDisabled,  
											Footer = :footer, 
											Copyright = :copyright 
											WHERE ID = :pageToEdit");
		
		try {
			$statement->bindParam(":mainBlockCode", $mainBlockCode);
			$statement->bindParam(":mainBlockDisabled", $mainBlockDisabled);
			$statement->bindParam(":footer", $footer);
			$statement->bindParam(":copyright", $copyright);
			$statement->bindParam(":pageToEdit", $pageToEdit);
			$statement->execute();		
		} catch (Exception $e) {
			echo $e;
		}			
	}
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}

	if(isset($_POST['hiddenDelete']))
	{
				
		$pageToDelete = $_POST['hiddenDelete'];		
					
		$statement = $conn->prepare("DELETE FROM pages WHERE ID = :pageToDelete");
		$statement->bindParam(":pageToDelete", $pageToDelete);
		
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
	if(isset($_POST['visible']))
	{
		$pageID = $_POST['visibleId'];
		$visibleOutcome = $_POST['visible'];
		$statement = $conn->prepare("UPDATE pages SET Visible = :visibleOutcome WHERE ID = :pageID");
		$statement->bindParam(":visibleOutcome", $visibleOutcome);
		$statement->bindParam(":pageID", $pageID);
		$statement->execute();
	}
	
	if(isset($_POST['landingPageId']))
	{
		$statement = $conn->prepare("UPDATE pages SET landingPage = 0");
		$statement->execute();
		$landingPageId = $_POST['landingPageId'];

		$statement = $conn->prepare("UPDATE pages SET landingPage = 1 WHERE ID = :landingPageId");
		$statement->bindParam(":landingPageId", $landingPageId);
		$statement->execute();
	}
?>
<!DOCTYPE html>
<html>

	<head>

		<link rel="stylesheet" type="text/css" href="../../../css/css.css" />
		<title>KoanSystems Admin Area</title>
		<link href="../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script type="text/javascript" src="../../../css/js.js"></script>
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
		<h1 class="title">Block Edit</h1>
		<div id="content1" style="text-align: right;">
			<a href="newPage/">Add a new page...</a></br></br>
				
				<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
			
					<tr>
						<td style="width: 20%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Page Title</u></h4>
							
						</td>
						<td style="width: 20%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Page ID:</u></h4>
						</td>
						<td style="width: 20%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible:</u></h4>
						</td>
						<td style="width: 20%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>DNS Landing Page:</u></h4>
						</td>
						<td style="width: 20%; height: 40px;  border-bottom: solid 1px #dadada;">
							<h4><u>Delete:</u></h4>
						</td>
					</tr>
				
				<?php
					
					$statement = $conn->prepare("SELECT * FROM pages WHERE type != 1");
					$statement->execute();
				
					while($blocks = $statement->fetch())
					{
						?>
						<tr>
							<td style="width: 20%; height: 40px; border-right: solid 1px #dadada;">
								<form action="blockCodeEdit/" method="get">
									<input type="hidden" value="<?php echo $blocks['ID']; ?>" name="pageToEdit" />
									<input type="hidden" value="<?php echo $blocks['pageName']; ?>" name="displayOnly" />
									<input type="submit" name="displayOnly1" value="<?php echo $blocks['pageName']; ?>" style="cursor: pointer; background: none; width: auto; height: auto; border: none; text-decoration: underline;" />
								</form>
							</td>
							<td style="width: 20%; height: 40px; border-right: solid 1px #dadada;">
								<?php
									echo $blocks['ID'];
								?>
							</td>
							<td style="width: 20%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../blockEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="visibleId" value="<?php echo $blocks['ID'] ?>" />
									<select name="visible" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['Visible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['Visible'] == 0){echo "selected";}?>>False</option>
									</select>
								</form>
							</td>
							<td style="width: 20%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../blockEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="landingPageId" value="<?php echo $blocks['ID'] ?>" />
									<input type="radio" onchange='this.form.submit()' name="landingPage" value="1" <?php if($blocks['landingPage'] == 1){echo "checked";}?>/></br>
								</form>
							</td>
							<td style="width: 20%; height: 40px;" >
								<form action="../blockEdit/" name="deleteForm" method="post">
									<input type="hidden" style="background: none url('/css/delete.png'); border: none;" value="<?php echo $blocks['ID']; ?>" name="hiddenDelete" />
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