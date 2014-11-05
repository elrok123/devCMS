var postids = new Array();
var i = 0;
var state = 0;
var imgSRC = "";
var date;

$(document).ready(function(){	
	$("#postContainer img").click(function(){
		if(state == 0)
		{
			imgSRC = $(this).attr("src");
			$("body").prepend("<div id='blackout'></div><div id='Alert'><img id='lightboximg' src='" + imgSRC + "' /></div>");
			$("#Alert").show();
			$("#blackout").show();
			state = 1;
		}
	});
	$("#blackout").click(function(){
		if(state == 1)
		{
			$("#Alert").hide();
			$("#lightboximg").hide();
			$("#blackout").hide();
			state = 0;
		}
	});
	$("#Alert").click(function(){
		if(state == 1)
		{
			$("#Alert").hide();
			$("#lightboximg").hide();
			$("#blackout").hide();
			state = 0;
		}
	});
	$("#lightboximg").click(function(){
		if(state == 1)
		{
			$("#Alert").hide();
			$("#lightboximg").hide();
			$("#blackout").hide();
			state = 0;
		}
	});
	$(document).keyup(function(e) {
		if (e.keyCode == 27 && state == 1) 
		{ 
			$("#Alert").hide();
			$("#lightboximg").hide();
			$("#blackout").hide();
			state = 0;
		}
	});
	$(document).mouseup(function(e) {
		if (e.which != 1) 
		{
			return false;
		}
		else if (state == 1) 
		{ 
			$("#Alert").hide();
			$("#lightboximg").hide();
			$("#blackout").hide();
			state = 0;
		}
	});


	$.getJSON("/client-ajax/last-ten-posts.php", function(data){
		$.each(data, function(k, val) {
			postids.push(val.id);
		});
	}).done().success(function(data){
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
	}).fail(function(){alert("There was an issue retrieving the blog posts, please refresh the page to try again.");});
});
