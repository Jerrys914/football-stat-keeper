<?php
include_once ('../cookie/cookies.inc');
include_once ('../../code/user.inc');
include_once ('../../code/menu.inc');
include_once ('../../code/select_boxes.inc');
?>

<html>
<head><title>Change Password</title>
<link rel="stylesheet" type="text/css" href="../css/common.css"></link>
</head>
<body>


<?php
include_once ('../../code/header.inc');

	$loggedIn = IsLoggedIn();
	createMenu($loggedIn);
	
	$showform = true;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' )
	{
		$newPassword = trim($_POST['newPassword']);
		$confirmPassword = trim($_POST['confirmPassword']);
		$currentPassword = md5(trim(strtoupper($_POST['currentPassword'])));
		
		if ($loggedIn)
		{
			$user = $_COOKIE['user'];
			
			if (userExists($user))
			{
									
				$info = getUserData($user);

								
				if ($info['password'] == $currentPassword && $newPassword == $confirmPassword)
				{
					$info['password'] = md5(strtoupper($confirmPassword));
				
					$result = updateUserData($user, $info);
					
					if($result <= 0)
					{
						echo ' error updating';
						$showform = true;
					}
					else
					{
						$showform = false;
						echo "Your password was changed.";
					}
				}
				else
				{
					echo 'There was an error.';
					$showform = true;
				}
			}
			else
			{
				
				echo 'user not found';
				$showform = true;
			}
		}
	}
	
	if ($showform)
	{?>
		<form name="changePassword" action="changePassword.php" method="POST">
		<h2><a>
		Current Password: <input type="text" name="currentPassword" id = "currentPassword" value= "<?=$currentPassword=""?>"><br />
		New Password: <input type="password" name="newPassword" id ="newPassword" value="<?=$newPassword=""?>"><br />
		Confirm Password: <input type="password" name="confirmPassword" id = "confirmPassword" value="<?=$confirmPassword=""?>">
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