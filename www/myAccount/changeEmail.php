<?php
include_once ('../cookie/cookies.inc');
include_once ('../../code/user.inc');
include_once ('../../code/menu.inc');
?>

<html>
<head><title>Change Email</title>
<link rel="stylesheet" type="text/css" href="../css/common.css"></link>
</head>
<body>


<?php
include_once ('../../code/header.inc');
$loggedIn = IsLoggedIn();
createMenu($loggedIn);

if ($loggedIn)
{
	$user = $_COOKIE['user'];
	
	if (userExists($user))
	{
							
		$info = getUserData($user);
		$email = $info['email'];
		$showform = true;
		
	}
	else
	{
		echo 'user not found';
		$showform = false;
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' )
	{
		$showform = false;
		$email = $_POST['email'];
		
		$info['email'] = $email;
		
		updateUserData($user, $info);
		
		echo "Your email has been changed.";
		
		
		
		
		
	}
}
		
if ($showform)
{?>
	<form name="changeEmail" action="changeEmail.php" method="POST">
	<h2><a>
	Email: <input type="text" name="email" id = "email" value= "<?=$email?>"><br />
	<input type="hidden" name="form" value="1">
	<input type="Submit" value="Submit">
	</a></h2>
	</form>
	<?php
}

		
		
	
			
	
			
?>
<br /><br />
<a href= "../index.php">Click to go back.<a/>
</body>
</html>