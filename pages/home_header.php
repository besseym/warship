<?php

//$email = "me@email.com";
$email = "";
$password = "";

require REAL_BASE . "pages/activation_header.php";

/******** EUSER LOGIN **********************/
$submitted = isset($_POST['submit']) && $_POST['submit'] == 'Sign In';
if($submitted){
	
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	
	//validate email input
	if(empty($email)){
		$messageArray[] = "Email is a required field.";
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$messageArray[] = "Invalid email address.";
	}
	
	//validate password input
	if(empty($password)){
		$messageArray[] = "Password is a required field.";
	}
	
	//there were no error messages attempt to sign in user
	if(empty($messageArray)){
	
		$player = authenticate_player($db_link, $email, $password);
		if($player != NULL){
		
			if($player->approved == 0)
			{
				$messageArray[] = "You must activate your account, and may do so <a href=\"" . PAGE_ACTIVATION . "\">here</a>";
			}
			else
			{
				//get the player's match record
				populate_match_record($db_link, $player);
			
				sign_in($player);
				header("Location: " . PAGE_PROFILE);
				exit;
			}
		
			
		}
		else {
			$messageArray[] = "The username or password you entered is incorrect.";
		}
	}
}
?>