<?php
include_once ('../cookie/cookies.inc');
include_once ('../../code/menu.inc');
include_once ('../../code/constants.inc');
include_once ('../../code/user.inc');
?>




<html>
<head><title>My Account</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
</head>
<body>


<?php 
include_once('../../code/header.inc');
	$loggedIn = IsLoggedIn();
	
	if (!$loggedIn)
	{
		header('Location: ' . SITEBASEURL . '/login/index.php');
	}
	
	createMenu($loggedIn);

	$user = $_COOKIE['user'];
			
	
			
	$info = getUserData ($user);
				
	if ($info < 0) //A file read error happened
	{
		echo 'File error'; 
	}
	

	echo "Name: " . $info['firstname'] . ' ' . $info['lastname'];
	echo '<br />';
	echo "Team: " . $info['team'];
	echo '<br />';
	echo "Email: " . $info['email'];
	
?>
<br /><br />
<a href="changeName.php">Change Name</a><br />
<a href="changePassword.php">Change Password</a><br />
<a href="changeEmail.php">Change Email</a><br /><br />
<a href="../login/index.php?logout=1" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
</body>
</html>