<?php 

    //This section of code checks to see if the client is using SSL, if not 
    /*if($_SERVER["HTTPS"] != "on")
    {
        header("HTTP/1.1 301 Moved Permanently");   
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }*/
    header('Content-Type: text/html; charset=utf-8');
    
	$login = "root";
    $password = "";

    $dsn = "mysql:unix_socket=/var/lib/mysql/mysql.sock;dhost=localhost;dbname=koanCMS";
	$opt = array(
		// any occurring errors wil be thrown as PDOException
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
    try
    {
    	$conn = new PDO($dsn, $login, $password, $opt);
    }
    catch(PDOException $err)
    {
        echo $err;
    }
?>