<?php
include_once ('../../../code/select_boxes.inc');
include_once ('../../../code/menu.inc');
include_once ('../../cookie/cookies.inc');
include_once ('../../../code/teams.inc');
include_once ('../../../code/user.inc');
include_once ('../../../code/games.inc');
include_once ('../../../code/stats.inc');
?>



<html>
<head><title>Edit Stats</title>
<link rel="stylesheet" type="text/css" href="../../css/common.css"></link>
</head>
<body>


<?php
include_once ('../../../code/header.inc');
createMenu(IsLoggedIn());

$showForm1 = true;
$showForm2 = false;
$gameTeam1='';
$gameTeam2='';
$season = GetCurrentSeason();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if ($_POST['step'] == '1')
	{
		$gameID = $_POST['games'];
		
		if ($gameID == '')
		{
			$showForm1 = true;
			echo "You must select a game.";
			echo '<br /><br />';
		}
		else
		{
			$showForm1 = false;
			echo '<br />';
						
			$gameInfo = GetGameByID($season,$gameID);
			
			$gameWeek = $gameInfo[0];
			$gameTeam1 = $gameInfo[1];
			$gameTeam2 = $gameInfo[2];
			$gameWinner = $gameInfo[4];
	
			$playerStats = getStatsByGame($season, $gameID);
					
			$showForm2 = true;		
		}
	}
	else //Step 2
	{
		$showForm1 = false;
		$showForm2 = false;		
		$gameID = $_POST['gameId'];
		$gameInfo = GetGameByID($season,$gameID);
		$gameWeek = $gameInfo[0];
		$gameTeam1 = $gameInfo[1];
		$gameTeam2 = $gameInfo[2];
		$gameWinner = $gameInfo[4];
				
		
		$teamTdTotals = UpdateStats ($season, $gameWeek, $gameTeam1, $gameTeam2, $gameID);
		
		$gameStats = array ($gameWeek, $gameTeam1, $gameTeam2, $gameID); 
		
		if ($teamTdTotals[0] == 11)
		{	
			$gameStats[4] = $gameTeam1;
			UpdateGame($season, $gameID, $gameStats);
			echo 'Your stats have been updated.';
			
		}
		elseif ($teamTdTotals[1] == 11)
		{
			$gameStats[4] = $gameTeam2;
			UpdateGame($season, $gameID, $gameStats);
			echo 'Your stats have been updated.';
		}
		else
		{
			echo 'Neither teams Touchdowns equal 11';
			$showForm2 = true;
		}
			
	}

	
}


if ($showForm1)
{?>
	<form name= "form1" action= "index.php" method= "POST">
	<a><table>
	<tr>Select Game: <?php echo createGamesSelectBox(GetCurrentSeason())?></tr><br /><br />
	<input type="hidden" name="step" value="1">
	<tr><input type="submit" value="Next"></tr>
	</a>
	</form>
	<?php
}


if ($showForm2)
{?>
	<br /><br />
	<form name= "form2" action= "index.php" method= "POST">
	<a><table>
	<input type="hidden" name="step" value="2">
	<input type="hidden" name="gameId" value = "<?=$gameID?>">
	<?php createStatForm($gameTeam1, $gameTeam2, $season, $gameID); 	?>
	<tr><input type="submit" value="submit"></tr>
	</a>
	</form>
<?php	
}

?>





</body>
</html>