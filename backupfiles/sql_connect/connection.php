<?php 
    
	$login = "conner";
    $password = "danica4eva";

    $dsn = "mysql:host=localhost;dbname=backupdb";
	$opt = array(
		// any occurring errors wil be thrown as PDOException
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		// an SQL command to execute when connecting
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
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