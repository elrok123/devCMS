$(document).ready(function(){
    var settings = {
        url: "upload.php",
        method: "POST",
        allowedTypes:"jpg,png,gif,doc,pdf,zip",
        fileName: "myfile",
        multiple: true,
        onSuccess:function(files,data,xhr)
        {
            $("#status").html("<font color='green'>Upload is success</font>");
        },
        afterUploadAll: function()
        {
            alert("all images uploaded!!");
        },
        onError: function(files,status,errMsg){        
            $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    }
    $("#mulitplefileuploader").uploadFile(settings);
});