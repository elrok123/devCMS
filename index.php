<?php ob_start(); include('dbaccess/index.php'); include('dbaccess/modules.php'); include('dbaccess/bbcode-parser.php');

	$statement = $conn->prepare("SELECT * FROM settings LIMIT 1");
	$statement->execute();
	$sslstate = $statement->fetch();

	if($sslstate['sslstate'] == 1){
		if(isset($_SERVER["HTTPS"]) == false)
		{
		    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		    exit();
		}
	}
	if($sslstate['sslstate'] == 0){
		if(isset($_SERVER["HTTPS"]))
		{
		    header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		    exit();
		}
	}
	
	
	$statement = $conn->prepare("SELECT pageName FROM pages WHERE landingPage = 1");
	$statement->execute();
	$pageNameRow = $statement->fetch();
	$defaultPage = $pageNameRow['pageName'];

	if(isset($_GET['pageName']))
	{
		$pageName = $_GET['pageName'];
	}
	else
	{
		$pageName = $defaultPage;
	}

	$statement = $conn->prepare("SELECT * FROM pages WHERE pageName LIKE :nameOfPage");
	$statement->bindParam(":nameOfPage", $pageName);
	$statement->execute();
	$pageArray = $statement->fetch();
	
	if($pageArray['Visible'] == 0)
	{
		header("Location: /");
	}
	
	if($pageArray['pageName'] != $pageName)
	{
		header("Location: /");
	}
	echo $doctype;
	if($pageName == "Blog" && isset($_GET['blogpage']))
	{
		$statement = $conn->prepare("SELECT tags FROM blog WHERE title = :pageTitle LIMIT 1 ");
		$str_aft_repl = str_replace("-", " ", $_GET['blogpage']);
		$statement->bindParam(":pageTitle", $str_aft_repl);
		$statement->execute();
		$tags = $statement->fetch();
	}
