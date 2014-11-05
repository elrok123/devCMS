<?php header("Content-Type: text/javascript"); ?>
var switcher = 0;
window.onresize = function(){
	$("#portfolio-content-images").css({"width" : (((window.innerWidth / 100) * 90) + "px"), "margin-left" : "5%", "margin-right" : "5%"});
	$("#lightbox-image").css({ "top" : (((window.innerHeight - $("#lightbox-image").height())/2) + "px")});
	$("#lightbox-image").css({"margin-left" : (((window.innerWidth - $("#lightbox-image").width())/2) + "px"), "margin-right" : (((window.innerWidth - $("#lightbox-image").width())/2) + "px") });
	setPositions();
	$("#main-content").css({"width" : "100%"});
};
function setPositions(element){
	var $footerSpacerHeight = ($("#footer").outerHeight() + $("#copyright").height());
	
	$("#main-content").css("top", ((((window.innerHeight / 100) * 100)-25) + "px"));
	$("#footer").css("top", (((((window.innerHeight / 100) * 100) + $("#main-content").outerHeight())-25) + "px"));
	$("#main-content").css("margin-bottom", ($footerSpacerHeight + "px"));
	$("#navigation").css("height", (((window.innerHeight / 100) * 100) + "px"));
	$("#main-content").css({"width" : "100%"});
}
function changeContent(contentID) {
	var mainContentObject = {
		"home" : "<span id='home-content'>" + $("#home-text").html() + "</span>",
		"portfolio" : "<p class='title'>Gallery</p></br><span id='portfolio-content-images'><p class='generic'>Click on a folder up top to see images listed here...</p></span>",
		"contact" : "<span id='contact-content'><p class='title'>Contact Us</p><div id='contact-us-header'><img src='/img/logo.png' /></div><div id='contact-us-form'><form name='contact-us' method='POST' action=''><input class='form-control' type='text' placeholder='Name' class='contact-form' /><input class='form-control' type='text' placeholder='Email' class='contact-form' /><input class='form-control' type='text' placeholder='Company Name' class='contact-form' /><input class='form-control' type='text' placeholder='Website' class='contact-form' /><input class='form-control' type='text' placeholder='Telephone No.' class='contact-form' /><input class='form-control' type='textarea' placeholder='Message' class='contact-form' /><input type='submit' class='form-control' /></form></div></span>",
		"blog" : "<span id='blog-content'><div class='previous-button'></div><div id='blog_container'><div id='postContainer'></div></div><div class='next-button'></div></span>"
	}

	$("#main-content").html(mainContentObject[contentID]);
	$(".parallax-cont").each(function(){ $(this).stop().fadeOut(1000, function(){$(this);})});
	$("#" + contentID).stop().fadeIn(1000);
	setPositions();
	switch(contentID){
		case "home":
			$("#main-content").css({"width" : "100%"});
		break;
		case "portfolio":
			galleriaAdd();
			setPositions("portfolio");
			$("#main-content").css({"width" : "100%"});
		break;
		case "contact":
			$("#main-content").css({"width" : "100%"});
		break;
		case "blog":
			$.getJSON("/client-ajax/last-ten-posts.php?post-id=" + postids[0], function(val){
				date = Date.parse(val.posted_at);
				date.addHours(5);
				$("#postContainer").empty();
				$("#postContainer").append("<p class='title'>" + val.title + "</p><div class='post-icon'></div><pre>" + val.content + "</pre><p class='footnote'>Posted by " + val.firstname + " " + val.surname + " at <time datetime='"+date.toString('dd/MM/yyyy')+"'>" + date.toString('HH:mm')  + "</time> GMT+00 on the <time>"+date.toString('dd/MM/yyyy')+"</time></p>");
			});
			$(".previous-button").on('click', function(){
				if(i != 0)
					i--;
				else
					return false;
				$.getJSON("/client-ajax/last-ten-posts.php?post-id=" + postids[i] , function(val){
				}).done().success(function(val){
					date = Date.parse(val.posted_at);
					date.addHours(5);
					$("#postContainer").empty();
					$("#postContainer").append("<p class='title'>" + val.title + "</p><div class='post-icon'></div><pre>" + val.content + "</pre><p class='footnote'>Posted by " + val.firstname + " " + val.surname + " at <time datetime='"+date.toString('dd/MM/yyyy')+"'>" + date.toString('HH:mm')  + "</time> GMT+00 on the <time>"+date.toString('dd/MM/yyyy')+"</time></p>");
				});
			});
			$(".next-button").on('click', function(){
				if(i < (postids.length-1))
					i++;
				else
					return false;
				$.getJSON("/client-ajax/last-ten-posts.php?post-id=" + postids[i] , function(val){
				}).done().success(function(val){
					date = Date.parse(val.posted_at);
					date.addHours(5);
					$("#postContainer").empty();
					$("#postContainer").append("<p class='title'>" + val.title + "</p><div class='post-icon'></div><pre>" + val.content + "</pre><p class='footnote'>Posted by " + val.firstname + " " + val.surname + " at <time datetime='"+date.toString('dd/MM/yyyy')+"'>" + date.toString('HH:mm')  + "</time> GMT+00 on the <time>"+date.toString('dd/MM/yyyy')+"</time></p>");
				});
				
			});
			$("#main-content").css({"width" : "100%"});
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