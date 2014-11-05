/**
 * jQuery Lined Textarea Plugin 
 *   http://alan.blog-city.com/jquerylinedtextarea.htm
 *
 * Copyright (c) 2010 Alan Williamson
 * 
 * Version: 
 *    $Id: jquery-linedtextarea.js 464 2010-01-08 10:36:33Z alan $
 *
 * Released under the MIT License:
 *    http://www.opensource.org/licenses/mit-license.php
 * 
 * Usage:
 *   Displays a line number count column to the left of the textarea
 *   
 *   Class up your textarea with a given class, or target it directly
 *   with JQuery Selectors
 *   
 *   $(".lined").linedtextarea({
 *   	selectedLine: 10,
 *    selectedClass: 'lineselect'
 *   });
 *
 * History:
 *   - 2010.01.08: Fixed a Google Chrome layout problem
 *   - 2010.01.07: Refactored code for speed/readability; Fixed horizontal sizing
 *   - 2010.01.06: Initial Release
 *
 */
(function($) {

	$.fn.linedtextarea = function(options) {
		
		// Get the Options
		var opts = $.extend({}, $.fn.linedtextarea.defaults, options);
		
		
		/*
		 * Helper function to make sure the line numbers are always
		 * kept up to the current system
		 */
		var fillOutLines = function(codeLines, h, lineNo){
			while ( (codeLines.height() - h ) <= 0 ){
				if ( lineNo == opts.selectedLine )
					codeLines.append("<div class='lineno lineselect'>" + lineNo + "</div>");
				else
					codeLines.append("<div class='lineno'>" + lineNo + "</div>");
				
				lineNo++;
			}
			return lineNo;
		};
		
		
		/*
		 * Iterate through each of the elements are to be applied to
		 */
		return this.each(function() {
			var lineNo = 1;
			var textarea = $(this);
			
			/* Turn off the wrapping of as we don't want to screw up the line numbers */
			textarea.attr("wrap", "off");
			textarea.css({resize:'none'});
			var originalTextAreaWidth	= textarea.outerWidth();

			/* Wrap the text area in the elements we need */
			textarea.wrap("<div class='linedtextarea'></div>");
			var linedTextAreaDiv	= textarea.parent().wrap("<div class='linedwrap' style='width:" + originalTextAreaWidth + "px'></div>");
			var linedWrapDiv 			= linedTextAreaDiv.parent();
			
			linedWrapDiv.prepend("<div class='lines' style='width:50px'></div>");
			
			var linesDiv	= linedWrapDiv.find(".lines");
			linesDiv.height( textarea.height() + 6 );
			
			
			/* Draw the number bar; filling it out where necessary */
			linesDiv.append( "<div class='codelines'></div>" );
			var codeLinesDiv	= linesDiv.find(".codelines");
			lineNo = fillOutLines( codeLinesDiv, linesDiv.height(), 1 );

			/* Move the textarea to the selected line */ 
			if ( opts.selectedLine != -1 && !isNaN(opts.selectedLine) ){
				var fontSize = parseInt( textarea.height() / (lineNo-2) );
				var position = parseInt( fontSize * opts.selectedLine ) - (textarea.height()/2);
				textarea[0].scrollTop = position;
			}

			
			/* Set the width */
			var sidebarWidth					= linesDiv.outerWidth();
			var paddingHorizontal 		= parseInt( linedWrapDiv.css("border-left-width") ) + parseInt( linedWrapDiv.css("border-right-width") ) + parseInt( linedWrapDiv.css("padding-left") ) + parseInt( linedWrapDiv.css("padding-right") );
			var linedWrapDivNewWidth 	= originalTextAreaWidth - paddingHorizontal;
			var textareaNewWidth			= originalTextAreaWidth - sidebarWidth - paddingHorizontal - 20;

			textarea.width( textareaNewWidth );
			linedWrapDiv.width( linedWrapDivNewWidth );
			

			
			/* React to the scroll event */
			textarea.scroll( function(tn){
				var domTextArea		= $(this)[0];
				var scrollTop 		= domTextArea.scrollTop;
				var clientHeight 	= domTextArea.clientHeight;
				codeLinesDiv.css( {'margin-top': (-1*scrollTop) + "px"} );
				lineNo = fillOutLines( codeLinesDiv, scrollTop + clientHeight, lineNo );
			});


			/* Should the textarea get resized outside of our control */
			textarea.resize( function(tn){
				var domTextArea	= $(this)[0];
				linesDiv.height( domTextArea.clientHeight + 6 );
			});

		});
	};

  // default options
  $.fn.linedtextarea.defaults = {
  	selectedLine: -1,
  	selectedClass: 'lineselect'
  };
})(jQuery);
/* End of line numbering plugin */


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
		  	url: "/administrator/panel/styling/putCSSFile.php",
		  	type: "POST",
		  	data: {cssCode: str},
		  	success: function(data){
		  		if(data == "1")
		  		{
		  			
		  			document.getElementById('blackout').style.display="block";
		  			$("#Alert").html("<p>saved successfully...</p>");
					document.getElementById('Alert').style.display="block";
					document.getElementById('Alert').style.marginTop=((window.innerHeight / 2)) + "px";
					document.getElementById('Alert').style.padding="20px 20px 5px 20px";
					setTimeout(function(){
						document.getElementById('blackout').style.display='none';			
						document.getElementById('Alert').style.display='none';
					}, 1250);
				}
		  		else
		  		{
					
		  			document.getElementById('blackout').style.display="block";
		  			$("#Alert").html("<p style=\"color: red;\">There was a problem saving the CSS, please relog and try again later...</p>");
					document.getElementById('Alert').style.display="block";
					document.getElementById('Alert').style.marginTop=((window.innerHeight / 2)) + "px";
					document.getElementById('Alert').style.height="40px";
					document.getElementById('Alert').style.padding="8px 20px 5px 20px";
					setTimeout(function(){
						document.getElementById('blackout').style.display='none';			
						document.getElementById('Alert').style.display='none';
					}, 2250);
		  		}
		  	},
		  	error: function(){
		    	alert('There was a problem saving the CSS, please relog and try again later...');
		  	}
		});
	    event.preventDefault();
	    return false;
	});
	$("#ajax-save").click(function(){
		var str = $("#cssCode").val();
		$.ajax({
		  	url: "/administrator/panel/styling/putCSSFile.php",
		  	type: "POST",
		  	data: {cssCode: str},
		  	success: function(data){
		  		if(data == "1")
		  		{
		  			
		  			document.getElementById('blackout').style.display="block";
		  			$("#Alert").html("<p>saved successfully...</p>");
					document.getElementById('Alert').style.display="block";
					document.getElementById('Alert').style.marginTop=((window.innerHeight / 2)) + "px";
					document.getElementById('Alert').style.padding="20px 20px 5px 20px";
					setTimeout(function(){
						document.getElementById('blackout').style.display='none';			
						document.getElementById('Alert').style.display='none';
					}, 1250);
				}
		  		else
		  		{
					
		  			document.getElementById('blackout').style.display="block";
		  			$("#Alert").html("<p style=\"color: red;\">There was a problem saving the CSS, please relog and try again later...</p>");
					document.getElementById('Alert').style.display="block";
					document.getElementById('Alert').style.marginTop=((window.innerHeight / 2)) + "px";
					document.getElementById('Alert').style.height="40px";
					document.getElementById('Alert').style.padding="8px 20px 5px 20px";
					setTimeout(function(){
						document.getElementById('blackout').style.display='none';			
						document.getElementById('Alert').style.display='none';
					}, 2250);
		  		}
		  	},
		  	error: function(){
		    	alert('There was a problem saving the CSS, please relog and try again later...');
		  	}
		});
	});
	$(function() {

	  // Target all classed with ".lined"
	  $(".lined").linedtextarea(
	    {selectedLine: 1}
	  );

	  // Target a single one
	  $("#cssCode").linedtextarea();

	});
});
function resize() {
	$(function() {
		$('textarea').each(function() {
			$(this).height($(this).prop('scrollHeight'));
		});
	});
}
resize();