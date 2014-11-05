$(document).ready(function(){

	$("body").prepend("<div id='sidebar'><span class='overline'><div id='online_users' >Online Users</div><img id='online_users_img' src='/img/loading_anim.gif' /></span><div id='user-list' ><br /><b>Loading...</b></div></div>");
	$("#online_users").hide();
	$("#user-list").hide();
	$.getJSON( "/administrator/panel/autoupdater/users.php", function( data ) {
		$("#user-list").empty();
		$.each( data, function( key, val ) {
			$("#user-list").append("<br /><div id='" + val.Username + "' class='user-list-element' >" + (val.online == 1 ? "<img class='user-status' src='/img/online.png' />" : "<img class='user-status' src='/img/offline.png' />") + val.firstname + " " + val.surname  + "</div><br /><br /><div id='" + val.Username + "' style='float: left;'>Last Visited: " + "<a href='" +val.last_visited + "' >" + val.last_visited + "</a>" + "</div><br />" + "<div id='" + val.Username + "' style='float: left;'>Time Visited: " + val.last_visited_datetime + "</div><br /><br />");
		});
	});
	$.post("/administrator/panel/autoupdater/status.php", function(data, status){
  		$("#online_users_img").attr("src", "/img/icon-user-online.png");
	});
	var state = 0;
	$("#sidebar").click(function(){
		switch(state){
			case 0:
				$(this).animate({width:'+=300'}, 82);
				$(this).animate({height:'+=200'}, 82);
				$(".overline").animate({width:'+=300'}, 82);
				setTimeout(function(){$("#online_users").show();}, 300);
				setTimeout(function(){$("#user-list").show();}, 500);
				state = 1;
				break;
			case 1:
				$(this).animate({height:'22px'}, 200);
				$(this).animate({width:'-=300'}, 200);
				$(".overline").animate({width:'-=300'}, 82);
				$("#online_users").hide();
				$("#user-list").hide();
				state = 0;
				break;
		}
	});
	var intervalID = setInterval(function(){
		if(state == 1)
		{
			$.getJSON( "/administrator/panel/autoupdater/users.php", function( data ) {
				var height = (typeof height === 'undefined') ? 22 : height;
				var heightSet = (typeof heightSet === 'undefined') ? false : heightSet;

				$("#user-list").empty();

				$.each( data, function( key, val ) {
					$("#user-list").append("<br /><div id='" + val.Username + "' class='user-list-element' >" + (val.online == 1 ? "<img class='user-status' src='/img/online.png' />" : "<img class='user-status' src='/img/offline.png' />") + val.firstname + " " + val.surname  + "</div><br /><br /><div id='" + val.Username + "' style='float: left;'>Last Visited: " + "<div class='last-visited-link'><a href='" +val.last_visited + "' >" + val.last_visited + "</a></div>" + "</div><br /><br />" + "<div id='" + val.Username + "' style='float: left;'>Time Visited: " + val.last_visited_datetime + "</div><br /><br />");
					if(heightSet != true && height <= 380)
						height += 94;
				});
				var heightSet = true;
				if(state == 1)
					$("#sidebar").height(height);
			});
		}
		$.get(("/administrator/panel/autoupdater/status.php?lastvisited="+window.location), function(data, status){
	  		
		});
	}, 500);

	if(typeof $noBack === 'undefined')
		$("table").eq(0).append("</br><a style=\"font-size: 1.2em;\" href=\"../\"><--Go Back...</a></br></br>");

	
		
});
