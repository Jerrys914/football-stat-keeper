<?php
include_once ('../../../code/select_boxes.inc');
include_once ('../../../code/menu.inc');
include_once ('../../cookie/cookies.inc');
include_once ('../../../code/teams.inc');
include_once ('../../../code/user.inc');
include_once ('../../../code/constants.inc');
include_once ('../../../code/games.inc');
include_once ('../../../code/stats.inc');
?>



<html>
<head><title>Perform Trade</title>
<link rel="stylesheet" type="text/css" href="../../css/common.css"></link>
</head>
<body>


<?php
include_once ('../../../code/header.inc');
createMenu(IsLoggedIn());
$showform1 = true;
$showform2 = false;
$season = GetCurrentSeason();
$team1='';
$team2='';
$team1Name= 'team1';
$team2Name= 'team2';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if ($_POST['step'] == '1')
	{
		$team1 = $_POST['team1'];
		$team2 = $_POST['team2'];
		
		if ($team1 == $team2)
		{
			$showform1 = true;
			echo 'You must select different teams.';
		}
		else
		{
			$showform1 = false;
			$showform2 = true;
		}
	}
	
	if ($_POST['step'] == '2')
	{
		$showform1 = false;
		$showform2 = false;
		$player1 = $_POST['user1'];
		$player1Team = $_POST['teamA'];
		$player2 = $_POST['user2'];
		$player2Team = $_POST['teamB'];
		
		$player1NewTeam = $player2Team;
		$player2NewTeam = $player1Team;
		
		$infoPlayer1 = getUserData($player1);
		$infoPlayer2 = getUserData($player2);
		
		$infoPlayer1['team'] = $player1NewTeam;
		$infoPlayer2['team'] = $player2NewTeam;
		
		if(!updateUserData($player1, $infoPlayer1))
		{
			echo 'Error occurred saving';
		}
		else if(!updateUserData($player2, $infoPlayer2))
		{
			echo 'Error occurred saving';
		}
		else
		{
			echo 'The trade has been completed.';
		}
		
		
	}
}

if ($showform1)
{
?>
<form name= "form1" action= "index.php" method= "POST">
<a><table>
<tr>Select Team 1<?php echo createTeamsSelectBox($season,$team1,$team1Name)?></tr><br /><br />
<tr>Select Team 2<?php echo createTeamsSelectBox($season,$team2,$team2Name)?></tr><br /><br />
<input type="hidden" name="step" value="1">
<tr><input type="submit" value="Next"></tr>
</a>
</form>
<?php
}

if ($showform2)
{
?>
<form name= "form1" action= "index.php" method= "POST">
<a><table>
<tr>Select Player from Team 1:<?php echo createUserSelectBox('user1', $team1)?></tr><br /><br />
<tr>Select Player from Team 2:<?php echo createUserSelectBox('user2', $team2)?></tr><br /><br />
<input type="hidden" name="step" value="2">
<input type="hidden" name="teamA" value="<?=$team1?>">
<input type="hidden" name="teamB" value="<?=$team2?>">
<tr><input type="submit" value="Next"></tr>
</a>
</form>
<?php
}




?>


</body>
</html>
