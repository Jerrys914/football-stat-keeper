<?php
include_once ('constants.inc');
include_once ('games.inc');



////////////////////////////////////////////// ENTER STATS ////////////////////////////////////////////// 
 
function createStatForm($teamA, $teamB, $season = NULL, $gameID = NULL)
{
	$players1 = getPlayersByTeam($teamA);
	$players2 = getPlayersByTeam($teamB);
	
	echo '<h2>' . $teamA . '</h2><br />';
	
	foreach ($players1 as $player1)
	{
	   createStatRow($player1, $season, $gameID);
	}	
	
	echo '<h2>' . $teamB . '</h2><br />';
	
	foreach ($players2 as $player2)
	{
	   createStatRow($player2, $season, $gameID);
	}
	
}

function createStatRow($userName, $season = NULL, $gameID = NULL)
{	
	    global $statsList;
		 
		$info = getUserData($userName);
		
		if ($season && $gameID)
		{
		   $playerStats = GetStatsByUserAndGame($season, $userName, $gameID);
		}   
		
		$colors = array('white','#15BECE');

		echo '<b>' . $info['firstname'] . ' ' . $info['lastname'] . ':</b><br />' . "\n";
		
		echo '<table cellpadding="3" border="0" style="border: 1px solid black;">' . "\n";
		echo '<tr>';
		
		$cntr = 0;
		foreach ($statsList as $stat)
		{
			$bgcolor = $colors[$cntr % 2];
			
			$Value = 0;
			if (isset($playerStats) && isset($playerStats[$stat[1]]) )
			{
			   $Value = $playerStats[$stat[1]];
			}
			
			echo '<td style="background-color:' . $bgcolor . ';">' . $stat[0] .':</td><td style="background-color:' . $bgcolor . ';">' . "\n" . '<select name="' . $stat[1] . '_' . $userName . '">' . createStatOptions($stat[2], $Value) . '</select>' . "\n" . '</td><td width="10"></td>';
			$cntr++;
		}
		
		echo '</tr>' . "\n";
		echo '</table>' . "\n";
		
		echo '<br />';
}

function createStatOptions($Max, $DefaultValue = 0)
{
	$result = "\n";
	for ($i=0; $i<=$Max; $i++)
	{
		$result .= '<option value="' . $i . '"';   
		
		if ($DefaultValue == $i)
		{
		   $result .= ' SELECTED ';
		}
		
		$result .= '>' . $i . '</option>' . "\n";
	}
	return $result;
	
}

function processStats($week, $team1, $team2, $gameID)
{
	$season = GetCurrentSeason();
	$players1 = getPlayersByTeam($team1);
	$players2 = getPlayersByTeam($team2);
	$totalTD1 = 0;
	$totalTD2 = 0;
	
	
	$totalTD1 = processStatsByPlayer($players1, $week, $team1, $gameID);
	$totalTD2 = processStatsByPlayer($players2, $week, $team2, $gameID);

	
	$gamesPath = GAMESPATH . $season . '/';
	$gameFileName = $gameID . '.txt';
	$gameFile = $gamesPath . $gameFileName;
	
	if ($totalTD1 == 11)
	{
		$winningTeam = $team1;
	}
	else
	{
		$winningTeam = $team2;
	}	
	
	$gameData = array($week, $team1, $team2, $gameID, $winningTeam, $totalTD1, $totalTD2);
	
	if(!SaveGame($season, $gameID, $gameData))
	{
		return false;
	}
	return true;
}

