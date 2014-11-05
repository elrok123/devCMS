
$(document).ready(function() {
	$('.profile_icon_content').hover(function(){
		$(".profile_description", this).stop().animate({top:'150px'},{queue:false,duration:160});
	}, 	function () {
		$(".profile_description", this).stop().animate({top:'215px'},{queue:false,duration:160});
	});
});

$(document).ready(function() {
	$('.profile_icon_content2').hover(function(){
		$(".profile_description", this).stop().animate({top:'150px'},{queue:false,duration:160});
	}, 	function () {
		$(".profile_description", this).stop().animate({top:'215px'},{queue:false,duration:160});
	});
});

$(document).ready(function(){
		$("a#show-panel").click(function(){
			$("#lightbox, #edit_profile").fadeIn(300);
		})
		$("a#close-panel").click(function(){
			$("#lightbox, #edit_profile").fadeOut(300);
		})
		$("a#open_wishlist").click(function(){
			$("#lightbox2, #wish_profile").fadeIn(300);
		})
		$("a#close-wishlist").click(function(){
			$("#lightbox2, #wish_profile").fadeOut(300);
		})
		$("a#add_funds").click(function(){
			$("#lightbox, #payment_method").fadeIn(300);
		})
		$("a#closepayment1").click(function(){
			$("#lightbox, #payment_method").fadeOut(300);
		})
		$("a#payment2").click(function(){
			$("#payment_method").fadeOut(300);
			$("#payment_method2").fadeIn(300);
		})
		$("a#closepayment2").click(function(){
			$("#lightbox, #payment_method2").fadeOut(300);
		})
		$("a#payment3").click(function(){
			$("#lightbox, #payment_method2").fadeOut(300);
		})
	})
