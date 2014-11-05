var switcher = 0;

/*$(window).load(function(){
		switcher = 1;
		
		$( "#canvas-three" ).stop().velocity({
			bottom: (window.innerHeight) + "px"
		}, 600, function() {
			$( "#canvas-one" ).stop().velocity({
				right: (window.innerWidth) + "px"
			}, 600, function() {
				return false;
			});
			$( "#canvas-two" ).stop().velocity({
				left: (window.innerWidth) + "px"
			}, 600, function() {
				switcher = 0;
				return false;
			});
		});
});

function autoScroll(element) {
	var $element = $("#" + element);
	if(switcher == 0)
	{
		$(function(){
			switcher = 1;
			$( "#canvas-one" ).stop().velocity({
				right: 0
			}, { duration: 600, queue: false });
			
			$( "#canvas-two" ).stop().velocity({
				left: 0
			}, 
			{
				queue: false,
				duration: 600,
				complete: function() {
					$( "#canvas-three" ).stop().velocity({
						bottom: 0
					}, 600, function() {
						$('.parallax-cont').each(function(){
		        			var $this = $(this);
		        			$this.hide();
		        		});
		        		$element.show();
	        			
						$( "#canvas-three" ).stop().velocity({
							bottom: (window.innerHeight) + "px"
						}, 600, function() {
							$( "#canvas-one" ).stop().velocity({
								right: (window.innerWidth) + "px"
							}, 600, function() {
								return false;
							});
							$( "#canvas-two" ).stop().velocity({
								left: (window.innerWidth) + "px"
							}, 600, function() {
								switcher = 0;
								return false;
							});
						});
					});
	        		
		    	}
		    });
		});

	}
	else
	{
		return false;
	}
}*/