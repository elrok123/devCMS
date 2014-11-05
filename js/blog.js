var state = 0;
var imgSRC = "";

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
});