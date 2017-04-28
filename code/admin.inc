<?php
include_once ('constants.inc');


function IsAdmin()
{
	global $adminUsers;
	
	if (isset($_COOKIE['user']))
	{
		if (in_array($_COOKIE['user'], $adminUsers))
		{
			return true;
		}
	}
	else
	{
		return false;
	}
}
?>