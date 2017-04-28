<?php
include_once ('constants.inc');


function GetCurrentSeason()
{
/*
	$month = date('n');
	$year = date('Y');
			
	if ($month <6)
	{
		$year--;
	}
	return $year;	
*/
   return CurrentSeason;

}

function GetGameByID($season, $gameId)
{
	$folder = GAMESPATH . $season . '/';
	
	if (file_exists($folder . $gameId . '.txt'))
	{
		$contents = file_get_contents($folder . $gameId . '.txt');
		$info = explode('|', $contents);
		
		return $info;		
	}
	
}

function GetGameByWeekAndTeams($season, $week, $team1, $team2)
{
		
	$files = scandir(GAMESPATH . $season . '/');
	
	foreach ($files as $file)
	{
		if ($file == '.' || $file == '..')
		{
			continue;
		}
		
		$contents = file_get_contents(GAMESPATH . $season . '/' . $file);
		list($fileWeek, $fileTeam1, $fileTeam2, $gameId, $winningTeam) = explode('|',$contents);
		
		if ($week != $fileWeek){continue;}
		
		if (($fileTeam1 == $team1 && $fileTeam2 == $team2) || ($fileTeam2 == $team1 && $fileTeam1 == $team2))
		{
			$info = explode('|', $contents);
			
			return $info;
		}
	}
	return null;
}

function GetAllGamesBySeason($season)
{
	$files = scandir(GAMESPATH . $season . '/');
	$games = array();
	
	foreach ($files as $file)
	{
		if ($file == '.' || $file == '..')
		{
			continue;
		}
		
		$contents = file_get_contents(GAMESPATH . $season . '/' . $file);
		$info = explode('|', $contents);
		
		$games[] = $info;		
	}
	
	if(count($games))
	{
		usort($games, "CompareGames");
		return $games;
	}
	return null;
}

function CompareGames($a,$b)
{
	if ($a[0] == $b[0])
	{
        return 0;
    }
    return ($a[0] < $b[0]) ? -1 : 1;
}

function SaveGame($season, $gameId, $gameInfo)
{
	$gamesPath = GAMESPATH . $season . '/';
	
	if(!file_exists($gamesPath))
	{
		mkdir($gamesPath);
	}
	
	$data = implode('|', $gameInfo);
	
	$file = $gameId . '.txt';
			
	if (file_put_contents($gamesPath . $file, $data))
	{
		return true;
	}

	return false;
	
}
?>