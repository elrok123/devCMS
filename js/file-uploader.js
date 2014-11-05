var $galleryName = '';
var $clientID = '';
$('#galleryName').bind('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9\ \b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});
setInterval(function() {
    if ($("#galleryName").val() != $galleryName || $("#clientID").val() != $clientID) {
        $galleryName = encodeURI($("#galleryName").val());
        $clientID = $("#clientID").val();
    }
    $(function(){
        new AjaxUpload($('#zipFile'), {  
            action: ('upload-file.php' + "?clientID=" + $clientID + "&galleryName=" + $galleryName),
            name: 'zipFile',  
            onSubmit: function(file, ext){  
                if ((ext && !/^(zip)$/.test(ext)) || $("#galleryName").val() == ""){   
                    alert("There was a problem with the file/gallery name");
                    return false;  
                }
                if($galleryName)
                $("#loading").show();
                $("#galleryName").attr('disabled', 'disabled');
            },  
            onComplete: function(file, response){
                alert(response);
                var $galleryNameFinal = $galleryName;
                
                $.get( ("/administrator/panel/gallery/addGallery/get-gallery-images.php?galleryName=" + $galleryNameFinal.replace(" ", "-")), function( data ) {

                    $jsonData = JSON.parse("[" + data + "]");
                    if ($jsonData[0].length > 1) 
                    {
                        $("#loading").html("<img style=\"width: 25px; height: auto;\" src=\"http://www.overnetdata.com/wp-content/uploads/2014/01/tick.png\" /> Gallery creation was successful, and has been saved, you may leave this page.");
                        for (var i = 0; i < $jsonData[0].length; i++) 
                        {
                            $("#files").append("<img class=\"gallery-image\" src=\"" + $jsonData[0][i].location + "\" />");
                        };
                    };
                    
                });
            }  
        });  
    });

}, 200);

/*function submitDownload(file)
{
    $('#status').text("");
    document.getElementById('secretIFrame').src = "download.php?download="+file;
    $('#status').append("Your browser has been sent the download request (Save or Open the file...) <img src='../img/success.png' style='width:22px; height:22px;margin-bottom:-4px;' /></br>");
}*/