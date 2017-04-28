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
<head><title>Enter Stats</title>
<link rel="stylesheet" type="text/css" href="../../css/common.css"></link>

<style>

td {color:black; font-weight:bold;}

</style>

<script type="text/javascript">


var team1Total = 0;
var team2Total = 0;

var team1PlayerNames = new Array();
var team2PlayerNames = new Array();

var scoringFieldNames = new Array();

<?php

foreach ($ScoringPlayFields as $Key=>$Field)
{
	echo 'scoringFieldNames[' . $Key . '] = \'' . $Field . '\';' . "\n";
}

?>


function ValidateForm()
{
	team1Total = 0;
	team2Total = 0;

	//Loop over scoring field names
	for (var i=0; i < scoringFieldNames.length; i++)
	{
		var prefix = scoringFieldNames[i];

		//Loop over team 1 players
		for (var j=0; j < team1PlayerNames.length; j++)
		{
			var fieldName = prefix + '_' + team1PlayerNames[j];

			team1Total += Number(document.getElementsByName(fieldName)[0].value);
		}
		
		//Loop over team 2 players
		for (var j=0; j < team2PlayerNames.length; j++)
		{
			var fieldName = prefix + '_' + team2PlayerNames[j];
			team2Total += Number(document.getElementsByName(fieldName)[0].value);
		}		
	}
	
	if (team1Total != 11 && team2Total != 11)
	{
	   alert('Neither Team has a score of 11');
	   return false;
	}
	
	if (team1Total == 11 && team2Total == 11)
	{
	   alert('Both Teams have a score of 11');
	   return false;
	}
	
	if (team1Total > 11)
	{
		alert ('Team 1 total is greater than 11');
		return false;
	}
	
	if (team2Total > 11)
	{
		alert ('Team 2 total is greater than 11');
		return false;
	}	
	
	return true;
}

</script>


</head>
<body>


<?php
include_once ('../../../code/header.inc');
createMenu(IsLoggedIn());



$showStep1 = true;
$showStep2 = false;
$season = GetCurrentSeason();
$team1Name = 'team1';
$team2Name = 'team2';
$team1='';
$team2='';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if ($_POST['step'] == '1')
	{
		$week = $_POST['week'];
		$team1 = $_POST['team1'];
		$team2 = $_POST['team2'];
		

		
		if ($week == '' || $team1 == '' || $team2 =='')
		{
			$showStep1 = true;
			echo "Please complete the form.";
			echo '<br /><br />';
		}
		else if ($team1 == $team2)
		{
			$showStep1 = true;
			echo "You must select different teams.";
			echo '<br /><br />';
		}
		else
		{
			$showStep1 = false;
			echo '<h2>Week: ' . $week . '</h2>';
			$showStep2 = true;
			
		}
		
		echo "\n\n";
		echo '<script type="text/javascript">' . "\n";
		
		$team1Players = getPlayersByTeam($team1);
		$team2Players = getPlayersByTeam($team2);
		
		foreach ($team1Players as $key=>$name)
		{
			echo 'team1PlayerNames[' . $key . '] = \'' . $name . '\';' . "\n";			
		}
		
		foreach ($team2Players as $key=>$name)
		{
			echo 'team2PlayerNames[' . $key . '] = \'' . $name . '\';' . "\n";			
		}
		
		echo '</script>';		
		echo "\n\n";
	}
	
	else //$_POST['step'] == '2'
	{
		
		$showStep1 = false;
		
		if (validateStep2())
		{
			$showStep2 = false;
			
			$week = $_POST['week'];
		    $team1 = $_POST['team1'];
		    $team2 = $_POST['team2'];
			
			$gameID = time();
			
			
					
			$gameData = array($week, $team1, $team2, $gameID, 0, 0,0);
			
			if(SaveGame($season,$gameID, $gameData))
			{
				if(!processStats($week,$team1,$team2,$gameID))
				{
					die('error processing stats');
				}
								
				echo 'Step 2 done';
			}
			else
			{
				die('error saving game file');
			}
		}
		else
		{
			$showStep2 = true;
			echo 'step 2 error';
		}
		
		
		
	}
		
	
	
	
}

if ($showStep1)
{?>
	<form name= "form1" action= "index.php" method= "POST">
	<table>
	<tr>Pick Week <select name="week"><option value="">Please Select</option><option value="1">1</option><option value="2">2</option>
	<option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>
	<option value="8">8</option><option value="9">9</option><option value="10">10</option></tr><br /><br />
	<tr>Select Team 1<?php echo createTeamsSelectBox($season,$team1,$team1Name)?></tr><br /><br />
	<tr>Select Team 2<?php echo createTeamsSelectBox($season,$team2,$team2Name)?></tr><br /><br />
	<input type="hidden" name="step" value="1">
	<tr><input type="submit" value="Next"></tr>	
	</form>
	<?php
}

if ($showStep2)
{?>
	<br /><br />
	<form name= "form2" action= "index.php" method= "POST">
	<table>
	<input type="hidden" name="step" value="2">
	<input type="hidden" name="week" value = "<?=$week?>">
	<input type="hidden" name="<?=$team1Name?>" value = "<?=$team1?>">
	<input type="hidden" name="<?=$team2Name?>" value = "<?=$team2?>">
	<?php createStatForm($team1, $team2); 	?>
	<tr><input type="submit" value="submit" onclick="return ValidateForm();"></tr>
	</form>
<?php	
}

function validateStep2()
{

	return true;
}

?>
</body>
</html>








