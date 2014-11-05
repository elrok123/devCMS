<?php session_start(); include("../../dbaccess/index.php"); include("../../dbaccess/modules.php");
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");	

	}
	
	$statement = $conn->prepare("SELECT * FROM settings LIMIT 1");
	$statement->execute();
	$sslstate = $statement->fetch();


	$username = $userDetails->getUsername();
?>
<!DOCTYPE html>
<html>

	<head>

		<link rel="stylesheet" type="text/css" href="../../css/css.css" />
		<title>KoanSystems Admin Area</title>
		<link href="../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<?php echo ( $userDetails->getType() == 0 ? "<script src=\"/js/button-slider.js\" type=\"text/javascript\"></script>" : ""); ?>

	</head>

	<body>
		<div id="main" style="" style="border: 1px solid #0c0c0c;">
			<table style="border-bottom: solid 2px #dadada; ">
				<tr>	
					<td style="padding-left: 20px;">
						<a href="../panel/">
							<img src="../../img/logo.png" style="width: 100px; height: auto; margin-left: auto; margin-right: auto;"/>
						</a>
					</td>
					<td style="width: 80%;">
					</td>
					<td>
						<div id="user" onMouseOver="this.style.boxShadow='0px 1px 2px #404040'; this.style.borderLeft='2px solid #00CCFF';" onMouseOut="this.style.boxShadow='none'; this.style.borderLeft='2px solid #dadada';" style="padding: 10px; width: 150px; height: 25px; border-left: solid 2px #dadada; margin-right: 0px; margin-left: auto; margin-top: 0px; margin-bottom: auto;"><h9>Welcome, <?php echo $username; ?>.</h9></br><a href="../logout/" style="color: #0c0c0c;">Logout...</a></div>
					</td>
				<tr>
			</table>
		<?php 
			if($userDetails->getType() == 0)
			{
				echo "<h1 class='title'>CMS Options</h1><div id='ssl-button-cont' alt='Force the website to use a secure connection to the client, this averts man-in-the-middle attacks and snoopers from stealing data (Your web server must have an SSL ceritificate installed and set up correctly for this to work.)' title='Force the website to use a secure connection to the client, this averts man-in-the-middle attacks and snoopers from stealing data (Your web server must have an SSL ceritificate installed and set up correctly for this to work.)'>Force SSL Encryption: <div id='ssl-button'><div id='sliderOn'></div><div id='sliderOff'></div><div id='drag-slider'><div id='slider-groove'></div></div></div></div></br></br>
				<div id='content2' style=\"background: url('../../img/chat-bubbles.jpg'); box-shadow:inset 0 0 4px #404040; border: 1px solid #0c0c0c;\">
					<table>
						<tbody>
							<tr>
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='styling/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/code.png' /></br></br>
										<a href='styling/'>Styling<a/>
									</div>
								</td>
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='blockEdit/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/block.png' /></br></br>
										<a href='blockEdit/'>Page Editor <a/>
									</div>
								</td>						
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='menuEdit/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/menu.png' /></br></br>
										<a href='menuEdit/'>Menu Editor <a/>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>";
				echo "<h1 class='title'>Administration</h1>
				<div id='content2' style=\"background: url('../../img/chat-bubbles.jpg'); box-shadow:inset 0 0 4px #404040; border: 1px solid #0c0c0c;\">
					<table>
						<tbody>
							<tr>
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='gallery/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/gallery.png' /></br></br>
										<a href='gallery/'>Gallery<a/>
									</div>
								</td>
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='client-accounts/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/clients.png' /></br></br>
										<a href='client-accounts/'>Clients<a/>
									</div>
								</td>
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='admin-accounts/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/administrators.png' /></br></br>
										<a href='admin-accounts/'>Administrators<a/>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>";
				echo "<h1 class='title'>Work</h1>
				<div id='content2' style=\"background: url('../../img/chat-bubbles.jpg'); box-shadow:inset 0 0 4px #404040; border: 1px solid #0c0c0c;\">
					<table>
						<tbody>
							<tr>
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='queries/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/message.png' /></br></br>
										<a href='queries/'>Queries<a/>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>";
				echo "<h1 class='title'>Blog</h1>
				<div id='content2' style=\"background: url('../../img/chat-bubbles.jpg'); box-shadow:inset 0 0 4px #404040; border: 1px solid #0c0c0c;\">
					<table>
						<tbody>
							<tr>
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='blog/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/blog.png' /></br></br>
										<a href='blog/'>Posts<a/>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>";
			}
			else
			{
				echo "<h1 class='title'>Client Area</h1>
				<div id='content2' style=\"background: url('../../img/chat-bubbles.jpg'); box-shadow:inset 0 0 4px #404040; border: 1px solid #0c0c0c;\">
					<table>
						<tbody>
							<tr>
								<td>
									<div id='icon' class='box-shadow' onMouseOver=\"this.style.boxShadow='0px 2px 4px #0c0c0c'; this.style.background='#FAFAFA'; this.style.borderBottom='3px solid #00CCFF';\" onMouseOut=\"this.style.boxShadow='none'; this.style.background='#fff'; this.style.borderBottom='2px solid #dadada';\" onClick=\"window.location='clientGalleries/'\" style='background: #fff; border-radius: 8px; cursor: pointer;'>
										<img src='../../css/gallery.png' /></br></br>
										<a href='clientGalleries/'>My Galleries<a/>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>";
			}
		?>
			<div id="footer">
				</br></br>Copyright &copy; KoanSystems
			</div>	
		</div>
		<script type="text/javascript">var $noBack = 1;</script>
		<?php echo ( $userDetails->getType() == 0 ? "<script src=\"/js/user-list.js\" type=\"text/javascript\"></script>" : ""); ?>
		<script type="text/javascript">setSSLStateFunc('<?php echo ($sslstate['sslstate'] == 1 ? "On" : "Off"); ?>');</script>

	</body>

</html>