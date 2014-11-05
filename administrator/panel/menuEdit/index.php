<?php include('../../../dbaccess/index.php');  include('../../../dbaccess/modules.php');
		session_start();
		
		if(isset($_SESSION["username"]) == false)
		{
	
			header("Location: ../");	
	
		}
		
		$username = $_SESSION["username"];
		$redirect = "";
		
		if(isset($_POST['menuItemTypeId']))
		{
			$menuItemTypeId = $_POST['menuItemTypeId'];
			$menuItemType = $_POST['menuItemType'];
			if($menuItemType == 1)
			{
				$statement = $conn->prepare("UPDATE `pages` SET `Parent` = '' WHERE `ID` = :menuItemTypeId ");
				$statement->bindParam(":menuItemTypeId", $menuItemTypeId);
				$statement->execute();
			}
			
			$statement = $conn->prepare("UPDATE `pages` SET `isParent` = :menuItemType WHERE `ID` = :menuItemTypeId ");
			$statement->bindParam(":menuItemType", $menuItemType);
			$statement->bindParam(":menuItemTypeId", $menuItemTypeId);
			$statement->execute();
		}
		
		if(isset($_POST['menuOrderId']))
		{
			$menuId = $_POST['menuOrderId'];
			$menuPosition = $_POST['menuOrder'];
			
			$statement = $conn->prepare("UPDATE pages SET MenuPosition = :menuPosition WHERE ID = :menuId ");
			$statement->bindParam(":menuPosition", $menuPosition);
			$statement->bindParam(":menuId", $menuId);
			$statement->execute();
		}
		if(isset($_POST['linkId']))
		{
			$linkValueChange = $_POST['linkValueChange'];
			$linkId = $_POST['linkId'];
			
			$statement = $conn->prepare("UPDATE pages SET link = :linkValue WHERE ID = :linkId ");
			$statement->bindParam(":linkValue", $linkValueChange);
			$statement->bindParam(":linkId", $linkId);
			$statement->execute();
			$redirect = "<script type='text/javascript'>window.location='../menuEdit/';</script>";
		}
		if(isset($_POST['menuItemParentId']))
		{
			$menuId = $_POST['menuItemParentId'];
			$menuParent = $_POST['menuItemParent'];
			
			$statement = $conn->prepare("UPDATE pages SET Parent = :menuParent WHERE ID = :menuId ");
			$statement->bindParam(":menuParent", $menuParent);
			$statement->bindParam(":menuId", $menuId);
			$statement->execute();
		}
		if(isset($_POST['visible']))
		{
			$pageID = $_POST['visibleId'];
			$visibleOutcome = $_POST['visible'];
			$statement = $conn->prepare("UPDATE pages SET Visible = :visibleOutcome WHERE ID = :pageID ");
			$statement->bindParam(":visibleOutcome", $visibleOutcome);
			$statement->bindParam(":pageID", $pageID);
			$statement->execute();
		}
		if(isset($_POST['clickable']))
		{
			$pageID = $_POST['clickableId'];
			$clickable = $_POST['clickable'];
			$statement = $conn->prepare("UPDATE pages SET clickable = :clickable WHERE ID = :pageID ");
			$statement->bindParam(":clickable", $clickable);
			$statement->bindParam(":pageID", $pageID);
			$statement->execute();
		}
		if(isset($_POST['bottomMenuvisibility']))
		{
			$pageID = $_POST['bottomMenuvisibility'];
			$visibleOutcome = $_POST['bottomMenuVisible'];
			$statement = $conn->prepare("UPDATE pages SET bottomMenuVisible = :visibleOutcome WHERE ID = :pageID ");
			$statement->bindParam(":visibleOutcome", $visibleOutcome);
			$statement->bindParam(":pageID", $pageID);
			$statement->execute();
		}
		if(isset($_POST['topMenuvisibility']))
		{
			$pageID = $_POST['topMenuvisibility'];
			$visibleOutcome = $_POST['topMenuVisible'];
			$statement = $conn->prepare("UPDATE pages SET topMenuVisible = :visibleOutcome WHERE ID = :pageID ");
			$statement->bindParam(":visibleOutcome", $visibleOutcome);
			$statement->bindParam(":pageID", $pageID);
			$statement->execute();
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
		
	?>
<!DOCTYPE html>
<html>

	<head>

		<link rel="stylesheet" type="text/css" href="../../../css/css.css" />
		<title>KoanSystems Admin Area</title>
		<link href="../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<?php echo $redirect; ?>
	</head>

	<body>
		<div id="user_accepted">
				Your delete was successful!
			</div>
			<div id="user_failed">
				Your delete was not successful!
			</div>
		<div id="main" style="">
			<table style="border-bottom: solid 2px #dadada; ">
				<tr>	
					<td style="padding-left: 20px;">
						<a href="../../panel/">
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
		<h1 class="title">Menu Edit</h1>
		<div id="content1" style="text-align: left;">
			<a href="newLink/" style="float: right;">Add link...</a>
			<h1 class="title">Parents:</h1>
			<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
				<tbody>
					<tr>
						<td style="width: 30%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Page Title</u></h4>
							
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Parent ID:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Clickable:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Item Order:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible on Top Menu:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible on Bottom Menu:</u></h4>
						</td>
						<td style="width: 12%; height: 40px;  border-bottom: solid 1px #dadada; border-right: solid 1px #dadada;">
							<h4><u>Type:</u></h4>
						</td>
						<td style="width: 12%; height: 40px;  border-bottom: solid 1px #dadada;">
							<h4><u>Delete:</u></h4>
						</td>
					</tr>
					
				<?php
					
					$statement = $conn->prepare("SELECT * FROM pages WHERE isParent = 1 AND type != 1");
					$statement->execute();
					$statement2 = $conn->prepare("SELECT * FROM pages");
					$statement2->execute();
				
					while($blocks = $statement->fetch())
					{
						?>
						<tr>
							<td style="width: 36%; height: 40px; border-right: solid 1px #dadada;">
								<form action="parentEdit" method="post">
									<input type="hidden" value="<?php echo $blocks['ID']; ?>" name="pageToEdit" />
									<input type="hidden" value="<?php echo $blocks['pageName']; ?>" name="displayOnly" />
									<p><?php echo $blocks['pageName']; ?></p>
								</form>
							</td>
							<td style="width: 12%; height: 40px; border-right: solid 1px #dadada;">
								<?php
									echo $blocks['ID'];
								?>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="visibleId" value="<?php echo $blocks['ID'] ?>" />
									<select name="visible" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['Visible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['Visible'] == 0){echo "selected";}?>>False</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="clickableForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="clickableForm" name="clickableId" value="<?php echo $blocks['ID'] ?>" />
									<select name="clickable" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['clickable'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['clickable'] == 0){echo "selected";}?>>False</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="menuOrderId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuOrder" onchange='this.form.submit()'>
									
										<?php
											
											$numRows = $statement2->rowCount();
											$i = 1;
											
											while($i < ($numRows+2))
											{
												if($blocks['MenuPosition'] == $i)
												{
													$selected = "selected";
												}
												else
												{
													$selected = "";
												}
												
												echo "<option value='".$i."' ".$selected.">".$i."</option>";
												$i++;
											}
										?>
										
										
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="topMenuvisibilityForm">
									<input type="hidden"  id="visibilityForm" name="topMenuvisibility" value="<?php echo $blocks['ID']; ?>" />
									<select name="topMenuVisible" onchange='this.form.submit()'>
									
										<option value="1" <?php if($blocks['topMenuVisible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['topMenuVisible'] == 0){echo "selected";}?>>False</option>							
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="bottomMenuvisibilityForm">
									<input type="hidden"  id="visibilityForm" name="bottomMenuvisibility" value="<?php echo $blocks['ID']; ?>" />
									<select name="bottomMenuVisible" onchange='this.form.submit()'>
									
										<option value="1" <?php if($blocks['bottomMenuVisible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['bottomMenuVisible'] == 0){echo "selected";}?>>False</option>							
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;" >
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="menuTypeForm">
									<input type="hidden"  id="visibilityForm" name="menuItemTypeId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuItemType" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['isParent'] == 1){echo "selected";}?>>Parent</option>
										<option value="0" <?php if($blocks['isParent'] == 0){echo "selected";}?>>Child</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px;" >
								<form action="../menuEdit/" name="deleteForm" method="post">
									<input type="hidden" style="background: none url('/css/delete.png'); border: none;" value="<?php echo $blocks['ID']; ?>" name="hiddenDelete" />
									<input type="submit" name="submitDeletion" style="cursor: pointer; width: 32px; height: 32px; background: none; background-image: url('../../../css/delete.png'); background-position: center center; border: none;" value="" name="hiddenDelete" />
								</form>
							</td>
						<?php
					
					}
				
				?>

					</tr>
				</tbody>
			</table>
		</div>
		<div id="content1">
			<h1 class="title" style="text-align: left;">Children:</h1>
			<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
				<tbody>
					<tr>
						<td style="width: 36%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Page Title:</u></h4>
							
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Child ID:</u></h4>
						</td>

						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Parent:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Item Order:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible on Top Menu:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible on Bottom Menu:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-bottom: solid 1px #dadada; border-right: solid 1px #dadada;">
							<h4><u>Type:</u></h4>
						</td>
						<td style="width: 12%; height: 40px;  border-bottom: solid 1px #dadada;">
							<h4><u>Delete:</u></h4>
						</td>
					</tr>
				<?php
					
					$statement = $conn->prepare("SELECT * FROM pages WHERE isParent = 0 AND type != 1");
					$statement->execute();
				
					while($blocks = $statement->fetch())
					{
						?>
						<tr>
							<td style="width: 36%; height: 40px; border-right: solid 1px #dadada;">
								<form action="blockCodeEdit/" method="post">
									<input type="hidden" value="<?php echo $blocks['ID']; ?>" name="pageToEdit" />
									<input type="hidden" value="<?php echo $blocks['pageName']; ?>" name="displayOnly" />
									<p><?php echo $blocks['pageName']; ?></p>
								</form>
							</td>
							<td style="width: 12%; height: 40px; border-right: solid 1px #dadada;">
								<?php
									echo $blocks['ID'];
								?>
							</td>

							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;" >
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="menuItemParentForm">
									<input type="hidden"  id="visibilityForm" name="menuItemParentId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuItemParent" onchange='this.form.submit()'>
										<?php
										
											$statement2 = $conn->prepare("SELECT * FROM pages WHERE isParent = 1 AND type != 1");
											$statement2->execute();
											
											$selected = "";
											unset($unselectedRepeatBlock);
											
											while($pages = $statement2->fetch())
											{
												
												if($blocks['Parent'] == $pages['ID'])
												{
													$selected = "selected";
												}
												else
												{
													$selected = "";
													
												}
												
												if($blocks['Parent'] == 0 && isset($unselectedRepeatBlock) == false)
												{
													echo "<option selected>-Undefined-</option>";
													$selected = "";
													$unselectedRepeatBlock++;
													
												}
												
												if($pages['ID'] != $blocks['ID'])
												{
													echo "<option value='".$pages['ID']."' ".$selected.">".$pages['pageName']."</option>
													";
												}
												
											}
										?>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="visibleId" value="<?php echo $blocks['ID'] ?>" />
									<select name="visible" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['Visible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['Visible'] == 0){echo "selected";}?>>False</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="menuOrderId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuOrder" onchange='this.form.submit()'>
									
										<?php
											
											$statement3 = $conn->prepare("SELECT * FROM pages WHERE isParent = 0");
					
											$statement3->execute();
											
											$numRows4 = $statement3->rowCount();
											$i4 = 1;
											
											$selected = "";
											
											while($i4 < ($numRows4+2))
											{
												if($blocks['MenuPosition'] == $i4)
												{
													$selected = "selected";
												}
												else
												{
													$selected = "";
												}
												
												echo "<option value='".$i4."' ".$selected.">".$i4."</option>";
												$i4++;
											}
										?>
										
										
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="topMenuvisibilityForm">
									<input type="hidden"  id="visibilityForm" name="topMenuvisibility" value="<?php echo $blocks['ID']; ?>" />
									<select name="topMenuVisible" onchange='this.form.submit()'>
									
										<option value="1" <?php if($blocks['topMenuVisible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['topMenuVisible'] == 0){echo "selected";}?>>False</option>							
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="bottomMenuvisibilityForm">
									<input type="hidden"  id="visibilityForm" name="bottomMenuvisibility" value="<?php echo $blocks['ID']; ?>" />
									<select name="bottomMenuVisible" onchange='this.form.submit()'>
									
										<option value="1" <?php if($blocks['bottomMenuVisible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['bottomMenuVisible'] == 0){echo "selected";}?>>False</option>							
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;" >
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="menuTypeForm">
									<input type="hidden"  id="visibilityForm" name="menuItemTypeId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuItemType" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['isParent'] == 1){echo "selected";}?>>Parent</option>
										<option value="0" <?php if($blocks['isParent'] == 0){echo "selected";}?>>Child</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px;" >
								<form action="../menuEdit/" name="deleteForm" method="post">
									<input type="hidden" style="background: none url('/css/delete.png'); border: none;" value="<?php echo $blocks['ID']; ?>" name="hiddenDelete" />
									<input type="submit" name="submitDeletion" style="cursor: pointer; width: 32px; height: 32px; background: none; background-image: url('../../../css/delete.png'); background-position: center center; border: none;" value="" name="hiddenDelete" />
								</form>
							</td>
						</tr>	
						<?php
					
					}
				
				?>
				</tbody>
			</table>
		</div>
		<div id="content1" style="text-align: left;">
			<h1 class="title">Parent Links:</h1>
			<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
				<tbody>
					<tr>
						<td style="width: 18%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Page Title</u></h4>
							
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Parent ID:</u></h4>
						</td>
						<td style="width: 14%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Link Value:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Clickable:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Item Order:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible on Top Menu:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible on Bottom Menu:</u></h4>
						</td>
						<td style="width: 12%; height: 40px;  border-bottom: solid 1px #dadada; border-right: solid 1px #dadada;">
							<h4><u>Type:</u></h4>
						</td>
						<td style="width: 12%; height: 40px;  border-bottom: solid 1px #dadada;">
							<h4><u>Delete:</u></h4>
						</td>
					</tr>
				<?php
					
					$statement = $conn->prepare("SELECT * FROM pages WHERE isParent = 1 AND type = 1");
					$statement->execute();
				
					while($blocks = $statement->fetch())
					{
						?>
						<tr>
							<td style="width: 18%; height: 40px; border-right: solid 1px #dadada;">
								<form action="parentEdit" method="post">
									<input type="hidden" value="<?php echo $blocks['ID']; ?>" name="pageToEdit" />
									<input type="hidden" value="<?php echo $blocks['pageName']; ?>" name="displayOnly" />
									<p><?php echo $blocks['pageName']; ?></p>
								</form>
							</td>
							<td style="width: 12%; height: 40px; border-right: solid 1px #dadada;">
								<?php
									echo $blocks['ID'];
								?>
							</td>
							<td style="width: 14%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" method="post">
									<input type="hidden" name="linkId" value="<?php
										echo $blocks['ID'];
									?>">
									<input name="linkValueChange" type="text" style="width: 60px;" value="<?php
										echo $blocks['link'];
									?>" />
									<input name="linkValueSubmit" type="submit" value="✓" />
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="visibleId" value="<?php echo $blocks['ID'] ?>" />
									<select name="visible" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['Visible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['Visible'] == 0){echo "selected";}?>>False</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="clickableForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="clickableForm" name="clickableId" value="<?php echo $blocks['ID'] ?>" />
									<select name="clickable" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['clickable'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['clickable'] == 0){echo "selected";}?>>False</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="menuOrderId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuOrder" onchange='this.form.submit()'>
									
										<?php
											
											$numRows = $statement->rowCount();
											$i = 1;
											
											while($i < ($numRows+2))
											{
												if($blocks['MenuPosition'] == $i)
												{
													$selected = "selected";
												}
												else
												{
													$selected = "";
												}
												
												echo "<option value='".$i."' ".$selected.">".$i."</option>";
												$i++;
											}
										?>
										
										
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="topMenuvisibilityForm">
									<input type="hidden"  id="visibilityForm" name="topMenuvisibility" value="<?php echo $blocks['ID']; ?>" />
									<select name="topMenuVisible" onchange='this.form.submit()'>
									
										<option value="1" <?php if($blocks['topMenuVisible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['topMenuVisible'] == 0){echo "selected";}?>>False</option>							
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="bottomMenuvisibilityForm">
									<input type="hidden"  id="visibilityForm" name="bottomMenuvisibility" value="<?php echo $blocks['ID']; ?>" />
									<select name="bottomMenuVisible" onchange='this.form.submit()'>
									
										<option value="1" <?php if($blocks['bottomMenuVisible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['bottomMenuVisible'] == 0){echo "selected";}?>>False</option>							
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;" >
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="menuTypeForm">
									<input type="hidden"  id="visibilityForm" name="menuItemTypeId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuItemType" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['isParent'] == 1){echo "selected";}?>>Parent</option>
										<option value="0" <?php if($blocks['isParent'] == 0){echo "selected";}?>>Child</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px;" >
								<form action="../menuEdit/" name="deleteForm" method="post">
									<input type="hidden" style="background: none url('/css/delete.png'); border: none;" value="<?php echo $blocks['ID']; ?>" name="hiddenDelete" />
									<input type="submit" name="submitDeletion" style="cursor: pointer; width: 32px; height: 32px; background: none; background-image: url('../../../css/delete.png'); background-position: center center; border: none;" value="" name="hiddenDelete" />
								</form>
							</td>
						</tr>	
						<?php
					
					}
				
				?>
				</tbody>
			</table>
		</div>
		<div id="content1">
			<h1 class="title" style="text-align: left;">Children Links:</h1>
			<table style="width: 100%; text-align: center; border: solid 1px #dadada;">
				<tbody>
					<tr>
						<td style="width: 18%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Page Title:</u></h4>
							
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Child ID:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Link Value:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Parent:</u></h4>
						</td>
						<td style="width: 12%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Item Order:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible on Top Menu:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;">
							<h4><u>Visible on Bottom Menu:</u></h4>
						</td>
						<td style="width: 8%; height: 40px; border-bottom: solid 1px #dadada; border-right: solid 1px #dadada;">
							<h4><u>Type:</u></h4>
						</td>
						<td style="width: 8%; height: 40px;  border-bottom: solid 1px #dadada;">
							<h4><u>Delete:</u></h4>
						</td>
					</tr>
					
				<?php
					
					$statement = $conn->prepare("SELECT * FROM pages WHERE isParent = 0 AND type = 1");
					$statement->execute();
				
					while($blocks = $statement->fetch())
					{
						?>
						<tr>
							<td style="width: 18%; height: 40px; border-right: solid 1px #dadada;">
								<form action="blockCodeEdit/" method="post">
									<input type="hidden" value="<?php echo $blocks['ID']; ?>" name="pageToEdit" />
									<input type="hidden" value="<?php echo $blocks['pageName']; ?>" name="displayOnly" />
									<p><?php echo $blocks['pageName']; ?></p>
								</form>
							</td>
							<td style="width: 12%; height: 40px; border-right: solid 1px #dadada;">
								<?php
									echo $blocks['ID'];
								?>
							</td>
							<td style="width: 12%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" method="post">
									<input type="hidden" name="linkId" value="<?php
										echo $blocks['ID'];
									?>" />
									<input name="linkValueChange" type="text" style="width: 60px;" value="<?php
										echo $blocks['link'];
									?>" />
									<input name="linkValueSubmit" type="submit" value="✓" />
								</form>							
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;" >
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="menuItemParentForm">
									<input type="hidden"  id="visibilityForm" name="menuItemParentId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuItemParent" onchange='this.form.submit()'>
										<?php
										
											$statement2 = $conn->prepare("SELECT * FROM pages WHERE isParent = 1");
											$statement2->execute();
											
											$selected = "";
											unset($unselectedRepeatBlock);
											
											while($pages = $statement2->fetch())
											{
												
												if($blocks['Parent'] == $pages['ID'])
												{
													$selected = "selected";
												}
												else
												{
													$selected = "";
													
												}
												
												if($blocks['Parent'] == 0 && isset($unselectedRepeatBlock) == false)
												{
													echo "<option selected>-Undefined-</option>";
													$selected = "";
													$unselectedRepeatBlock++;
													
												}
												
												if($pages['ID'] != $blocks['ID'])
												{
													echo "<option value='".$pages['ID']."' ".$selected.">".$pages['pageName']."</option>
													";
												}
												
											}
										?>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="visibleId" value="<?php echo $blocks['ID'] ?>" />
									<select name="visible" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['Visible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['Visible'] == 0){echo "selected";}?>>False</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="visibilityForm">
									<input type="hidden"  id="visibilityForm" name="menuOrderId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuOrder" onchange='this.form.submit()'>
									
										<?php
											
											$statement3 = $conn->prepare("SELECT * FROM pages WHERE isParent = 0");
					
											$statement3->execute();
											
											$numRows4 = $statement3->rowCount();
											$i4 = 1;
											
											$selected = "";
											
											while($i4 < ($numRows4+2))
											{
												if($blocks['MenuPosition'] == $i4)
												{
													$selected = "selected";
												}
												else
												{
													$selected = "";
												}
												
												echo "<option value='".$i4."' ".$selected.">".$i4."</option>";
												$i4++;
											}
										?>
										
										
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="topMenuvisibilityForm">
									<input type="hidden"  id="visibilityForm" name="topMenuvisibility" value="<?php echo $blocks['ID']; ?>" />
									<select name="topMenuVisible" onchange='this.form.submit()'>
									
										<option value="1" <?php if($blocks['topMenuVisible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['topMenuVisible'] == 0){echo "selected";}?>>False</option>							
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;">
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="bottomMenuvisibilityForm">
									<input type="hidden"  id="visibilityForm" name="bottomMenuvisibility" value="<?php echo $blocks['ID']; ?>" />
									<select name="bottomMenuVisible" onchange='this.form.submit()'>
									
										<option value="1" <?php if($blocks['bottomMenuVisible'] == 1){echo "selected";}?>>True</option>
										<option value="0" <?php if($blocks['bottomMenuVisible'] == 0){echo "selected";}?>>False</option>							
										
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px; border-right: solid 1px #dadada;" >
								<form action="../menuEdit/" id="visibilityForm" method="POST" name="menuTypeForm">
									<input type="hidden"  id="visibilityForm" name="menuItemTypeId" value="<?php echo $blocks['ID']; ?>" />
									<select name="menuItemType" onchange='this.form.submit()'>
										<option value="1" <?php if($blocks['isParent'] == 1){echo "selected";}?>>Parent</option>
										<option value="0" <?php if($blocks['isParent'] == 0){echo "selected";}?>>Child</option>
									</select>
								</form>
							</td>
							<td style="width: 8%; height: 40px;" >
								<form action="../menuEdit/" name="deleteForm" method="post">
									<input type="hidden" style="background: none url('/css/delete.png'); border: none;" value="<?php echo $blocks['ID']; ?>" name="hiddenDelete" />
									<input type="submit" name="submitDeletion" style="cursor: pointer; width: 32px; height: 32px; background: none; background-image: url('../../../css/delete.png'); background-position: center center; border: none;" value="" name="hiddenDelete" />
								</form>
							</td>
							
						<?php
					
					}
				
				?>

					</tr>
				</tbody>
			</table>
		</div>

			<div id="footer">

				</br></br>Copyright &copy; KoanSystems 			

			</div>	
		</div>
		<script src="/js/user-list.js" type="text/javascript"></script>
	</body>

</html>