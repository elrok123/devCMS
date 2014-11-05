<?php include('../../../dbaccess/index.php');

	session_start();
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}

	$username = $_SESSION["username"];
	
	if(isset($cssContents) == false)
	{
	
		$cssContents = file_get_contents("../../../css/pageCSS.css"); 
		
	}
	
?>
<!DOCTYPE html>
<html>

	<head>
		<title>KoanSystems Admin Area</title>
		<link href="../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="../../../css/css.css" />
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="blackout">
			<div id="Alert"></div>		
		</div>

		<div id="main" style="">
			<table style="border-bottom: solid 2px #dadada; ">
				<tr>	
					<td style="padding-left: 20px; font-size: 12px;">
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
		<h1 class="title">Edit Styling Using CSS</h1>
		<div id="content1" style="text-align: right;">

			<form name="cssContents" method="POST">
				<div id="textareaContainer">
					<table style="width: 100%; padding: 0px; margin: 0px;">
						<tbody>
							<tr style="width: 100%;">
								<td style="width: 100%; margin-top: -5px;">
									<input type="hidden" name="hiddenValue" value="1" />
									
										<textarea id="cssCode" class="wallPost2"  name="cssCode" style="width: 100%; padding-top: 5px;" onkeydown="insertTab(this, event);"><?php echo stripslashes($cssContents); ?></textarea>
									
								</td>
							</tr>	
						</tbody>
					</table>
				</div>
				</br>
				<div id="submit-button">
					<button type="button" id="ajax-save" name="submit" >Save Using AJAX</button>
				</div>
				</br>
								<p>Did you know that you can also use Ctrl + S or Cmd + S to save?</p>
			</form>

		</div>
			<div id="footer">

				</br></br>Copyright &copy; KoanSystems 			

			</div>	
		</div>
		<script src="/js/user-list.js" type="text/javascript"></script>
		<script src="/js/css-save.js" type="text/javascript"></script>
	</body>

</html>