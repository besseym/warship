<?php

	require "includes/constants.inc.php";
	
	//include db interactions
	require REAL_BASE . "includes/db/db_constants" . $server . ".inc.php";
	require REAL_BASE . "includes/db/db_install.inc.php";
	require REAL_BASE . "includes/db/db_connect.inc.php";
	require REAL_BASE . "includes/db/db_player.inc.php";
	require REAL_BASE . "includes/db/db_match.inc.php";
	
	//include ship models
	require REAL_BASE . "includes/model/ships/m_battleship.inc.php";
	require REAL_BASE . "includes/model/ships/m_crusier.inc.php";
	require REAL_BASE . "includes/model/ships/m_frigate.inc.php";
	require REAL_BASE . "includes/model/ships/m_minesweeper.inc.php";
	
	//include models
	require REAL_BASE . "includes/model/m_battle_ai_basic.inc.php";
	require REAL_BASE . "includes/model/m_battle_ai_advanced.inc.php";
	
	//include utils
	require REAL_BASE . "includes/util/util_security.inc.php";
	require REAL_BASE . "includes/util/util_battle.inc.php";
	
	//make the session available
	session_start();

	$p_index = 'p';
	$p = null;
	if(isset($_GET[$p_index])){
		$p = $_GET[$p_index];
	}
	elseif(isset($_POST[$p_index])){
		$p = $_POST[$p_index];
	}
	
	if(!isset($p)){
		$p = 'home';
	}
	
	$header_js = "";
	
	//Grab the page to display (if called)
	$title = null;
	$page = null;
	$header = null;
	switch($p){
		case 'home':
			$title = "Home";
			$page = "home.php";
			$header = "home_header.php";
			$header_js = "home_header.js.php";
			break;
		case 'activation':
			$title = "Activation";
			$page = "activation.php";
			$header = "activation_header.php";
			break;
		case 'register':
			$title = "Registration";
			$page = "registration.php";
			$header = "registration_header.php";
			$header_js = "registration_header.js.php";
			break;
		case 'profile':
			$title = "Profile";
			$page = "profile.php";
			$header = "profile_header.php";
			break;
		case 'battle':
			$title = "Battle";
			$page = "battle.php";
			$header = "battle_header.php";
			$header_js = "battle_header.js.php";
			break;
		case 'beginner_leaderboard':
			$title = "Beginner Leaderboard";
			$page = "leaderboard.php";
			$header = "beginner_leaderboard_header.php";
			break;
		case 'advanced_leaderboard':
			$title = "Advanced Leaderboard";
			$page = "leaderboard.php";
			$header = "advanced_leaderboard_header.php";
			break;
		case 'sign_out':
			$title = "Signed Out";
			$page = "sign_out.php";
			$header = "sign_out_header.php";
			break;
		default:
			$title = "404 Error File Not Found";
			$page = "error404.php";
			$header = "error_header.php";
			break;
	}
	
	//Check to make sure the file actually exists, if no, call default
	if(!file_exists("pages/" . $page)){
		$title = "404 Error File Not Found";
		$page = "error404.php";
		$header = "error_header.php";
	}
	
	require REAL_BASE . "pages/" . $header;
	
	//check there is a player currently signed in
	//must run after header include
	$is_signed_in = is_signed_in();
	
	$title = "Warship : " . $title;

?>
<!DOCTYPE HTML>
<html>
	<head>
		
		<title><?php echo $title ?></title>
	
		<link href='http://fonts.googleapis.com/css?family=Unlock' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Allerta+Stencil' rel='stylesheet' type='text/css'>
		<link type="text/css" rel="stylesheet" media="all" href="styles/common.css" />
		<link type="text/css" rel="stylesheet" media="all" href="styles/main.css" />
		<script type="text/javascript" src="scripts/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="scripts/jquery.validate.js"></script>
		<script type="text/javascript" src="scripts/main.js"></script>
		
		<?php 
			if(!empty($header_js)){
				include REAL_BASE . "pages/" . $header_js; 
			}
		?>
		
	</head>
	<body>
		<section id="wrapper">
			<header id="main-header">
			<h1><a href="<?php echo PAGE_HOME ?>" >Warship</a></h1>
			
				<?php if($is_signed_in) { ?>
				<nav id="auth-nav" class="clearfix">
					<ul>
						<li <?php if($p == 'profile'){ ?>class="current-page"<?php } ?>>
							<a href="<?php echo PAGE_PROFILE ?>" >My Profile</a>
						</li>
						<li <?php if($p == 'beginner_leaderboard'){ ?>class="current-page"<?php } ?>>
							<a href="<?php echo PAGE_BEGINNER_LEADERBOARD ?>" >Leaderboard of Beginners</a>
						</li>
						<li <?php if($p == 'advanced_leaderboard'){ ?>class="current-page"<?php } ?>>
							<a href="<?php echo PAGE_ADVANCED_LEADERBOARD ?>" >Leaderboard of Advanced Players</a>
						</li>
						<li class="logout">
							<a href="<?php echo PAGE_SIGN_OUT ?>" >Sign Out</a>
						</li>
					</ul>
				</nav>
				<?php } ?>
				
			</header>
			<?php require REAL_BASE . "/includes/segments/seg_flash.inc.php"; ?>
			<section id="main-section">
				<?php include REAL_BASE . "pages/" . $page; ?>
			</section>
			<footer id="main-footer">
				<p>Copyright &copy; 2010. All Rights Reserved.</p>
			</footer>
		</section>
	</body>
</html>

<?php mysql_close($db_link); ?>