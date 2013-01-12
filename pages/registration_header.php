<?php

define("MAIL_TOP", "<html>
<body bgcolor=\"#FFFFFF\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">
<table id=\"Table_01\" width=\"100%\" height=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border: 30px solid #000;\">
<tr>
<td align=\"left\" valign=\"top\" style=\"border-bottom: 1px solid #ccc; padding:10px;\">
<img src=\"http://static.php.net/www.php.net/images/php.gif\" width=\"120\" height=\"67\" alt=\"PHP Logo\">
</td>
</tr>
<tr>
<td align=\"left\" valign=\"top\" style=\"width:435px;height:100%;padding:20px;font-family: Helvetica,Arial,verdana sans-serif;font-size: 10pt;\">");

define("MAIL_BOTTOM", "</td>
</tr>
<tr>
<td align=\"left\" valign=\"bottom\" style=\"border-top: 1px solid #ccc;\">
<p style=\"color: #999; font-size: 10px; padding: 10px;\">
&copy; Warship.pro</p>
</td>
</tr>
</table>
</body>
</html>");

$name = "";
$email = "";

$submitted = isset($_POST['submit']) && $_POST['submit'] == 'Submit Registration';
if($submitted){

	$email = trim($_POST['email']);
	$name = trim($_POST['name']);
	$password = trim($_POST['password']);
	$password_confirm = trim($_POST['password-confirm']);
	
	//validate email input
	if(empty($email)){
		$messageArray[] = "Email is a required field.";
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$messageArray[] = "Invalid email address.";
	}
	
	//validate email input
	if(empty($name)){
		$messageArray[] = "Name is a required field.";
	}
	
	//validate password input
	if(empty($password)){
		$messageArray[] = "Password is a required field.";
	}
	
	//validate password input
	if(empty($password_confirm)){
		$messageArray[] = "Password confirmation is a required field.";
	}
	
	if($password != $password_confirm){
		$messageArray[] = "The password field does not match the password confirmation.";
	}
	
	//there were no error messages attempt to sign in user
	if(empty($messageArray)){
		
		if(!does_player_email_exist($db_link, $email)){
			if(!does_player_name_exist($db_link, $name)){
				$activation_code = rand(1000,9999);
				$player = new Player;
				$player->name = $name;
				$player->email = $email;
				$player->password = $password;
				$player->users_ip = $_SERVER['REMOTE_ADDR'];
				$player->activation_code = $activation_code;
				
				if(insert_player($db_link, $player)){
					
					// don't sign in. player has fist to activate the account
					//$player = authenticate_player($db_link, $email, $password);
					//sign_in($player);
					
					//Build a message to email for confirmation
							
					$message = "<p>Hi ".$player->name."!</p>
							<p>Welcome to Warship. Here are your login details...<br /><br />

							Email: " . $player->email  . "<br />
							Password: " . $player->password . "<br />
							Activation code: " . $player->activation_code . "</p><br />

							<p>You must activate your account before you can actually play the game online:<br /><br />
							
							<a href=\"". PAGE_ACTIVATION . "&user=" . get_md5_id($db_link, $player) . "&activation_code=" . $player->activation_code . "\">Click here to activate!</a></p><br /><br />

							<p>Thank you,<br /><br />

							Administrator<br />
							" . SITE_BASE . "</p>";

					$message_body = MAIL_TOP;
					$message_body .= $message;
					$message_body .= MAIL_BOTTOM;
					
					$headers = "From: Warship.pro  <" . GLOBAL_EMAIL . ">\r\n";
					$headers.= "Return-Path: " . GLOBAL_EMAIL . "\r\n";
					$headers.= "Message-ID: <" . gettimeofday(true) . " Warship.pro>\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					
					//$messageArray[] = get_md5_id($db_link, $player);
					$messageArray[] = "You have successfully registered, please check you emails for a confirmation email.";
					
					mail($email, "Warship registration", $message_body, $headers);
					
					$email = "";
					$name = "";
					//header("Location: " . PAGE_REGISTER);
					//exit;
				}
				else {
					$messageArray[] = "Unfortunaty an error occurred during registration. Please try again later. Thank you for your patience.";
				}
			}
			else
			{
				$messageArray[] = "That name is already in use. Please sign in or use a different address.";
			}
		}
		else {
			$messageArray[] = "That email address is already in use. Please sign in or use a different address.";
		}
	}
}

?>