$(document).ready(function(){

	$("body").prepend("<div id='sidebar'><span class='overline'><img id='blog-posts-icon' src='/img/blog-post-icon.png' /><div id='blog-posts' >Blog Posts</div><img id='close-blog-posts-icon' src='/img/cross.png' /></span><div id='blog-post-links' ><br /><b>Loading...</b></div></div>");
	$("#blog-posts").hide();
	$("#blog-post-links").hide();
	$.getJSON("/client-ajax/last-ten-posts.php", function(data){
		$("#blog-post-links").empty();
		$.each( data, function( key, val ) {
			$("#blog-post-links").append("<div id='" + val.title + "' class='blog-post-element' ><a href='/Blog/"+ val.title.replace(/ /g, "-") +"' >"+ val.title + "</a><i>. <br />Date posted: " + val.posted_at.replace(" ", " <br />Time posted: ") + "</i>" + "</div>");
		});
	});
	var state = 0;
	$("#sidebar").click(function(){
		switch(state){
			case 0:
				$(this).animate({width:'+=300'}, 82);
				$(this).animate({height:'+=400'}, 82);
				$(".overline").animate({width:'+=300'}, 82);
				setTimeout(function(){$("#blog-posts").show();}, 300);
				setTimeout(function(){$("#close-blog-posts-icon").show();}, 300);
				setTimeout(function(){$("#blog-post-links").show();}, 500);

				state = 1;
				break;
			case 1:
				$(this).animate({height:'22px'}, 200);
				$(this).animate({width:'-=300'}, 200);
				$(".overline").animate({width:'-=300'}, 82);
				$("#blog-posts").hide();
				$("#blog-post-links").hide();
				$("#close-blog-posts-icon").hide();
				
				state = 0;
				break;
		}
	});
	$(".blog-post-element").click(function(){return false;})
});