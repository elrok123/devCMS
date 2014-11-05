<?php ob_start(); session_start(); include ('../sql_connect/connection.php'); include('../sql_connect/modules.php');

    //This section of code checks to see if the client is using SSL, if not 
    // if($_SERVER["HTTPS"] != "on")
    // {
    //        header("HTTP/1.1 301 Moved Permanently");   
    //        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    //        exit();
    // }
    
    if(isset($_SESSION['email']) == false)
    {
        header("Location: ../");
    }
    if(isset($_GET['profileid']))
    {
        $statement = $conn->prepare("SELECT *, date_format('dob','%d-%m-%Y') as dateofbirth, date_format(registrationdate,'%d-%m-%Y') as dateregistered FROM users WHERE id = :id ORDER BY dob DESC"); 
        $statement->bindParam(":id", $_GET['profileid']);
        $statement->execute();
    }
    else
    {
        $email = $_SESSION['email'];
        $statement = $conn->prepare("SELECT *, date_format('dob','%d-%m-%Y') as dateofbirth, date_format(registrationdate,'%d-%m-%Y') as dateregistered FROM users WHERE email = :email ORDER BY dob DESC"); 
        $statement->bindParam(":email", $email);
        $statement->execute();
        
    }
    $details = $statement->fetch();
    if(isset($_SESSION['id']) == false)
    {
        $_SESSION['id'] = $details['id'];
    }
    ///////////////////////////////////////////////////////////////////////////////////////////
    //This is the handler for profile edits 
    ///////////////////////////////////////////////////////////////////////////////////////////
    if(isset($_POST['infoSubmitted']) && $_POST['firstname'] != "" && $_POST['surname'] != "" && $_POST['nationality'] != "-")
    {
        $allowedExts = array("jpg", "jpeg", "gif", "png", "exe", "mp4", "mp3", "tar", "zip", "mkv", "avi", "flac", "ogg", "wmv", "psd", "aac", "mov", "iso", "doc", "docx", "img", );
        $extension = end(explode(".", $_FILES["profilepic"]["name"]));
        $filename = $details['id'] . ".". $extension;
        $imageupdated = 0;
        //in_array($extension, $allowedExts) && 
        if($_FILES["profilepic"]["size"] <= 1073741824)
        {
            if ($_FILES["profilepic"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["profilepic"]["error"] . "<br />";
            }
            else
            {
                move_uploaded_file($_FILES["profilepic"]["tmp_name"], "../profilepics/" . $filename);
                $imageupdated = 1;
            }
        }
        try
        {
            $firstname = addslashes($_POST['firstname']);
            $surname = addslashes($_POST['surname']);
            $nationality = $_POST['nationality'];
            $aboutme = addslashes($_POST['aboutme']);
            if($imageupdated == 1)
            {
                $query = "UPDATE users SET firstname = :firstname, surname = :surname, nationality = :nationality, aboutme = :aboutme, imagename = :imagename WHERE id = :id";
            }
            else
            {
                $query = "UPDATE users SET firstname = :firstname, surname = :surname, nationality = :nationality, aboutme = :aboutme WHERE id = :id";
            }
            $statement = $conn->prepare($query); 
            $statement->bindParam(":firstname", $firstname);
            $statement->bindParam(":surname", $surname);
            $statement->bindParam(":nationality", $nationality);
            $statement->bindParam(":aboutme", $aboutme);
            if($imageupdated == 1)
            {
                $statement->bindParam(":imagename", $filename);
            }
            $statement->bindParam(":id", $details['id']);

            $statement->execute();
        }
        catch(PDOException $err)
        {
            echo $err;
        }
        header("Location: ../");
    }
    else if(isset($_POST['infoSubmitted']))
    {
        echo "The edited info you submitted was not valid, please enter valid data before submitting.";
    }

    $statement = $conn->prepare("SELECT * FROM files WHERE postedby = :id");
    $statement->bindParam(":id", $details['id']);
    $statement->execute();
    $totalFiles = $statement->rowCount();
    
    $stats = totalPercentageUsed($conn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Profile Page - Cloud Backup</title>
        <link href="../css/styles.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
        <script type="text/javascript" src="../js/profile.js"></script>
        <script type="text/javascript" src="js/jquery-1.3.2.js" ></script>
        <script type="text/javascript" src="js/ajaxupload.3.5.js" ></script>
        <link rel="stylesheet" type="text/css" href="./styles.css" />
        <script type="text/javascript">
            $(function(){  
                var btnUpload=$('#upload');  
                var status=$('#status');  
                new AjaxUpload(btnUpload, {  
                    action: 'upload-file.php',  
                    //Name of the file input box  
                    name: 'uploadfile',  
                    onSubmit: function(file, ext){  
                        if ((ext && /^(bat|bin|sh|vbs|irb|vba|)$/.test(ext))){   
                            // check for valid file extension   
                            status.text('Unsupported file type...');  
                            return false;  
                        } 
                        status.text("");
                        $('#status').append("<img src='icons/loadingBar.gif' /></br>Uploading...</br>")
                    },  
                    onComplete: function(file, response){  
                        //On completion clear the status  
                        status.text("");
                        if(response == 0)
                        {
                            status.text("This file already exists, please rename the file before you reupload!");
                            $('#status').append("<img src='../img/Error.png' style='width:22px; height:22px;margin-bottom:-4px;' /></br>");  
                        } 
                        else if(response == 2)
                        {
                            status.text("There was an error uploading your file :S");
                            $('#status').append("<img src='../img/Error.png' style='width:22px; height:22px;margin-bottom:-4px;' /></br>"); 
                        } 
                        else if(response == 1)
                        {
                            status.text("Your file has been uploaded successfuly! (Refresh the page to see newly uploaded files...)"); 
                            $('#status').append("<img src='../img/success.png' style='width:22px; height:22px;margin-bottom:-4px;' /></br>");
                        }
                        else if(response == 4)
                        {
                            status.text("There was an error establishing the file type..."); 
                            $('#status').append("<img src='../img/Error.png' style='width:22px; height:22px;margin-bottom:-4px;' /></br>"); 
                        } 
                        //Add uploaded file to list  
                        document.getElementById('nouploads').style.display="none";
                        
                        $("<a href='uploads/<?php echo $details['id']; ?>/"+file+"'</a>").appendTo('#files').text(file).addClass('success'); 
                    }  
                });  
            });
            function submitDownload(file)
            {
                $('#status').text("");
                document.getElementById('secretIFrame').src = "download.php?download="+file;
                $('#status').append("Your browser has been sent the download request (Save or Open the file...) <img src='../img/success.png' style='width:22px; height:22px;margin-bottom:-4px;' /></br>");
            }
        </script>
    </head>
    <body>

        <div class="profile_viewer">
            <div style="float:right;text-align:right;">Welcome, <?php echo $details['firstname']; ?>...</br><a href="../logout/">Logout...</a></br>You have <?php echo $totalFiles; ?> files stored on the server...</div>
            <iframe id="secretIFrame" src="" style="display:none; visibility:hidden;"></iframe>
            <div id="upload" ><a id="cursor">Upload File</a></div></br><span>Click on a link to download your files to your PC...</span>
            <div id="status"></div>
            <!--List Files-->  
            <ul id="files" >
            </ul>
            <?php 

                $statement = $conn->prepare("SELECT *, DATEDIFF(`dateadded`, NOW()) AS showdate FROM files WHERE postedby = :id ORDER BY dateadded DESC");
                $statement->bindParam(":id", $details['id']);

                $statement->execute();

                $userFileCount = $statement->rowCount();
                $i = 0;
                $i2 = 0;
                if(isset($_GET['filepage']))
                {
                    $startFrom = ($_GET['filepage'] * 4) - 4;
                    while($row = $statement->fetch())
                    {
                        $days = abs($row['showdate']);
                        if($days == 0)
                        {
                            $days = "today";
                            $suffix = "";
                        }
                        else
                        {
                            $suffix = " days ago";
                        }
                        if($row['filetype'] == "JPG" || $row['filetype'] == "jpg" || $row['filetype'] == "png" || $row['filetype'] == "jpeg" || $row['filetype'] == "gif" || $row['filetype'] == "tiff" || $row['filetype'] == "ico")
                        {
                            $filetype = "icons/image.png";
                        }
                        else if($row['filetype'] == "mp3" || $row['filetype'] == "mp4" || $row['filetype'] == "wav" || $row['filetype'] == "wma")
                        {
                            $filetype = "icons/music.png";
                        }
                        else if($row['filetype'] == "php" || $row['filetype'] == "html" || $row['filetype'] == "css" || $row['filetype'] == "py" || $row['filetype'] == "js" || $row['filetype'] == "xml" || $row['filetype'] == "xhtml" || $row['filetype'] == "htm" || $row['filetype'] == "rb" || $row['filetype'] == "irb" || $row['filetype'] == "ruby")
                        {
                            $filetype = "icons/developer.png";
                        }
                        else if($row['filetype'] == "psd")
                        {
                            $filetype = "icons/photoshop.png";
                        }
                        else if($row['filetype'] == "txt")
                        {
                            $filetype = "icons/text.png";
                        }
                        else if($row['filetype'] == "zip" || $row['filetype'] == "gz" || $row['filetype'] == "tar")
                        {
                            $filetype = "icons/compressed.png";
                        }
                        else if($row['filetype'] == "doc" || $row['filetype'] == "asd" || $row['filetype'] == "cnv" || $row['filetype'] == "docm" || $row['filetype'] == "docx" || $row['filetype'] == "dot" || $row['filetype'] == "dotm" || $row['filetype'] == "dotx")
                        {
                            $filetype = "icons/word.png";
                        }
                        else if($row['filetype'] == "xar" || $row['filetype'] == "xl" || $row['filetype'] == "xla" || $row['filetype'] == "xlam" || $row['filetype'] == "xlb" || $row['filetype'] == "xlc" || $row['filetype'] == "xll" || $row['filetype'] == "xlm" || $row['filetype'] == "xls" || $row['filetype'] == "xlsb" || $row['filetype'] == "xlsm" || $row['filetype'] == "xlsx" || $row['filetype'] == "xlt" || $row['filetype'] == "xltm" || $row['filetype'] == "xltx" || $row['filetype'] == "xlw")
                        {
                            $filetype = "icons/excel.png";
                        }
                        else if($row['filetype'] == "pa" || $row['filetype'] == "pot" || $row['filetype'] == "potm" || $row['filetype'] == "potx" || $row['filetype'] == "ppa" || $row['filetype'] == "ppam" || $row['filetype'] == "pps" || $row['filetype'] == "ppsm" || $row['filetype'] == "ppsx" || $row['filetype'] == "ppt" || $row['filetype'] == "pptm" || $row['filetype'] == "pptx")
                        {
                            $filetype = "icons/excel.png";
                        }
                        else if($row['filetype'] == "pdf")
                        {
                            $filetype = "icons/pdf.png";
                        }
                        else
                        {
                            $filetype = "icons/fileicon_bg.png";
                        }
                        if($i >= $startFrom && $i <= ($startFrom+4))
                        {
                            echo "<span class='success'><img class='icons' src='".$filetype."' /><span class='spacer'> </span><a id='download' href='javascript:submitDownload(\"".$row['filename']."\")' >" . $row['filename'] . "</a></br>File size: ".$row['filesize']." Mb</br> Submitted " . $days . $suffix . ".</span></br></br></br>";
                            $i2++;
                        }
                        if($i2 == 4 || $i == ($userFileCount-1))
                        {

                            $i = ceil($userFileCount / 4);
                            echo "<div class='profile_viewer_controls'></br>
                                    <ul style='float: right; margin-right: -200px'>";
                            if($_GET['filepage']<$i)
                            {
                                echo "\r\n<li><a href='?filepage=".($_GET['filepage']+1)."'>Next</a></li>";
                            }
                            while($i >= 1)
                            {
                                if($i != $_GET['filepage'])
                                {
                                    $underline = "style='text-decoration: none;'";
                                }
                                else
                                {
                                    $underline = "";
                                }
                                echo "\r\n<li><a href='?filepage=".$i."' ".$underline.">".$i."</a></li>";

                                $i--;
                            }
                            if($_GET['filepage']>1)
                            {
                                echo "\r\n<li><a href='?filepage=".($_GET['filepage']-1)."'> Previous </a></li>";
                            }
                            echo "<li><a>Pages: </a></li></ul></div>";
                            break;
                        }
                        $i++;
                        
                    }
                }
                else if($userFileCount > 0)
                {
                    while($row = $statement->fetch())
                    {
                        $days = abs($row['showdate']);
                        if($days == 0)
                        {
                            $days = "today";
                            $suffix = "";
                        }
                        else
                        {
                            $suffix = " days ago";
                        }
                        if($row['filetype'] == "JPG" || $row['filetype'] == "jpg" || $row['filetype'] == "png" || $row['filetype'] == "jpeg" || $row['filetype'] == "gif" || $row['filetype'] == "tiff" || $row['filetype'] == "ico")
                        {
                            $filetype = "icons/image.png";
                        }
                        else if($row['filetype'] == "mp3" || $row['filetype'] == "mp4" || $row['filetype'] == "wav" || $row['filetype'] == "wma")
                        {
                            $filetype = "icons/music.png";
                        }
                        else if($row['filetype'] == "php" || $row['filetype'] == "html" || $row['filetype'] == "css" || $row['filetype'] == "py" || $row['filetype'] == "js" || $row['filetype'] == "xml" || $row['filetype'] == "xhtml" || $row['filetype'] == "htm" || $row['filetype'] == "rb" || $row['filetype'] == "irb" || $row['filetype'] == "ruby")
                        {
                            $filetype = "icons/developer.png";
                        }
                        else if($row['filetype'] == "psd")
                        {
                            $filetype = "icons/photoshop.png";
                        }
                        else if($row['filetype'] == "txt")
                        {
                            $filetype = "icons/text.png";
                        }
                        else if($row['filetype'] == "zip" || $row['filetype'] == "gz" || $row['filetype'] == "tar")
                        {
                            $filetype = "icons/compressed.png";
                        }
                        else if($row['filetype'] == "doc" || $row['filetype'] == "asd" || $row['filetype'] == "cnv" || $row['filetype'] == "docm" || $row['filetype'] == "docx" || $row['filetype'] == "dot" || $row['filetype'] == "dotm" || $row['filetype'] == "dotx")
                        {
                            $filetype = "icons/word.png";
                        }
                        else if($row['filetype'] == "xar" || $row['filetype'] == "xl" || $row['filetype'] == "xla" || $row['filetype'] == "xlam" || $row['filetype'] == "xlb" || $row['filetype'] == "xlc" || $row['filetype'] == "xll" || $row['filetype'] == "xlm" || $row['filetype'] == "xls" || $row['filetype'] == "xlsb" || $row['filetype'] == "xlsm" || $row['filetype'] == "xlsx" || $row['filetype'] == "xlt" || $row['filetype'] == "xltm" || $row['filetype'] == "xltx" || $row['filetype'] == "xlw")
                        {
                            $filetype = "icons/excel.png";
                        }
                        else if($row['filetype'] == "pa" || $row['filetype'] == "pot" || $row['filetype'] == "potm" || $row['filetype'] == "potx" || $row['filetype'] == "ppa" || $row['filetype'] == "ppam" || $row['filetype'] == "pps" || $row['filetype'] == "ppsm" || $row['filetype'] == "ppsx" || $row['filetype'] == "ppt" || $row['filetype'] == "pptm" || $row['filetype'] == "pptx")
                        {
                            $filetype = "icons/excel.png";
                        }
                        else if($row['filetype'] == "pdf")
                        {
                            $filetype = "icons/pdf.png";
                        }
                        else
                        {
                            $filetype = "icons/fileicon_bg.png";
                        }
                        echo "<span class='success'><img class='icons' src='".$filetype."' /><span class='spacer'> </span><a id='download' href='javascript:submitDownload(\"".$row['filename']."\")' >" . $row['filename'] . "</a></br>File size: ".$row['filesize']." Mb</br> Submitted " . $days . $suffix . ".</span></br></br></br>";
                        
                        if($i == 3)
                        {
                            $i = ceil($userFileCount / 4);
                            echo "<div class='profile_viewer_controls'></br>
                                    <ul style='float: right; margin-right: -200px'>";
                            echo "\r\n<li><a href='?filepage=2'>Next</a></li>";
                            while($i >= 1)
                            {
                                echo "\r\n<li><a href='?filepage=".$i."' style='text-decoration: none;'>".$i."</a></li>";
                                $i--;
                            }
                            echo "<li ><a>Pages: </a></li></ul></div>";
                            break;
                        }
                        $i++;
                    }
                }
                else
                {
                    echo "<div id='nouploads'>You haven't added any files yet :( Upload a file now, by clicking the upload button :)</div>";
                }
            ?>
       </div> 
    </body>
</html>