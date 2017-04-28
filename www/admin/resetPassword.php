<?php
include_once ('../cookie/cookies.inc');
include_once ('../../code/user.inc');
include_once ('../../code/menu.inc');
include_once ('../../code/admin.inc');
include_once ('../../code/select_boxes.inc');
?>

<html>
<head><title>Reset Password</title>
<link rel="stylesheet" type="text/css" href="../css/common.css"></link>
</head>
<body>


<?php
include_once ('../../code/header.inc');
$loggedIn = IsLoggedIn();
createMenu($loggedIn);

$newPassword = '';
$showform = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST' )
{
	$showform = false;
	$user = trim($_POST['users']);
	$newPassword = md5(trim(strtoupper($_POST['newPassword'])));
	
	if (userExists($user))
	{
		$info = getUserData ($user);
		
		$info['password'] = $newPassword;
		
		if(updateUserData ($user, $info))
		{
			echo "The ssers password has been reset.";
		}
		else
		{
			echo 'Error updating password';
		}
		
	}
}

		
if ($showform)
{?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<table border = "0" cellspacing = "4" width = "500">
<tr><td>Users:</td><td width = "10"></td><td><?php echo createUserSelectBox() ?></td></tr>
<tr><td>New Password:</td><td width = "10"></td><td><input type = "text" name = "newPassword" id = "newPassword" value="<?= $newPassword ?>"></td></tr>
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