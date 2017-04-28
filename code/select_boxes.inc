<?php
include_once('constants.inc');
include_once('games.inc');
include_once('user.inc');

function createTeamsSelectBox($season, $CurrentTeam, $Name = 'teams')
{
	global $teams;
	$seasonTeams = $teams[$season];
	
	$output = "\n\n" . '<select name = "' . $Name . '" id = "' . $Name . '">' . "\n";
	
	$output .= '<option value = ""> -Please Select-</option>' . "\n";
	
	foreach ($seasonTeams as $team)
	{
		$output .= '<option value = "' . $team . '"';
		
		if ($team == $CurrentTeam)
		{
		   $output .= ' SELECTED ';
		}
		
		$output .= '>' . $team . '</option>' . "\n";
		
		
	}

	
	$output .= '</select>' . "\n\n" ;

return $output;

}

function CreateSeasonsSelectBox($selectedSeason, $currentSeason)
{
	if($currentSeason >= $selectedSeason)
	{
		$season = $currentSeason;
		
		$output = "\n\n" . '<select name = "Season" id = "Season">' . "\n";
		
		while($season >= StartingSeason)
		{			
			$output .= '<option value = "' . $season . '"';
		
			if ($season == $selectedSeason)
			{
			   $output .= ' SELECTED ';
			}
		
			$output .= '>' . $season . '</option>' . "\n";
			$season--;
		}
		
		$output .= '</select>' . "\n\n" ;

		return $output;
	}
	return '';
}

function CreateWeekSelectBox($selectedWeek)
{
	$output = "\n\n" . '<select name = "week" id = "week">' . "\n";
	
	$output .= '<option value = "All">YTD</option>' . "\n";
	
	for ($i=1; $i<=10; $i++)
	{
		$output .= '<option value = "' . $i . '"';
		
		if ($i == $selectedWeek)
		{
		   $output .= ' SELECTED ';
		}
		
		$output .= '>' . $i . '</option>' . "\n";
	}
	
	$output .= '</select>' . "\n\n" ;

	return $output;
}

function CreateTeamsSortBox($season, $CurrentTeam, $Name = 'teams')
{
	global $teams;
	$seasonTeams = $teams[$season];
	
	$output = "\n\n" . '<select name = "' . $Name . '" id = "' . $Name . '">' . "\n";
	
	$output .= '<option value = "All">All Players</option>' . "\n";
	
	foreach ($seasonTeams as $team)
	{
		$output .= '<option value = "' . $team . '"';
		
		if ($team == $CurrentTeam)
		{
		   $output .= ' SELECTED ';
		}
		
		$output .= '>' . $team . '</option>' . "\n";
		
		
	}

	
	$output .= '</select>' . "\n\n" ;

return $output;

}

function createUserSelectBox($Name = 'users', $Team = NULL)
{
	
	$users = scandir(ACCOUNTSPATH);
	
	$output = "\n\n" . '<select name = "' . $Name . '" id = "' . $Name . '">' . "\n";
	
	$output .= '<option value = ""> -Please Select-</option>' . "\n";
	
	foreach ($users as $user)
	{
		if ($user == '.' || $user == '..')
		{
			continue;
		}
		
		if ($Team)
		{
			$user = substr($user, 0, -4);
			$info = getUserData($user);
			
			
			if($info['team'] == $Team)
			{
			
				$player = $user;
				
				$output .= '<option value = "' . $player . '"';
				$output .= '>' . $player . '</option>' . "\n";
		
			}
			else
			{
				continue;
			}
		}
		else
		{
			$user = substr($user, 0, -4);
			
			$output .= '<option value = "' . $user . '"';
			$output .= '>' . $user . '</option>' . "\n";
		}
		
	}

	
	$output .= '</select>' . "\n\n" ;

return $output;

}

function createGamesSelectBox ($season, $Name = 'games')
{
	$games = GetAllGamesBySeason($season);
	
	$output = "\n\n" . '<select name = "' . $Name . '" id = "' . $Name . '">' . "\n";
	
	$output .= '<option value = ""> -Please Select-</option>' . "\n";
	
	foreach ($games as $game)
	{
		$output .= '<option value = "' . $game[3] . '"';
				
		$output .= '>Week: ' . $game[0] . ' - Team 1: ' . $game[1] . ' - Team 2: ' . $game[2] . '</option>' . "\n";
	}
	
	$output .= '</select>' . "\n\n" ;
	
return $output;
}

?>