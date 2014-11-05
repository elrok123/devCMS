<?php

	/* This section of code returns the header HTML code from the database. */

	$statement = $conn->prepare("SELECT Code FROM content WHERE codeIdentifier = 'documentStart'");
	$statement->execute();

	$code = $statement->fetch();

	$documentStart = $code['Code'];

	
	/* This section of code returns the footer HTML code from the database. */
	
	$statement = $conn->prepare("SELECT Code FROM content WHERE codeIdentifier = 'documentEnd'");
	$code = $statement->fetch();

	$documentEnd = $code['Code'];

	/* This section of code returns the head HTML code from the database. */

	$statement = $conn->prepare("SELECT Code FROM content WHERE codeIdentifier = 'head'");
	$code = $statement->fetch();

	$head = $code['Code'];
	
	$statement = $conn->prepare("SELECT Code FROM content WHERE codeIdentifier = 'bodyStart'");
	$code = $statement->fetch();

	$bodyStart = $code['Code'];

	/* This section of code returns the doctype HTML code from the database. */
	
	$statement = $conn->prepare("SELECT Code FROM content WHERE codeIdentifier = 'Doctype'");
	$code = $statement->fetch();

	$doctype = $code['Code'];

	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) 
	{
	    // last request was more than 30 minates ago
	    session_unset();     // unset $_SESSION variable for the runtime 
	    session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

	if (!isset($_SESSION['CREATED'])) {
	    $_SESSION['CREATED'] = time();
	} 
	else if (time() - $_SESSION['CREATED'] > 1800) 
	{
	    // session started more than 30 minates ago
	    session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
	    $_SESSION['CREATED'] = time();  // update creation time
	}
	
?>