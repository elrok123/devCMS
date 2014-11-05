function insertTab(o, e)
{
	var kC = e.keyCode ? e.keyCode : e.charCode ? e.charCode : e.which;
	if (kC == 9 && !e.shiftKey && !e.ctrlKey && !e.altKey)
	{
		var oS = o.scrollTop;
		if (o.setSelectionRange)
		{
			var sS = o.selectionStart;
			var sE = o.selectionEnd;
			o.value = o.value.substring(0, sS) + "\t" + o.value.substr(sE);
			o.setSelectionRange(sS + 1, sS + 1);
			o.focus();
		}
		else if (o.createTextRange)
		{
			document.selection.createRange().text = "\t";
			e.returnValue = false;
		}
		o.scrollTop = oS;
		if (e.preventDefault)
		{
			e.preventDefault();
		}
		return false;
	}
	return true;
}

$(document).ready(function(){
	$(window).keypress(function(event) {
	    if (!(event.which == 115 && (event.ctrlKey || event.metaKey)) && !(event.which == 19)) return true;
	    var str = $("#cssCode").val();
		$.ajax({
		  	url: "save/index.php",
		  	type: "POST",
		  	data: {"pageToEdit": $("#pageToEdit").val(), "mainBlockDisabled": $("#mainBlockDisabled").val(), "mainBlock-code": $("#mainBlock-code").val(), "footer-code": $("#footer-code").val(), "copyright-code": $("#copyright-code").val()},
		  	success: function(data){
		  		document.getElementById('blackout').style.display="block";
				document.getElementById('Alert').style.display="block";
				document.getElementById('Alert').style.marginTop=((window.innerHeight / 2)) + "px";
				document.getElementById('Alert').style.padding="20px 20px 5px 20px";
				setTimeout(function(){
					document.getElementById('blackout').style.display='none';			
					document.getElementById('Alert').style.display='none';
				}, 1250);
		  	},
		  	error: function(){
		    	alert('There was a problem saving...');
		  	}
		});
	    event.preventDefault();
	    return false;
	});
	$("#block-save").click(function(){
		$.ajax({
		  	url: "save/index.php",
		  	type: "POST",
		  	data: {"pageToEdit": $("#pageToEdit").val(), "mainBlockDisabled": $("#mainBlockDisabled").val(), "mainBlock-code": $("#mainBlock-code").val(), "footer-code": $("#footer-code").val(), "copyright-code": $("#copyright-code").val()},
		  	success: function(data){
		  		document.getElementById('blackout').style.display="block";
				document.getElementById('Alert').style.display="block";
				document.getElementById('Alert').style.marginTop=((window.innerHeight / 2)) + "px";
				document.getElementById('Alert').style.padding="20px 20px 5px 20px";
				setTimeout(function(){
					document.getElementById('blackout').style.display='none';			
					document.getElementById('Alert').style.display='none';
				}, 1250);
		  	},
		  	error: function(){
		    	alert('There was a problem saving...');
		  	}
		});
	});
});