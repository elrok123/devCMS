<?php include('../../../../dbaccess/index.php');  include('../../../../dbaccess/modules.php');

	session_start();

	if(isset($_GET['displayOnly']) && $_GET['pageToEdit'])
	{
		
	}
	else
	{
		header("Location: ../");
	}
	
	$pageToEdit = $_GET['pageToEdit'];
	$displayOnly = $_GET['displayOnly'];

	$statement = $conn->prepare("SELECT * FROM pages WHERE ID = :pageToEdit ");
	$statement->bindParam(":pageToEdit", $pageToEdit);
	$statement->execute();
	
	$pageArray = $statement->fetch();
	
	$username = $_SESSION["username"];
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");	

	}
	
?>
<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../../../../css/css.css" />
		<title>KoanSystems Admin Area</title>
		<link href="../../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="js/jquery_ui.js" type="text/javascript"></script>
		

	</head>

	<body>
		<div id="blackout" style="height: 400%;">
			<div id="Alert"><p>saved successfully...</p></div>		
		</div>
		
		<div id="main">
			<table style="border-bottom: solid 2px #dadada; ">
				<tr>	
					<td style="padding-left: 20px;">
						<a href="../">
							<img src="../../../../img/logo.png" alt="Go back a page..." title="Go back a page..." style="width: 100px; height: auto; margin-left: auto; margin-right: auto;" />
						</a>
					</td>
					<td style="width: 80%;">
						
					</td>
					<td>
						<div id="user" onMouseOver="this.style.boxShadow='0px 1px 2px #404040'; this.style.borderLeft='2px solid #00CCFF';" onMouseOut="this.style.boxShadow='none'; this.style.borderLeft='2px solid #dadada';" style="padding: 10px; width: 150px; height: 25px; border-left: solid 2px #dadada; margin-right: 0px; margin-left: auto; margin-top: 0px; margin-bottom: auto;"><h9>Welcome, <?php echo $username; ?>.</h9></br><a href="../../../logout/" style="color: #0c0c0c;">Logout...</a></div>
					</td>
				<tr>
			</table>
		<h1 class="title"><?php echo $displayOnly; ?></h1>
		<div id="content1">
			<table id="content1" style="display: block; border: none; margin-left: auto; margin-right: auto;">	
				<tr style="height: auto;">
					<form name="myForm2" method="POST" id="cmsForm" action="../">
						<input type="hidden" name="pageToEdit" id="pageToEdit" value="<?php echo $pageToEdit; ?>"/>
						<input name="hidden" type="hidden" value="1" /> 
						<label>Main Block</label> | Disabled: 
						<select name="mainBlockDisabled" id="mainBlockDisabled" >
							<option value="1" <?php if($pageArray['FBLDisabled'] == 1){echo "selected";} ?>>True</option>
							<option value="0" <?php if($pageArray['FBLDisabled'] == 0){echo "selected";} ?>>False</option>
						</select>
						<textarea name="mainBlock-code" id="mainBlock-code" class="wallPost2" onkeydown="insertTab(this, event);" ><?php echo $pageArray['FBL']; ?></textarea>
				</tr>
			</table>
			<table style="width: 100%;">
				<tr style="width: 100%;">
					<td style="width: 100%; text-align: left;">

							<label>Footer</label>
							<textarea name="footer-code" id="footer-code" class="wallPost" onkeypress="resize()" onkeydown="insertTab(this, event);" ><?php echo $pageArray['Footer']; ?></textarea>

					</td>
				</tr>
			</table>
			<table style="width: 100%; height: 150px;">
				<tr style="width: 100%; height: 150px;">
					<td style="width: 100%; text-align: left; height: 150px;">
							<input type="hidden" name="standardSave" value="1" />
							<label>Copyright</label>
							<textarea name="copyright-code" id="copyright-code" onkeypress="resize()" class="wallPost" onkeydown="insertTab(this, event);" style="height: 75px;"><?php echo $pageArray['Copyright']; ?></textarea>
							
							<div id="submit-button">
								<button type="button" id="block-save" name="block-save" >Save Page Using Ajax...</button>
							</div>
							</br>
								<p>Did you know that you can also use Ctrl + S or Cmd + S to save?</p>
						</form>
					</td>
				</tr>
			</table>
						
		</div>
			<div id="footer">

				</br></br>Copyright &copy; KoanSystems		

			</div>	
		</div>
		<script type="text/javascript">
				$('#mainBlock-code').each(function() {
					$(this).height($(this).prop('scrollHeight'));
				});
				$('#footer-code').each(function() {
					$(this).height($(this).prop('scrollHeight'));
				});
				$('#copyright-code').each(function() {
					$(this).height($(this).prop('scrollHeight'));
				});
				$("#mainBlock-code").keypress(function(event) {
					if(event.which == 13)
						$('#mainBlock-code').each(function() {
							$(this).height($(this).prop('scrollHeight'));
						});
				});
				
				$("#footer-code").keypress(function(event) {
					if(event.which == 13)
						$('#footer-code').each(function() {
							$(this).height($(this).prop('scrollHeight'));
						});
				});
				$("#copyright-code").keypress(function(event) {
					if(event.which == 13)
						$('#copyright-code').each(function() {
							$(this).height($(this).prop('scrollHeight'));
						});
				});
		</script>
		<script src="/js/block-save.js" type="text/javascript" ></script>
		<script src="/js/user-list.js" type="text/javascript"></script>
	</body>

</html>