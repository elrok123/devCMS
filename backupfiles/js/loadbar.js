	var loadDown = 0;
	
	function incrementLoad(stopPoint)
	{
		var i = 0;
		
		var intervalID = setInterval(function()
		{
			document.getElementById('loadingBar').style.borderLeft = i + "px solid #dfdfdf";
			document.getElementById('loadingBar2').style.borderLeft = i + "px solid #cfcfcf";
			document.getElementById('loadingBar3').style.borderLeft = i + "px solid #c5c5c5";
			document.getElementById('loadingBar4').style.borderLeft = i + "px solid #bababa";
			if(i >= stopPoint)
			{
				clearInterval(intervalID);
			}
			else
			{
				i++;
			}
		}, 1)

	}