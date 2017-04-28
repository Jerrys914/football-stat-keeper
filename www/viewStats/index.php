<?php
include_once ('../../code/select_boxes.inc');
include_once ('../cookie/cookies.inc');
include_once ('../../code/menu.inc');
include_once ('../../code/user.inc');
include_once ('../../code/constants.inc');
include_once ('../../code/games.inc');
include_once ('../../code/stats.inc');
?>

<html>
<head><title>Player Stats</title>

<link rel="stylesheet" type="text/css" href="../css/common.css">

<script type="text/javascript">

function SetSort(SortVal)
{
	document.getElementById('sort').value=SortVal;
	document.getElementById('statsform').submit();	
}


</script>

<style>
td {color:black; font-weight:bold;}
</style>

</head>
<body>


<?php
include_once ('../../code/header.inc');
$loggedIn = IsLoggedIn();

createMenu($loggedIn);

$currentSeason = $season = GetCurrentSeason();
$sort = 'playername';
$week = 'All';
$team = 'All';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$season = $_REQUEST['Season'];
	$sort = $_REQUEST['sort'];
	$week = $_REQUEST['week'];
	$team = $_REQUEST['teams'];
}

?>

<form method="POST" name="statsform" id="statsform" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<?php echo 'Season:'; echo CreateSeasonsSelectBox($season,$currentSeason); ?>&nbsp;&nbsp;
<input type = "hidden" id="sort" name="sort" value="<?=$sort?>">
<?php echo 'Team:'; echo CreateTeamsSortBox($season,$team); ?> &nbsp;&nbsp;
<?php echo 'Time Frame:'; echo CreateWeekSelectBox($week); ?>
<input type="submit" name="enter" value="Enter">
</form>
<br /><br />

<?php


$userNames = GetUsersByTeamAndWeek($season, $team, $week);




global $statsList;

echo '<table border="1"><tr>';

echo '<td><nobr><a href="javascript:SetSort(\'playername\')">Player Name</a></nobr></td>';

foreach($statsList as $stat)
{
	echo '<td><nobr>';

	
	if ($stat[1] == $sort)
	{
		echo '<strong>';
	}
	
	echo '<a href="javascript:SetSort(\''.$stat[1].'\')">';
	echo $stat[0]; 
	echo '</a>';
	
	if ($stat[0] == $sort)
	{
		echo '</strong>';
	}
	
	echo '</nobr></td>';
}

echo '</tr>';
$allStatRows = array();

foreach ($userNames as $user)
{
	if ($week == 'All')
	{
	   $playerStats = GetStatTotalsByUser($season, $user);
	}
    else
	{
		$AllUserStats = GetStatsByUser($season, $user);
		
		$playerStats = array();
		
		foreach($AllUserStats as $statRow)
		{
		   if ($statRow['week'] == $week)
		   {
			   $playerStats = $statRow;
			   break;
		   }
		}
	}
	$info = getUserData($user);
	$playerStats['playername'] = $info['lastname'] . $info['firstname'];
	$playerStats['displayname'] = $info['firstname'] . ' ' . $info['lastname'];
	$allStatRows[] = $playerStats;
}	

usort($allStatRows, 'sortStatRows');

function sortStatRows($a, $b)
{
	global $sort;
	
	if ($a[$sort] == $b[$sort]) 
	{
        return 0;
    }
	
	if ($sort == 'playername')
	{
		return ($a[$sort] < $b[$sort]) ? -1 : 1;
	}
	else
	{
		 return ($a[$sort] < $b[$sort]) ? 1 : -1;
	}
   
}


foreach ($allStatRows as $playerStats)
{
	echo '<tr>';
	

	
	echo '<td style="background-color:white">' . $playerStats['displayname'] . '</td>';
	
	$statsRow = DisplayStatsRow($playerStats);
	echo $statsRow;
	
	echo '</tr>';
}

echo '</table>';


?>
</body>
</html>
