var state = 0;
function setSSLStateFunc(status){
	switch(status) {
		case "Off":
			$("#drag-slider").css("margin-right","25px");
			$("#sliderOn").width(0);
			$("#sliderOff").width(36);
			$("#sliderOff").text("Off");
			state = 0;
			break;
		case "On":
			$("#drag-slider").css("margin-left","25px");
			$("#sliderOff").width(0);
			$("#sliderOn").width(36);
			$("#sliderOn").text("On");
			state = 1;
			break;
	}
}
$(document).ready(function(){
	
	$("#ssl-button").click(function(){
		switch(state){
			case 0:
				$.get(("/administrator/panel/autoupdater/forceSSL.php?sslstate=1"), function(){
					$("#drag-slider").stop().animate({marginLeft:'25'}, 60);
					$("#sliderOn").stop().animate({width:'36'}, 60);
					$("#sliderOff").stop().animate({width:'0px'}, 60);
					setTimeout(function(){$("#sliderOff").empty()}, 10);
					setTimeout(function(){$("#sliderOn").text("On")}, 10);
					state = 1;
				});
			break;
			case 1:
				$.get(("/administrator/panel/autoupdater/forceSSL.php?sslstate=0"), function(){
					$("#drag-slider").stop().animate({marginLeft:'0'}, 60);
					$("#sliderOff").stop().animate({width:'36'}, 60);
					$("#sliderOn").stop().animate({width:'0px'}, 60);
					setTimeout(function(){setTimeout(function(){$("#sliderOn").empty()}, 10);
					$("#sliderOff").text("Off")}, 10);
					state = 0;
				});
			break;
		}
	});
});