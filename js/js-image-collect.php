<?php header("Content-Type: text/javascript"); include("../phpModules/image-collector.php"); ?>function galleriaAdd(){var $images = [<?php 
			$i = 0;
			$noOfFiles = count($files);

			foreach($files as $file)
			{
				if($i == ($noOfFiles - 1))
					echo "		\"" . substr($file, 2) . "\"\n";
				else if($i < ($noOfFiles - 1))
					echo "		\"" . substr($file, 2) . "\",\n"; 
				$i++;
			}
		?>];var $directories = [<?php 
			$i = 0;
			$noOfDirectories = count($directories);

			foreach($directories as $directory)
			{
				if($i == ($noOfDirectories - 1))
					echo "\"" . substr($directory, 2) . "\"";
				else if($i < ($noOfDirectories - 1))
					echo "\"" . substr($directory, 2) . "\","; 
				$i++;
			}
		?>];var e = "";
var t = "";
var n = {};
for (var r = 0; r < $directories.length; r++) {
    e = e + "<span class='gallery-dir-click' id=\"" + $directories[r] + '"><img id="' + r + '" class="gallery-dir" src="' + $directories[r].replace(" ", "-") + ".jpg\" /><p class='gallery-dir-title'>" + $directories[r].substring(36, $directories[r].length).replace("-", " ") + "</p></span>";
    t = "";
    for (var i = 0; i < $images.length; i++) {
        if ($images[i].indexOf($directories[r]) != -1) {
            t = t + '<img id="' + i + '" class="gallery-image" src="' + $images[i] + '" />'
        }
    }
    n[$directories[r]] = t
}
$("#portfolio-content").html(e);
$("#portfolio-content-images").css({
    width: window.innerWidth / 100 * 90 + "px",
    "margin-left": "5%",
    "margin-right": "5%"
});
$(".gallery-dir-click").click(function () {
    $("#portfolio-content-images").html(n[$(this).attr("id")]);
    var noOfElems = 0;
    var lastElem = 0;
    var start = 0;
    $('#portfolio-content-images').each(function(i, elem){
	    noOfElems = $(this).find('.gallery-image').length;
	    lastElem = $($(this).find('.gallery-image').last()).attr("id");
	    start = parseInt(lastElem) - noOfElems;
	});
    $(".gallery-image").click(function () {
        var e = $(this).attr("src");
        $("#FBL").append('<div class="black_overlay"><div data-id="' + (parseInt($(this).attr("id")) - 1) + '" class="galleria-previous"></div><img onclick="return false;" id="lightbox-image" src=\'' + e + "' /><div data-id=\"" + (parseInt($(this).attr("id")) + 1) + '" class="galleria-next"></div></div>');
        if ($(this).width() > $(this).height()) $("#lightbox-image").css({
            width: window.innerWidth / 100 * 80 + "px",
            height: "auto"
        });
        else if ($(this).width() < $(this).height()) $("#lightbox-image").css({
            width: "auto",
            height: window.innerHeight / 100 * 80 + "px"
        });
        $("#lightbox-image").css({
            "margin-left": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
            "margin-right": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
            top: (window.innerHeight - $("#lightbox-image").height()) / 2 + "px"
        });
        $("#lightbox-image").click(function (e) {
            e.preventDefault()
        });
        $(".black_overlay").click(function () {
            $(this).remove()
        });
        $("#lightbox-image").click(function (e) {
            e.stopPropagation()
        });
        $(".galleria-previous").click(function (e) {
            e.stopPropagation();
            if (parseInt($(this).attr("data-id")) <= start) return false;
            var t = $("#" + $(this).attr("data-id") + ".gallery-image").attr("src");
            $("#lightbox-image").attr("src", t);
            if ($("#lightbox-image").width() > $("#lightbox-image").height()) $("#lightbox-image").css({
                width: window.innerWidth / 100 * 80 + "px",
                height: "auto"
            });
            else if ($("#lightbox-image").width() < $("#lightbox-image").height()) $("#lightbox-image").css({
                width: "auto",
                height: window.innerHeight / 100 * 80 + "px"
            });
            $("#lightbox-image").css({
                "margin-left": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
                "margin-right": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
                top: (window.innerHeight - $("#lightbox-image").height()) / 2 + "px"
            });
            $(this).attr("data-id", parseInt($(this).attr("data-id")) - 1);
            $(".galleria-next").attr("data-id", parseInt($(".galleria-next").attr("data-id")) - 1 + "")
        });
        $(".galleria-next").click(function (e) {
            e.stopPropagation();
            if (parseInt($(this).attr("data-id")) > lastElem) return false;
            var t = $("#" + $(this).attr("data-id") + ".gallery-image").attr("src");
            $("#lightbox-image").attr("src", t);
            if ($("#lightbox-image").width() > $("#lightbox-image").height()) $("#lightbox-image").css({
                width: window.innerWidth / 100 * 80 + "px",
                height: "auto"
            });
            else if ($("#lightbox-image").width() < $("#lightbox-image").height()) $("#lightbox-image").css({
                width: "auto",
                height: window.innerHeight / 100 * 80 + "px"
            });
            $("#lightbox-image").css({
                "margin-left": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
                "margin-right": (window.innerWidth - $("#lightbox-image").width()) / 2 + "px",
                top: (window.innerHeight - $("#lightbox-image").height()) / 2 + "px"
            });
            $(this).attr("data-id", parseInt($(this).attr("data-id")) + 1);
            $(".galleria-previous").attr("data-id", parseInt($(".galleria-previous").attr("data-id")) + 1 + "")
        })
    });
    setPositions(location.hash);
});
}