function processStatsByPlayer($players, $week, $team, $gameID)
{
	$season = GetCurrentSeason();
	$statsPath = STATSPATH . $season . '/';	
	
	if (!file_exists($statsPath))
	{
		mkdir($statsPath);
	}
	
	$totalTD = 0;
	
	foreach ($players as $player)
	{
		global $statsList;
		global $ScoringPlayFields;
		
		$postedStats = array();
		
		foreach ($statsList as $stat)
		{
			$postedStats[$stat[1] ] = $_POST[$stat[1] . '_' . $player];
		}
		
		//$totalTD += $postedStats['ptd'] + $postedStats['rush_td'] + $postedStats['int_td'] + $postedStats['fr_td'];
		foreach ($ScoringPlayFields as $Field)
		{
		   $totalTD += $postedStats[$Field];
		}
		
		$statsFileName = $statsPath . $player . '_' . $gameID . '.txt';
		$statData = $week . '|' . $team . '|' . $gameID;
		$statData = array('week'=>$week, 'team'=>$team, 'gameID'=>$gameID);

        foreach ($statsList as $stat)
		{
			$statData[$stat[1]] = $postedStats[$stat[1]];
		}
				
		if (!file_put_contents($statsFileName, serialize($statData) ) )
		{
			return -1;
		}
	}
		
		return $totalTD;
		
	
}

////////////////////////////////////////////// GET STATS ////////////////////////////////////////////// 

function GetStatsByUserAndGame($season, $username, $gameId)
{
	$seasonPath = STATSPATH . $season . '/';
	$targetFile = $seasonPath . $username . '_' . $gameId . '.txt';
	
	if (file_exists($targetFile))
	{
		$contents = file_get_contents($targetFile);
		$info = unserialize($contents);
		
		if (count($info))
		{
			return $info;
		}
		return null;
	}
	
	return false;
}

function GetStatsByGame($season,$gameId)
{
	$seasonPath = STATSPATH . $season . '/';
	$files = scandir($seasonPath);
	
	$stats = array();
	
	foreach ($files as $file)
	{
		if (strpos($file, $gameId))
		{
			$contents = file_get_contents($seasonPath . $file);
			
			$info = unserialize($contents);
			
			$stats[] = $info;
						
		}
	}
	
	if (count($stats))
	{
		return $stats;
	}
	return null;
	
}

function GetStatsByUser($season, $username)
{
	$seasonPath = STATSPATH . $season . '/';
	$files = scandir($seasonPath);
	$stats = array();
	
	foreach ($files as $file)
	{
		if (strpos($file, $username) !== false)
		{
			$contents = file_get_contents($seasonPath . $file);
			
			$info = unserialize($contents);
			
			$stats[] = $info;
		}	
	}
	
	if (count($stats))
	{
		return $stats;
	}
	return null;
}

function GetStatTotalsByUser($season, $username)
{	
	global $statsList;
	
	$seasonPath = STATSPATH . $season . '/';
	$files = scandir($seasonPath);
	
	$totals = array();
	
	foreach ($files as $file)
	{
		if (strpos($file, $username) !== false)
		{
			$contents = file_get_contents($seasonPath . $file);
			
			$info = unserialize($contents);
						
			foreach ($statsList as $stat)
			{
				if (array_key_exists($stat[1], $totals))
				{
					$totals[$stat[1]] += $info[$stat[1]];
				}
				else
				{
					$totals[$stat[1]] = $info[$stat[1]];
				}
			}
		}	
	}
	
	if (count($totals))
	{
		return $totals;
	}
	return null;	
}

////////////////////////////////////////////// UPDATE STATS ////////////////////////////////////////////// 

function UpdateStats ($season, $week, $teamA, $teamB, $gameId)
{
	$players1 = getPlayersByTeam($teamA);
	$players2 = getPlayersByTeam($teamB);
	$totalTD1 = 0;
	$totalTD2 = 0;
	
	
	$totalTD1 = processStatsByPlayer($players1, $week, $teamA, $gameId);
	$totalTD2 = processStatsByPlayer($players2, $week, $teamB, $gameId);
	
	$teamTD = array($totalTD1, $totalTD2);
	
	return $teamTD;
}


function DisplayStatsRow($playerStats)
{
	global $statsList;
	
	$colors = array('#15BECE', 'white');

	$cntr = 0;
	
	$ret = '';
	
	foreach($statsList as $stat)
	{
		$col = $colors[$cntr % 2];
		
		$ret .= '<td style= "background-color:' . $col . '";>';
		$ret .= $playerStats[$stat[1]];		
		$ret .= '</td>';
		
		$cntr++;
	}
		
	
	return $ret;
}


?>