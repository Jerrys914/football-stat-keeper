<?php
include_once ('../cookie/cookies.inc');
include_once ('../../code/user.inc');
include_once ('../../code/menu.inc');
?>

<html>
<head><title>Change Name</title>
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
		$firstName = $info['firstname'];
		$lastName = $info['lastname'];
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
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		
		$info['firstname'] = $firstName;
		$info['lastname'] = $lastName;
		
		updateUserData($user, $info);
		
		echo "Your name has been changed.";
		
		
		
		
		
	}
}
		
if ($showform)
{?>
	<form name="changeName" action="changeName.php" method="POST">
	<h2><a>
	First Name: <input type="text" name="firstName" id = "firstName" value= "<?=$firstName?>"><br />
	Last Name: <input type="text" name="lastName" id ="lastName" value="<?=$lastName?>"><br />
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