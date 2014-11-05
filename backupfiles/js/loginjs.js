$(document).ready(function(){
		$("a#show-panel").click(function(){
			$("#lightbox, #lightbox-panel").fadeIn(300);
		})
		$("a#close-panel").click(function(){
			$("#lightbox, #lightbox-panel").fadeOut(300);
		})
		$("a#open_signin").click(function(){
			$("#lightbox, #lightbox-panel").fadeOut(300);
			$("#lightbox2, #lightbox-panel2").fadeIn(300);
		})
		$("a#close-panel2").click(function(){
			$("#lightbox2, #lightbox-panel2").fadeOut(300);
		})
	})