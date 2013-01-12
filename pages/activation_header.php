<?php

$user = NULL;
$activation_code = NULL;
$email = NULL;
$is_active = false;

/******** EMAIL ACTIVATION LINK**********************/
if(isset($_GET['user']) && !empty($_GET['activation_code']) && !empty($_GET['user']) && is_numeric($_GET['activation_code']) )
{
	$user = trim($_GET['user']);
	$activ = trim($_GET['activation_code']);

	//check if activ code and user is valid
	$rs_check = mysql_query("SELECT id FROM players WHERE md5_id='$user' AND activation_code='$activ'") or die (mysql_error());
	$num = mysql_num_rows($rs_check);
	// Match row found with more than 1 results  - the user is authenticated.
	if ( $num <= 0 )
	{
		$messageArray[] = "Unable to verify account";
	}

	if(empty($messageArray))
	{
		// set the approved field to 1 to activate the account
		$rs_activ = mysql_query("UPDATE players SET approved='1' WHERE md5_id='$user' AND activation_code = '$activ' ") or die(mysql_error());
		$messageArray[] = "Account activated successfully!  You may now login <a href=\"" . PAGE_HOME . "\">here</a>.";
		
		$is_active = true;
	}
}

/******************* ACTIVATION BY FORM**************************/
if (isset($_POST['activate']))
{

	$email = trim($_POST['email']);
	$activation_code = trim($_POST['activation_code']);
	//check if activ code and user is valid as precaution
	$rs_check = mysql_query("SELECT id FROM players WHERE email = AES_ENCRYPT('$email', '$salt') AND activation_code='$activation_code'") or die (mysql_error());
	$num = mysql_num_rows($rs_check);
	// Match row found with more than 1 results  - the user is authenticated.
	if ( $num <= 0 )
	{
		$messageArray[] = "Unable to verify account";
	}
	//set approved field to 1 to activate the user
	if(empty($messageArray))
	{
		$rs_activ = mysql_query("UPDATE players SET approved='1' WHERE email = AES_ENCRYPT('$email', '$salt') AND activation_code = '$activation_code' ") or die(mysql_error());
		$messageArray[] = "Account activated successfully!  You may now <a href=\"" . PAGE_HOME . "\">login</a>.";
		
		$is_active = true;
	}
}
?>