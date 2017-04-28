<?php
include_once ('constants.inc');
include_once ('user.inc');


function getPLayersByTeam($teamName)  //returns usernames
{
	$players = array();
	
	
	$files = scandir(ACCOUNTSPATH);
	
	foreach ($files as $file)
	{
		if ($file == '.' || $file == '..')
		{
			continue;
		}
		
		$contents = getUserData(substr($file,0,-4));

		
		if ($contents['team'] == $teamName)
		{
			$players[] = substr($file,0,-4);
		}
		
	}

	return $players;
}


?>