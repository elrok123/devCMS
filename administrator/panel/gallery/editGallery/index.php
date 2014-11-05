<?php session_start(); include('../../../../dbaccess/index.php');  include('../../../../dbaccess/modules.php');

	

	$username = $_SESSION['username'];
	
	unset($_SESSION['postEdit']);
	
	if(isset($_SESSION["username"]) == false)
	{

		header("Location: ../");

	}
	try
	{
		if($_POST['galleryPass'] == $_POST['galleryPassVerify'] && $_POST['galleryUsername'] != "" && $_POST['galleryFirstname'] != "" && $_POST['gallerySurname'] != "" && $_POST['galleryEmail'] != "" && $_POST['gallerySurname'] != "")
		{
			$statement = $conn->prepare("INSERT INTO users (username, firstname, surname, email, Password, type) VALUES (:username, :firstname, :surname, :email, :password, 1)");
			$statement->bindParam(":username", $_POST['galleryUsername']);
			$statement->bindParam(":firstname", $_POST['galleryFirstname']);
			$statement->bindParam(":surname", $_POST['gallerySurname']);
			$statement->bindParam(":email", $_POST['galleryEmail']);
			$statement->bindParam(":password", crypt($_POST['galleryPass'], "\$iLikePotatoes\$"));
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

		<link rel="stylesheet" type="text/css" href="/css/css.css" />
		<title>KoanSystems Gallery Area</title>
		<link href="../../../../css/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <!------------------------------Bootstrap Stuff---------------------------------------------------->

		<!-- Latest compiled and minified JavaScript -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

		<!------------------------------End Bootstrap Stuff------------------------------------------------>
		
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
			function galleriaAdd(){
				
			}
		</script>
		
		<?php 
			if(isset($error))
				echo "<script type='text/javascript'>alert('".(strpos($error, 'Duplicate') !== false ? "There is another entry with the same title, please change the title..." : "There was an error with your content..." )."');</script>";	
		?>
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/dark-hive/jquery-ui.css" id="theme">
		<script type="text/javascript">
			function getUrlVars() {
			    var vars = {};
			    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			        vars[key] = value;
			    });
			    return vars;
			}
			var getVars = getUrlVars();
			var $images = [];
			$.get( ("/administrator/panel/gallery/addGallery/get-gallery-images.php?galleryName=" + getVars['editGallerySubmit']), function( data ) {

                $jsonData = JSON.parse("[" + data + "]");
                if ($jsonData[0].length > 1) 
                {
                    for (var i = 0; i < $jsonData[0].length; i++) 
                    {
                        $("#files").append("<img id=\"" + i + "\" class=\"gallery-image\"  src=\"" + $jsonData[0][i].location + "\" />");
                        $images.push($jsonData[0][i].location);
                    };
                };
                var e = "";
			    $(".gallery-image").on("click", function(){
			    	
			        var e = $(this).attr("src");
			        $("body").append('<div class="black_overlay"><div data-id="' + (parseInt($(this).attr("id")) - 1) + '" class="galleria-previous"></div><img onclick="return false;" id="lightbox-image" src=\'' + e + "' /><div data-id=\"" + (parseInt($(this).attr("id")) + 1) + '" class="galleria-next"></div></div>');
			        if ($(this).width() > $(this).height()) $("#lightbox-image").css({
			            width: window.innerWidth / 100 * 80 + "px",
			            height: "auto"
			        });
			        else if ($(this).width() < $(this).height()) $("#lightbox-image").css({
			            width: "auto",
			            height: window.innerHeight / 100 * 80 + "px"
			        });
			        $("#lightbox-image").css({
			            "margin-left": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
			            "margin-right": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
			            top: (window.innerHeight - $("#lightbox-image").height()) / 2 + "px"
			        });
			        $("#lightbox-image").click(function (e) {
			            e.preventDefault()
			        });
			        $(".black_overlay").click(function () {
			            $(this).remove()
			        });
			        $("#lightbox-image").click(function (e) {
			            e.stopPropagation()
			        });
			        $(".galleria-previous").click(function (e) {
			            e.stopPropagation();
			            if (parseInt($(this).attr("data-id")) <= 0) return false;
			            var t = $("#" + $(this).attr("data-id") + ".gallery-image").attr("src");
			            $("#lightbox-image").attr("src", t);
			            if ($("#lightbox-image").width() > $("#lightbox-image").height()) $("#lightbox-image").css({
			                width: window.innerWidth / 100 * 80 + "px",
			                height: "auto"
			            });
			            else if ($("#lightbox-image").width() < $("#lightbox-image").height()) $("#lightbox-image").css({
			                width: "auto",
			                height: window.innerHeight / 100 * 80 + "px"
			            });
			            $("#lightbox-image").css({
			                "margin-left": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
			                "margin-right": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
			                top: (window.innerHeight - $("#lightbox-image").height()) / 2 + "px"
			            });
			            $(this).attr("data-id", parseInt($(this).attr("data-id")) - 1);
			            $(".galleria-next").attr("data-id", parseInt($(".galleria-next").attr("data-id")) - 1 + "")
			        });
			        $(".galleria-next").click(function (e) {
			        	e.stopPropagation();
			            if (parseInt($(this).attr("data-id")) > ($jsonData[0].length-1)) return false;
			            var t = $("#" + $(this).attr("data-id") + ".gallery-image").attr("src");
			            $("#lightbox-image").attr("src", t);
			            if ($("#lightbox-image").width() > $("#lightbox-image").height()) $("#lightbox-image").css({
			                width: window.innerWidth / 100 * 80 + "px",
			                height: "auto"
			            });
			            else if ($("#lightbox-image").width() < $("#lightbox-image").height()) $("#lightbox-image").css({
			                width: "auto",
			                height: window.innerHeight / 100 * 80 + "px"
			            });
			            $("#lightbox-image").css({
			                "margin-left": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
			                "margin-right": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
			                top: (window.innerHeight - $("#lightbox-image").height()) / 2 + "px"
			            });
			            $(this).attr("data-id", parseInt($(this).attr("data-id")) + 1);
			            $(".galleria-previous").attr("data-id", parseInt($(".galleria-previous").attr("data-id")) + 1 + "")
			        });
			    });
                
            });
		</script>
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
			<h1 class="title">View Gallery:</h1>
			<div id="files" class="portfolio-content-images" >
        	</div>
			<div id="footer" style="clear: both; margin-bottom: 0px;">
				</br></br>Copyright &copy; KoanSystems
			</div>	
		</div>
		<script src="/js/user-list.js" type="text/javascript"></script>
	</body>

</html>