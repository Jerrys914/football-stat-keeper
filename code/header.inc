<?php  
   include_once('constants.inc');
   include_once('games.inc');

   $CurrentSeason = getCurrentSeason();  
?>

<a href="<?= SITEBASEURL ?>">
<div style="background-image: url(<?= SITEBASEURL . '/images/football.jpg'; ?>); width:699px; height:144px; margin-left:auto; margin-right:auto;">
<h1>Football Stat Keeper</h1>
</div>
</a>

<div style="width:100%;">
<?= 'Current Season: ' . $CurrentSeason; ?>

<?php
if (IsLoggedIn() )
{
   $User = GetLoggedInUser();
   
   echo '<span style="float:right;">';
   echo 'Logged in as: ' . $User;
   echo '</span>';
}
?>

</div>