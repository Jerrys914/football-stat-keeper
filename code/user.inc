<?php
include_once ('constants.inc');



function userExists ($username)
{

	$file = ACCOUNTSPATH . '/' . $username . '.txt';
	
	if (file_exists($file) )
	{	
		return true;
	}
	else
	{
	   return false;	
	}
}

function getUserData ($username)
{

	$file = ACCOUNTSPATH . '/' . $username . '.txt';
	
	if (userExists($username))
	{
		$Line = file_get_contents($file); //Read the file contents into the $Line variable
				
		if ($Line === FALSE) //A file read error happened
		{
			return -1; 
		}
		else
		{
			$info = unserialize($Line);
			
			return $info;
		}
	}
	else
	{
		return -2; //user not found
	}
}

function updateUserData ($username, $userData)
{

	$file = ACCOUNTSPATH . '/' . $username . '.txt';
	
	
		if (is_array($userData))
		{
			$data = serialize($userData);
			
			if (file_put_contents($file, $data))
			{
				return 1;
			}
			return 0;
		}
		else
		{
			return -1;
		}
}

function GetUsersByTeamAndWeek($season, $team, $week)
{
	$seasonPath = STATSPATH . $season . '/';
	$files = scandir($seasonPath);
	
	$users = array();
	
	foreach ($files as $file)
	{
		if ($file == '.' || $file == '..')
		{
			continue;
		}
		
		list($userName) = explode('_', $file);
		$contents = file_get_contents($seasonPath . $file);
		$info = unserialize($contents);
		
		$fileWeek = $info['week'];
		$fileTeam = $info['team'];
		
		$weekMatches = false;
		$teamMatches = false;
		
		if($team == $fileTeam || $team == 'All')
		{
			$teamMatches = true;
		}
		
		if($week == $fileWeek || $week == 'All')
		{
			$weekMatches = true;
		}
		
		if ($weekMatches && $teamMatches)
		{
			$users[$userName] = $userName;
		}
		
		
	}
	
	return $users;
}
?>