?>
<!DOCTYPE html>	
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="index, follow" />
		<link rel="icon" href="/img/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="/css/fonts.css" />
		<link rel="stylesheet" type="text/css" href="/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="/css/default.css" />

		<title><?php echo "KoanSystems - " . str_replace("-", " ", $pageName) . ($pageName ==  "Blog" && isset($_SERVER["REQUEST_URI"]) ? " - " . str_replace("-", " ", substr($_SERVER["REQUEST_URI"], 6)) : ""); ?></title>
		<link rel="stylesheet" type="text/css" href="/css/pageCSS.css" />
		<script src="/css/image-slider/2/js-image-slider.js" type="text/javascript"></script>
		<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="/js/jquery_ui.js" type="text/javascript"></script>
		<script src="/js/blog.js" type="text/javascript"></script>
		<script src="/js/blog-list.js" type="text/javascript"></script>

		<meta property="og:type" content="article" />
		<meta property="og:title" content="<?php echo "KoanSystems - " . str_replace("-", " ", $pageName) . ($pageName ==  "Blog" && isset($_SERVER["REQUEST_URI"]) ? " - " . str_replace("-", " ", substr($_SERVER["REQUEST_URI"], 6)) : ""); ?>" />
		<meta property="og:url" content="https://www.koansystems.co.uk" />
		<meta name="description" content="Koansystems is an up and coming software company with a high focus on agile software development" />
		
		<meta property="article:published_time" content="2012-08-01" />
		<meta property="article:modified_time" content="2013-01-15" />
		<meta property="og:site_name" content="KoanSystems" />
		<?php 
			if(isset($tags['tags']) && $tags['tags'] != "")
				echo "<meta name=\"keywords\" content=\"".$tags['tags']."\" />";
			else
				echo "<meta name=\"keywords\" content=\"Koansystems, software, php software, c language software, java software, c programming software, as 400 software, c software download, development software, agile software development, software development kit, android development, mobile application development, developer android, android developer\" />";
		?>
		<meta name="twitter:card" content="summary" />
		<meta name="generator" content="KoanSystems CMS" />
		<meta name="google-site-verification" content="nD2P7WfEejxPERwjc3F79pCNlX7T1o5OcLb-KyjXRCo" />
	</head>
	
	<body>
		
		<div id="container">
			<div id="Navigation">
				<div id="nav">
    				<div class="wrapper">
						
						<ul class="navigation" styles="cursor: pointer;margin-left: 10px;">
							<?php
								
								if(isset($_GET['pageName']) == false || $_GET['pageName'] != "Blog")
								{
									$statement = $conn->prepare("SELECT id, title FROM blog ORDER BY id DESC LIMIT 1");
									$statement->execute();
									$blogNavLink = $statement->fetch();
									$blogNavLink = "Blog/".(str_replace(" ", "-", $blogNavLink['title']));
								}

								$statement = $conn->prepare("SELECT * FROM pages WHERE topMenuVisible = 1 ORDER BY MenuPosition DESC ");
								$statement->execute();

								while($pageNames = $statement->fetch())
								{
									if($pageNames['Visible'] == 1)
									{
										$validURLString = str_replace(" ", "%20", $pageNames['pageName']);
										$validTitleString = str_replace("-", " ", $pageNames['pageName']);
										$selectedVar = "";
										if($pageName == $pageNames['pageName'])
										{
											$selectedVar = " class='selected' ";
										}
										if($pageNames['landingPage'] == 1 && $pageNames['topMenuVisible'] == 1)
										{
											echo "<li style='cursor: pointer;' " . $selectedVar . " onClick=\"window.location='" . ($sslstate['sslstate'] == 0 ? "http://" : "https://") . strtolower($_SERVER['SERVER_NAME']) . "'\">
												<a href='" . ($sslstate['sslstate'] == 0 ? "http://" : "https://") . strtolower($_SERVER['SERVER_NAME']) . "' >" . $validTitleString . "</a>
											</li>";
										}
										else if($pageNames['clickable'] == 1 && $pageNames['topMenuVisible'] == 1)
										{
											echo "<li style='cursor: pointer;' " . $selectedVar . " onClick=\"window.location='/".$validURLString."'\">
												<a href='/".(isset($blogNavLink) ? $blogNavLink : $validURLString)."'>".$validTitleString."</a>
											</li>";
										}
										else if($pageNames['topMenuVisible'] == 1)
										{
											echo "<li onClick='return false;' style='cursor: pointer;'>
												<a href='' onClick='return false;'>".$validTitleString."</a>
											</li>";
										}
										
									}
								}
							
							?>
						</ul>
						<a href="<?php echo ($sslstate['sslstate'] == 0 ? "http://" : "https://") . $_SERVER['SERVER_NAME']; ?>">
							<img src="/img/logo.png" style="margin-top: -20px; margin-left: -38px;" title="KoanSystems" alt="KoanSystems" id="icon"/>
						</a>
					</div>
				</div></div>
			</div>
			<div id="main" style='background: #dadada url("/img/background_shapes.png") repeat-y scroll center top, url("/img/blue_bg.png") repeat-x scroll left top transparent;'><div class="shapes">
				<div class="wrapper">
				
					<?php 
						if($pageName == "Blog")
						{
							$statement = $conn->prepare("SELECT id, title FROM blog ORDER BY id DESC");
							if(isset($_GET['blogpage']))
							{
								$statement2 = $conn->prepare("SELECT id, posted_by, DATE_FORMAT(posted_at, '%H:%i') AS time_posted, DATE_FORMAT(posted_at, '%d-%m-%Y') AS date_posted, title, content FROM blog WHERE title = :pageTitle ORDER BY id DESC LIMIT 1");
								$statement2->bindParam(":pageTitle", $str_aft_repl);
							}
							else
							{
								$statement2 = $conn->prepare("SELECT id, posted_by, DATE_FORMAT(posted_at, '%H:%i') AS time_posted, posted_at, DATE_FORMAT(posted_at, '%d-%m-%Y') AS date_posted, title, content FROM blog ORDER BY id DESC LIMIT 1");
								$statement2->execute();
								$pagePost = $statement2->fetchAll();

								header("Location: /Blog/".str_replace(" ", "-", $pagePost[0]['title']));
							}
							$statement->execute();
							$statement2->execute();
							$postCount = $statement->rowCount();
							$i = 0;
							$ii = 0;

							$pagePost = $statement2->fetchAll();
							$blocks = $statement->fetchAll();

							echo "</br><div id='blog_container'>";
							foreach($pagePost as $block)
							{
								//This if statement contains the logic and display of the blog posts.
								$statement = $conn->prepare("SELECT * FROM users WHERE Username = :user");
								$statement->bindParam(":user", $block['posted_by']);
								$userStore = $statement->execute();
								$userStore = $statement->fetch();

								$postTitle = $block['title'];
								
								echo "<div id='postContainer'>";
								echo "	<p class='title'>";
								echo "		" . $block['title'];
								echo "	</p>";
								echo "	<p class='indent'>";
								echo "		" . bbcodeParser($block['content']);
								echo "	</p></br>";
								echo "	<p class='footnote'>";
								$date = new DateTime($block['date_posted'], new DateTimeZone('GMT'));
								echo "		Posted by " . $userStore['firstname'] . " " . $userStore['surname'] . " at <time datetime='".$date->format('Y-m-d')."'>" . $block['time_posted'] . "</time> GMT+00 on the <time>" . $block['date_posted'] . "</time>";
								echo "	</p>";
								echo "</div>";
								$ii++;

			                	//This if statement is used for the creation of the pagination features.
			                	if($ii == 1 || end($blocks) == $block)
			                    {
			                        $ii = 1;
			                        echo "<div id='paginator_container'>";
			                        if(isset($_GET['blogpage']) && $_GET['blogpage'] > 1)
				                	{
				                		echo "<a href='/".($pageName != $defaultPage ? $pageName : "" )."/".(isset($_GET['blogpage']) ? $_GET['blogpage'] - 1 : 1)."'>  <u><- Previous</u>  </a>";
				                	}
				                	$iii = 0;
				                	foreach($blocks as $block2)
			                        {
			                        	if($block2['title'] == $postTitle && isset($blocks[($iii-1)]['title']))
			                        		echo "<a href='/Blog/".str_replace(" ", "-", $blocks[($iii-1)]['title'])."'>  <u><- Previous</u>  </a>";
			                        	$iii++;
			                        }
			                        /*echo "<a>Pages:  </a>";
			                        
			                        while($ii <= ceil($postCount / 1))
			                        {
			                            echo "<a href='/".($pageName != $defaultPage ? $pageName : "" )."/".$ii."' style='text-decoration: none;'> <u>" . $ii . "</u> </a>";
			                            $ii++;
			                        }
			                        //if(isset($_GET['blogpage']) && $_GET['blogpage'] < (ceil(($postCount / 4)))) { echo "<a href='/".($pageName != $defaultPage ? $pageName : "" )."/".(isset($_GET['blogpage']) ? $_GET['blogpage'] + 1 : 2)."'>  <u>Next -></u></a>"; } else if(isset($_GET['blogpage']) == false && $postCount > 4) {echo "<a href='/".($pageName != $defaultPage ? $pageName : "" )."/2'>  <u>Next</u></a>";}
			                        */

			                        $iii = 0;
			                        foreach($blocks as $block2)
			                        {
			                        	if($block2['title'] == $postTitle && isset($blocks[($iii+1)]['title']))
			                        		echo "<a href='/Blog/".str_replace(" ", "-", $blocks[($iii+1)]['title'])."'>  <u>Next -></u></a>";
			                        	$iii++;
			                        }

			                        echo "</div>";
			                        break;
			                    }
			                	$i++;
							}
							echo "</div>";
						}
						else
						{
							if($pageArray['FBLDisabled'] == 0 || $pageArray['FBRDisabled'] == 0)
							{
								echo "<div id='firstBlockContainer'>
									<table>
										<tbody>
											<tr>";
								if($pageArray['FBLDisabled'] == 0)
								{
									echo "<td><div id='FBL'>
										";
									echo $pageArray['FBL'];
									echo "</div>
								</td>";
								}
								if($pageArray['FBRDisabled'] == 0)
								{
									echo "<td><div id='FBR'>
										";
									echo $pageArray['FBR'];
									echo "</div>
								</td>";
								}
								echo "</tr>
										</tbody>
									</table>
								</div>";
							}

						}
					?>
				</div>
			</div>
		</div>
		</div>
		<div id="footer" >
				<div class="wrapper">
					<div class="left leftFooter">

						<?php
								$statement = $conn->prepare("SELECT * FROM pages");
								$statement->execute();

								while($pageNames = $statement->fetch())
								{
									if($pageNames['Visible'] == 1 && $pageNames['bottomMenuVisible'] == 1)
									{
										$validTitleString = str_replace("-", " ", $pageNames['pageName']);
										$selectedVar = "";
										if($pageName == $pageNames['pageName'])
										{
											$selectedVar = " class='selected'";
										}
										if($pageNames['landingPage'] == 1 && $pageNames['type'] != 1)
										{
											echo "<ul" . $selectedVar . " style='color: #fafafa'>
													<a href='https://" . $_SERVER['SERVER_NAME'] . "' style='color: #fafafa;'>" . $validTitleString . "</a>";
										}
										else if($pageNames['isParent'] == 1 && $pageNames['bottomMenuVisible'] == 1 && $pageNames['type'] == 1 && $pageNames['clickable'] == 1)
										{
											echo "<ul>
													<a href='".$pageNames['link']."' style='color: #fafafa;'>".$validTitleString."</a>";
										}
										else if($pageNames['isParent'] == 1 && $pageNames['bottomMenuVisible'] == 1 && $pageNames['type'] == 1 && $pageNames['clickable'] == 0)
										{
											echo "<ul>
													<a href='' onClick='return false;' style='color: #fafafa;'>".$validTitleString."</a>";
											
										}
										else if($pageNames['clickable'] == 1 && $pageNames['isParent'] == 1 && $pageNames['bottomMenuVisible'] == 1)
										{
											echo "<ul" . $selectedVar . ">
													<a href='/".$pageNames['pageName']."' style='color: #fafafa;'>".$validTitleString."</a>";
										}
										else if($pageNames['isParent'] == 1 && $pageNames['bottomMenuVisible'] == 1)
										{
											echo "<ul>
													<a href='' onClick='return false;' style='color: #fafafa;'>".$validTitleString."</a>";
										}

										$statement2 = $conn->prepare("SELECT * FROM pages WHERE Parent = :pageId ORDER BY MenuPosition ASC");
										$statement2->bindParam(":pageId", $pageNames['ID']);
										$statement2->execute();
										
										if($pageNames['Visible'] == 1 && $pageNames['isParent'] == 1)
										{
											echo "<li>
											";
											
											while($menuItems = $statement2->fetch())
											{
												//if()
												$validTitleString = str_replace("-", " ", $menuItems['pageName']);
												if($menuItems['pageName'] != "" && $menuItems['Visible'] == 1 && $menuItems['bottomMenuVisible'] == 1 && $menuItems['type'] == 0)
												{
													echo "	<li><a href='/".$menuItems['pageName'] . "' style='font-weight:normal; color: #fff;'>".$validTitleString."</a></li>";
												}
												else if($menuItems['pageName'] != "" && $menuItems['Visible'] == 1 && $menuItems['bottomMenuVisible'] == 1 && $menuItems['type'] == 1)
												{
													if(strstr($menuItems['link'], "https") || $menuItems['linkLocation'] == 0)
													{
														$httpAdd = "";
													}
													else
													{
														$httpAdd = "https://";
													}
													echo "	<li><a href='".$httpAdd.$menuItems['link'] . "' style='font-weight:normal; color: #fff;'>".$validTitleString ."</a></li>";
												}
											}
											echo "</ul>";	
										}
										
										
									}
								}
							
							?>
				</div>
				<div id="userFooterContents" >
					<?php
										
						echo $pageArray['Footer'];
					?>
				</div>
			</div>
			</br>
			<div id="companyLogos">
			</div>
		</div>

		<div id="copyright">
			<?php
				echo $pageArray['Copyright'];		
			?>
		</div>
			<?php
			 	ob_flush();
			?>
		<script type="text/javascript">
			$.get("/webim/b.php?i=webim&lang=en",function(data,status){
	      		$("#webimg").attr("src", data);
	    	});

			$(document).ready(function(){
				var intervalID = setInterval(function(){
			    	$.get("/webim/b.php?i=webim&lang=en",function(data,status){
			      		$("#webimg").attr("src", data);
			    	});
				}, 1000);
				$("#webimg").click(function(){
					clearInterval(intervalID);
				});
			});
			if(!window_handle.closed)
			{
				$("#webimg").click(function(){
					clearInterval(intervalID);
				});
			}
		</script>
	</body>
</html>