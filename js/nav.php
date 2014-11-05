<?php header("Content-Type: text/javascript"); ?>
var $homeImageCounter = 0;
var switcher = 0;
var $mainSliderInterval;
window.onresize = function(){
	$("#portfolio-content-images").css({"width" : (((window.innerWidth / 100) * 90) + "px"), "margin-left" : "5%", "margin-right" : "5%"});
	$("#lightbox-image").css({ "top" : (((window.innerHeight - $("#lightbox-image").height())/2) + "px")});
	$("#lightbox-image").css({"margin-left" : (((window.innerWidth - $("#lightbox-image").width())/2) + "px"), "margin-right" : (((window.innerWidth - $("#lightbox-image").width())/2) + "px") });
	setPositions(location.hash);
};
function setPositions(element){
	var $footerSpacerHeight = ($("#footer").outerHeight() + $("#copyright").height());
	if($device != "desktop" && element == "portfolio")
		$("#main-content").css("top", ((((window.innerHeight / 100) * 80)-25) + "px"));
	else if($device != "desktop")
		$("#main-content").css("top", ((((window.innerHeight / 100) * 40)-25) + "px"));
	else 
		$("#main-content").css("top", ((((window.innerHeight / 100) * 100)-25) + "px"));
	$("#footer").css("top", (((((window.innerHeight / 100) * 100) + $("#main-content").outerHeight())-25) + "px"));
	$("#main-content").css("margin-bottom", ($footerSpacerHeight + "px"));
	$("#navigation").css("height", (((window.innerHeight / 100) * 100) + "px"));
	$("#main-content").css({"width" : "100%"});
}
function validateContactUs(formElement){
	if(formElement['clientName'].value == "")
		alert("Please add your name...")
	else if(formElement['clientEmail'].value == "")
		alert("Please add your email address...")
	else if(formElement['clientTelephone'].value == "")
		alert("Please add your telephone number...")
	else if(formElement['clientMessage'].value == "")
		alert("Please add your message...")
	else {
		$("#contactUsSubmit").removeClass("btn-primary");
		$("#contactUsSubmit").addClass("btn-warning");
		$("#contactUsSubmit").val("Please wait...");
		$("#contactUsSubmit").attr('disabled', 'disabled');
		if(formElement['clientCompany'].value != "" && formElement['clientWebsite'].value != "")
			$.post("/clientQuery/", {"clientName" : formElement['clientName'].value, "clientEmail" : formElement['clientEmail'].value, "clientTelephone" : formElement['clientTelephone'].value, "clientMessage" : formElement['clientMessage'].value, "clientCompany" : formElement['clientCompany'].value, "clientWebsite" : formElement['clientWebsite'].value}).done(function(data){$("#contactUsSubmit").removeClass("btn-warning"); $("#contactUsSubmit").addClass("btn-success"); $("#contactUsSubmit").val("Query Submitted");});
		else if(formElement['clientCompany'].value != "")
			$.post("/clientQuery/", {"clientName" : formElement['clientName'].value, "clientEmail" : formElement['clientEmail'].value, "clientTelephone" : formElement['clientTelephone'].value, "clientMessage" : formElement['clientMessage'].value, "clientCompany" : formElement['clientCompany'].value}).done(function(data){$("#contactUsSubmit").removeClass("btn-warning"); $("#contactUsSubmit").addClass("btn-success"); $("#contactUsSubmit").val("Query Submitted");});
		else if(formElement['clientWebsite'].value != "")
			$.post("/clientQuery/", {"clientName" : formElement['clientName'].value, "clientEmail" : formElement['clientEmail'].value, "clientTelephone" : formElement['clientTelephone'].value, "clientMessage" : formElement['clientMessage'].value, "clientWebsite" : formElement['clientWebsite'].value}).done(function(data){$("#contactUsSubmit").removeClass("btn-warning"); $("#contactUsSubmit").addClass("btn-success"); $("#contactUsSubmit").val("Query Submitted");});
		else
			$.post("/clientQuery/", {"clientName" : formElement['clientName'].value, "clientEmail" : formElement['clientEmail'].value, "clientTelephone" : formElement['clientTelephone'].value, "clientMessage" : formElement['clientMessage'].value}).done(function(data){(data == 1 ? (alert("Your query has been submitted")) : (alert("4: Your query was not submitted\n Error: " + data)));});
	}
	/*alert("Name: " + formElement['clientName'] + "\n" + "Email: " + formElement['clientEmail'] + "\n" + "Telephone: " + formElement['clientTelephone'] + "\n" + "Message: " + formElement['clientMessage'] + "\n");*/
	return false;
}
function changeContent(contentID) {
	location.hash = contentID;
	var mainContentObject = {
		"home" : "<span id=\'home-content\' ><p class=\'title\'>Welcome to Mancini Young Photography<\/p>\r\n\t\t\t<pre class=\'generic\'>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>Hi there, <\/p><\/br><\/span>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>\'MY Photography\' is a partnership of Jason Young &amp; Laura Mancini, both keen, passionate, creative photographers. We are both easy going, relaxed photographers who like to make your day special with the minimum fuss and lots of fun&#8230; and lots of photos. We pride ourselves on delivering exactly what YOU want from a shoot. <\/p><\/br><\/span>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>Having both been interested in photography since a young age we are both very lucky to be able to focus on something that we are so passionate about. We love to capture spontaneous moments and people in natural situations. We are committed to making your time with us special by capturing those extra magical moments that sometimes go unnoticed.  <\/p><\/br><\/span>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>It is a massive honour to be asked to capture a couple\'s wedding day and we aim to provide unobtrusive coverage of that extra special day. We can work in the background taking pictures of the full event, including all the things your guests get up to when you are busy getting married. We can also direct the photo-shoot if that\'s what you need or we can simply let you decide what you would like from the day. We can capture the more traditional wedding photos as well as providing a mix of alternative shots that make fun and unique memories. We offer package to suit every budget as well as pre-wedding or engagement shoots.<\/p><\/br><\/span>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>When it comes to photographing your family or friends we like to capture these special moments outdoors in a natural environment or at your favourite location. This allows all subjects to simply be themselves and feel entirely at ease as we snap away in the background.<\/p><\/br><\/span>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>We love all kinds of photography including landscapes, travel photography, bands and abandoned buildings and the wilderness.<\/p><\/br><\/span>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>If you are interested in booking us for a shoot or buying any of our images please feel free to contact us direct.<\/p><\/br><\/span>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>We look forward to hearing from you!<\/p><\/br><\/br><\/span>\r\n\t\t\t\t<span class=\'p-container\'><p class=\'generic\'>Jason &amp; Laura<\/p><\/span>\r\n\t\t\t<\/pre>\r\n\t\t<\/span>",
		"portfolio" : "<p class='title'>Gallery</p></br><span id='portfolio-content-images'><p class='generic'>Click on a folder up top to see images listed here...</p></span>",
		"contact" : "<span id='contact-content'><p class='title'>Contact Us</p><div id='contact-us-header'><img src='/img/logo.png' /></div><div id='contact-us-form'><form id=\"contactForm\" name='contactForm' method='POST' action='/clientQuery/' onsubmit=\"return false;\"><input class='form-control' type='text' placeholder='Name' class='contact-form' name=\"clientName\" required/><input class='form-control' type='text' placeholder='Email' name=\"clientEmail\" required /><input class='form-control' type='text' placeholder='Company Name' name=\"clientCompany\" /><input class='form-control' type='text' name=\"clientWebsite\" placeholder='Website' class='contact-form' /><input class='form-control' type='text' name=\"clientTelephone\" placeholder='Telephone No.' class='contact-form' required/><textarea class='form-control' placeholder='Message' name=\"clientMessage\" class='contact-form' style=\"resize: none;\" rows=\"15\" required></textarea></br><input type=\"submit\" class='btn btn-primary' id=\"contactUsSubmit\" onclick=\"validateContactUs(this.form);\" value=\"Submit Query\"/></form><noscript>Please enable JavaScript in your browser to use this form...</noscript></div></span>",
		"blog" : "<span id='blog-content'><!--<p class=\'title\' >Mancini Young Photography Blog</p>--><div class='previous-button'></div><div id='post-wrapper'><div id='postContainer'></div></div><div class='next-button' ></div></span>"
	}
	if(contentID == "blog")
		$("#blog").html(mainContentObject[contentID]);
	else
		$("#main-content").html(mainContentObject[contentID]);
	$(".parallax-cont").each(function(){ $(this).fadeOut(1000, function(){$(this);})});
	$("#" + contentID).stop().fadeIn(1000);
	if(contentID != "blog")
		$("#main-content").show();
	window.scrollTo(0, 0);
	setPositions();
	switch(contentID){
		case "home":
			$("html").css({"overflow-y" : "visible"});
			$("#main-content").css({"width" : "100%"});
			$(".generic").waypoint(function(){
				$(this).animate({
					"opacity" : 1
				}, 1500);
			}, {
				offset: '100%'
			});
			setPositions();
			$homeImageCounter = 0;
			
			var sliderImages = ["/img/home-slider-images/slider-0.jpg", "/img/home-slider-images/slider-1.jpg", "/img/home-slider-images/slider-3.jpg", "/img/home-slider-images/slider-4.jpg", "/img/home-slider-images/slider-5.jpg", "/img/home-slider-images/slider-6.jpg", "/img/home-slider-images/slider-7.jpg", "/img/home-slider-images/slider-8.jpg", "/img/home-slider-images/slider-9.jpg", "/img/home-slider-images/slider-10.jpg", "/img/home-slider-images/slider-11.jpg", "/img/home-slider-images/slider-12.jpg", "/img/home-slider-images/slider-13.jpg"];
			for(var i = 0; i < sliderImages.length; i++)
			{
				/*if($device != "desktop")
					$(".home-slider-image").each(function(){
						$(this).css({"background-size" : "100% "});
					});*/
				$("#home-slider").append("<span class=\"home-slider-image\" style=\"background-image: url('" + sliderImages[i] +"');width: " + window.innerWidth + "px;\" >&nbsp;</span>");
			}
		
			$mainSliderInterval = setInterval(function(){
				if($homeImageCounter < (sliderImages.length - 1))
				{
					$("#home-slider").velocity({
						"left" : ("-" + (window.innerWidth * ($homeImageCounter+1)))
	 				}, 2000, "easeInOutQuint", function() {
						$homeImageCounter++;
					});
	 			}
	 			else
	 			{
	 				$("#home-slider").animate({
						"opacity" : 0
	 				}, 2000, function() {
	 					$("#home-slider").css({"left" : 0, "opacity" : 1});
						$homeImageCounter = 0;
					});
	 			}
			}, 5000);
		break;
		case "portfolio":
			clearInterval($mainSliderInterval);
			$("html").css({"overflow-y" : "visible"});
			galleriaAdd();
			setPositions("portfolio");
			$("#main-content").css({"width" : "100%"});
			$(".gallery-dir-click").click(function() {
    			$('html, body').animate({
    	    		scrollTop: $("#main-content").offset().top
    			}, 1000);	
			});
			$(".generic").waypoint(function(){
				$(this).animate({
					"opacity" : 1
				}, 1000);
			}, {
				offset: '100%'
			});
			$("#home-slider").css({"left" : 0});
		break;
		case "contact":
			clearInterval($mainSliderInterval);
			$("html").css({"overflow-y" : "visible"});
			$("#main-content").css({"width" : "100%"});
			$(".generic").waypoint(function(){
				$(this).animate({
					"opacity" : 1
				}, 1000);
			}, {
				offset: '100%'
			});
			setPositions();
			$("#home-slider").css({"left" : 0});
		break;
		case "blog":
			clearInterval($mainSliderInterval);
			$("html").css({"overflow-y" : "hidden"});
			$("#main-content").hide();
			postsCounter = 0;
			$.getJSON("/client-ajax/last-ten-posts.php?post-id=" + postids[0], function(val){
				date = Date.parse(val.posted_at);
				date.addHours(5);
				$("#postContainer.footnote").remove();
				$("#postContainer").empty();
				$("#postContainer").append("<p class='title'>" + val.title + "</p><div class='post-icon'></div><pre>" + val.content + "</pre>");
				$("#post-wrapper").append("<p class='footnote'>Posted by " + val.firstname + " " + val.surname + " at <time datetime='"+date.toString('dd/MM/yyyy')+"'>" + date.toString('HH:mm')  + "</time> GMT+00 on the <time>"+date.toString('dd/MM/yyyy')+"</time></p>");
			});
			$(".previous-button").on('click', function(){
				if(postsCounter != 0)
					postsCounter--;
				else
					return false;
				$.getJSON("/client-ajax/last-ten-posts.php?post-id=" + postids[postsCounter] , function(val){
				}).done().success(function(val){
					date = Date.parse(val.posted_at);
					date.addHours(5);
					$("#postContainer.footnote").remove();
					$("#postContainer").empty();
					$("#postContainer").append("<p class='title'>" + val.title + "</p><div class='post-icon'></div><pre>" + val.content + "</pre>");
					$("#post-wrapper").append("<p class='footnote'>Posted by " + val.firstname + " " + val.surname + " at <time datetime='"+date.toString('dd/MM/yyyy')+"'>" + date.toString('HH:mm')  + "</time> GMT+00 on the <time>"+date.toString('dd/MM/yyyy')+"</time></p>");
				});
			});
			$(".next-button").on('click', function(){
				if(postsCounter < (postids.length-1))
					postsCounter++;
				else
					return false;
				$.getJSON("/client-ajax/last-ten-posts.php?post-id=" + postids[postsCounter] , function(val){
				}).done().success(function(val){
					date = Date.parse(val.posted_at);
					date.addHours(5);
					$("#postContainer.footnote").remove();
					$("#postContainer").empty();
					$("#postContainer").append("<p class='title'>" + val.title + "</p><div class='post-icon'></div><pre>" + val.content + "</pre>");
					$("#post-wrapper").append("<p class='footnote'>Posted by " + val.firstname + " " + val.surname + " at <time datetime='"+date.toString('dd/MM/yyyy')+"'>" + date.toString('HH:mm')  + "</time> GMT+00 on the <time>"+date.toString('dd/MM/yyyy')+"</time></p>");
				});
			});
			$("#main-content").css({"width" : "100%"});
			$(".generic").waypoint(function(){
				$(this).animate({
					"opacity" : 1
				}, 1000);
			}, {
				offset: '100%'
			});
			setPositions();
		break;
	}
}
function navClick(element) {
	if(switcher == 0)
	{		
		$element = $(element);
		$("li#navigation-link").css({background: "none"});
		$element.css({background: "#b3b3b3"});
		document.title = 'Mancini Young Photography - ' + $element.text().trim();
	}
}