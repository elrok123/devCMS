<?php session_start(); include('../../../../dbaccess/index.php'); include('../../../../dbaccess/modules.php'); 

    
    if(isset($_GET['clientID']) && isset($_GET['galleryName']))
    {
        $clientID = $_GET['clientID'];
        $uploaddir = "../clients/" . $_GET['clientID'];
        $galleryName = html_entity_decode($_GET["galleryName"], null, 'UTF-8');
        //$galleryName = str_replace(" ", "-", $galleryName);

        $uploadsubdir = $uploaddir . "/" . $galleryName;
        if(is_dir($uploaddir) && is_dir($uploadsubdir))
        {
            $whitespacefilename = basename($_FILES['zipFile']['name']);
            $replace = "";
            $pattern = "/([[:alnum:]_\.-]*)/";
            $whitespacefilename = str_replace(str_split(preg_replace($pattern, $replace, $whitespacefilename)), $replace, $whitespacefilename);
            $filename = str_replace(" ", "-", $whitespacefilename);
            $filesizekb = ($_FILES['zipFile']['size'] / 1024);
            $filesizemb = ($filesizekb / 1024);
            $file = $uploadsubdir . "/" . $filename;
            if(move_uploaded_file($_FILES['zipFile']['tmp_name'], $file)) 
            {   
                $filename=$file;
                $zip = new ZipArchive;
                if ($zip->open($filename) === true) 
                {
                    //unzip into the folders
                    for($i = 0; $i <= $zip->numFiles; $i++) 
                    {
                        $OnlyFileName = $zip->getNameIndex($i);
                        $FullFileName = $zip->statIndex($i);    

                        if (!($FullFileName['name'][strlen($FullFileName['name'])-1] =="/"))
                        {
                            if (preg_match('#\.(jpg|jpeg|gif|png)$#i', $OnlyFileName))
                            {
                                if(copy('zip://'. $filename .'#'. $OnlyFileName, ($uploadsubdir . "/" . $OnlyFileName))) 
                                {
                                    $statement = $conn->prepare("INSERT INTO image (galleryId, location, createdBy) VALUES (:galleryID, :location, :createdBy)"); 
                                    $location = ((str_replace("..", "/administrator/panel/gallery", $uploadsubdir)) . "/" . $OnlyFileName);
                                    $statement->bindParam(":location", $location);
                                    $statement->bindParam(":galleryID", $galleryID);
                                    $statement->bindParam(":createdBy", $userDetails->getID());
                                    $statement->execute();
                                }
                            } 
                        }

                    }
                    $zip->close();
                    echo "Zip extraction and file seperation complete!";
                } 
                else
                {
                    echo "Error: Can't open zip file, please try again";
                }
                echo 1;
            }
            else
            {
                echo 2;
            }
        }
        else
        {
            if(!is_dir($uploaddir)) 
                mkdir($uploaddir, 0777);

            if(!is_dir($uploadsubdir))
                if(mkdir($uploadsubdir, 0777))
                {
                    $statement = $conn->prepare("INSERT INTO gallery (galleryName, createdBy, clientId) VALUES (:galleryName, :createdBy, :clientID)"); 
                    $statement->bindParam(":galleryName", $galleryName);
                    $statement->bindParam(":createdBy", $userDetails->getID());
                    $statement->bindParam(":clientID", $clientID);
                    if($statement->execute())
                        $galleryID = $conn->lastInsertId();
                    else
                        die();
                }
            else
                echo "This Gallery already exists, please choose another name...";

            $whitespacefilename = basename($_FILES['zipFile']['name']);
            $replace = "";
            $pattern = "/([[:alnum:]_\.-]*)/";
            $whitespacefilename = str_replace(str_split(preg_replace($pattern, $replace, $whitespacefilename)), $replace, $whitespacefilename);
            $filename = str_replace(" ", "-", $whitespacefilename);
            $filesizekb = ($_FILES['zipFile']['size'] / 1024);
            $filesizemb = ($filesizekb / 1024);
            $file = $uploadsubdir . "/" . $filename;
            if(move_uploaded_file($_FILES['zipFile']['tmp_name'], $file)) 
            {   
                $filename=$file;
                $zip = new ZipArchive;
                if ($zip->open($filename) === true) 
                {
                    //unzip into the folders
                    for($i = 0; $i <= $zip->numFiles; $i++) 
                    {
                        $OnlyFileName = $zip->getNameIndex($i);
                        $FullFileName = $zip->statIndex($i);    

                        if (!($FullFileName['name'][strlen($FullFileName['name'])-1] =="/"))
                        {
                            if (preg_match('#\.(jpg|jpeg|gif|png)$#i', $OnlyFileName))
                            {
                                if(copy('zip://'. $filename .'#'. $OnlyFileName, ($uploadsubdir . "/" . $OnlyFileName))) 
                                {
                                    $statement = $conn->prepare("INSERT INTO image (galleryId, location, createdBy) VALUES (:galleryID, :location, :createdBy)"); 
                                    $location = ((str_replace("..", "/administrator/panel/gallery", $uploadsubdir)) . "/" . $OnlyFileName);
                                    $statement->bindParam(":location", $location);
                                    $statement->bindParam(":galleryID", $galleryID);
                                    $statement->bindParam(":createdBy", $userDetails->getID());
                                    $statement->execute();
                                }
                            } 
                        }

                    }
                    $zip->close();
                    echo "Zip extraction and file seperation complete!";
                } 
                else
                {
                    echo "Error: Can't open zip file, please try again";
                }
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
        echo 5;
        echo "Please enter a valid Client and a valid Gallery name...";
    }
?>  