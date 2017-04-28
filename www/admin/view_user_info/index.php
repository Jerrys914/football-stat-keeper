<?php
include_once ('../../../code/select_boxes.inc');
include_once ('../../../code/menu.inc');
include_once ('../../cookie/cookies.inc');
include_once ('../../../code/teams.inc');
include_once ('../../../code/user.inc');
include_once ('../../../code/games.inc');
include_once ('../../../code/stats.inc');
include_once ('../../../code/header.inc');


//<a href="../admin/resetPassword.php">Reset Password</a><br /><br />
?>



<html>
<head><title>View user Info</title>
<link rel="stylesheet" type="text/css" href="../../css/common.css"></link>
</head>
<body>


<?php
createMenu(IsLoggedIn());
$showform1 = true;
$showform2 = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' )
{
	if ($_POST['step'] == '1')
	{
		$showform1 = false;
		$user = trim($_POST['users']);

		$info = getUserData($user);
		
		echo 'User Name: ' . $user . '<br />';
		echo 'First Name: ' . $info['firstname'] . '<br />';
		echo 'Last Name: ' . $info['lastname'] . '<br />';
		echo 'Team: ' . $info['team'] . '<br />';
		echo 'Email: ' . $info['email'] . '<br /><br />';
		echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '"><input type= "submit" name = "ResetPassword" value="Reset Password">
		     <tr><td><input type="hidden" name="step" value="resetPassword"><td><tr>
			 <tr><td><input type="hidden" name="user" value="' . $user . '"><td><tr></form>';
	}
	
	if ($_POST['step'] == 'resetPassword')
	{
		$user = $_POST['user'];
		$showform1 = false;
		$showform2 = true;
		

	}
	
	if($_POST['step'] == '2')
	{
		$user = $_POST['user'];
		$showform1 = false;
		$showform2 = false;
		$newPassword = md5(trim(strtoupper($_POST['newPassword'])));
		
		if (userExists($user))
		{
			$info = getUserData ($user);
			
			$info['password'] = $newPassword;
			
			if(updateUserData ($user, $info))
			{
				echo "The users password has been reset.";
			}
			else
			{
				echo 'Error updating password';
			}
			
		}
		else{
			echo 'Error: ' . $user . 'Username not found.<br />';
	
		}
	}
}







if ($showform1)
{
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<table border = "0" cellspacing = "4" width = "500">
<tr><td>Select User:</td><td width = "10"></td><td><?php echo createUserSelectBox() ?></td></tr>
<tr><td><input type="hidden" name="step" value="1"><td><tr>
<tr><td colspan = "2"></td><td align = "right"><input type= "submit" name = "submit" id = "submit"></td></tr>
</table> 
</form>
<?php
}

if ($showform2)
{?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<table border = "0" cellspacing = "4" width = "500">
<tr><td>New Password:</td><td width = "10"></td><td><input type = "text" name = "newPassword" id = "newPassword" value=""></td></tr>
<tr><td><input type="hidden" name="step" value="2"><td><tr>
<tr><td><input type="hidden" name="user" value="<?=$user?>"><td><tr>
<tr><td colspan = "2"></td><td align = "right"><input type= "submit" name = "submit" id = "submit"></td></tr>
</table> 
</form>
<?php
}
?>
<br /><br />
<a href= "../index.php">Click to go back.<a/>
</body>
</html>
