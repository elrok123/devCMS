<?php session_start(); include("../sql_connect/connection.php"); include("../sql_connect/modules.php"); 

    $username = $_GET['username'];

    $uploaddir = "clients/" . $details['id'];
    if(is_dir($uploaddir))
    {
        $whitespacefilename = basename($_FILES['uploadfile']['name']);
        $replace = "";
        $pattern = "/([[:alnum:]_\.-]*)/";
        $whitespacefilename = str_replace(str_split(preg_replace($pattern, $replace, $whitespacefilename)), $replace, $whitespacefilename);
        $filename = str_replace(" ", "-", $whitespacefilename);
        $filetype = end(explode(".", $filename));
        $filesizekb = ($_FILES['uploadfile']['size'] / 1024);
        $filesizemb = ($filesizekb / 1024);
        if($filetype == "" || explode(".", $filename) == 0)
        {
            echo 4;
            die();
        }
        $file = $uploaddir . "/" . $filename;   
        if(is_file($file))
        {
            echo 0;
            die();
        }
        else
        {
            if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
            {  
                /*$statement = $conn->prepare("INSERT INTO files (filename, postedby, filetype, filesize) VALUES (:filename, :postedby, :filetype, :filesize)"); 
                $statement->bindParam(":filename", $filename);
                $statement->bindParam(":postedby", $details['id']);
                $statement->bindParam(":filetype", $filetype);
                $statement->bindParam(":filesize", $filesizemb);
                $statement->execute();   */
                echo 1;
            }
            else
            {
                echo 2;
            }
        }
    }
    else
    {
        mkdir($uploaddir, 0777);
          
        $whitespacefilename = basename($_FILES['uploadfile']['name']);
        $replace = "";
        $pattern = "/([[:alnum:]_\.-]*)/";
        $whitespacefilename = str_replace(str_split(preg_replace($pattern, $replace, $whitespacefilename)), $replace, $whitespacefilename);
        $filename = str_replace(" ", "-", $whitespacefilename);
        $filetype = end(explode(".", $filename));
        $filesizekb = ($_FILES['uploadfile']['size'] / 1024);
        $filesizemb = ($filesizekb / 1024);
        /*if($filetype == "" || explode(".", $filename) == 0)
        {
            echo 4;
            die();
        }*/
        $file = $uploaddir . "/" . $filename;    
        
        if(is_file($file))
        {
            echo 0;
            die();
        }
        else
        {
            if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
            {  
                /*$statement = $conn->prepare("INSERT INTO files (filename, postedby, filetype, filesize) VALUES (:filename, :postedby, :filetype, :filesize)"); 
                $statement->bindParam(":filename", $filename);
                $statement->bindParam(":postedby", $details['id']);
                $statement->bindParam(":filetype", $filetype);
                $statement->bindParam(":filesize", $filesizemb);
                $statement->execute();*/
                echo 1;
            }
            else
            {
                echo 2;
            }
        }
    }  
?>  