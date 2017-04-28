<?php
include_once ('admin.inc');
include_once ('constants.inc');

function createMenu($IsLoggedIn, $HomePage = FALSE)
{


   $MenuString = '<p class = "menu">';
   
   if (!$HomePage)
   {
      $MenuString .= '<a class="menulink" href="' . SITEBASEURL . '/index.php">Home</a>&nbsp;|&nbsp;';
   }
        
   
   if ($IsLoggedIn)
   {
      $MenuString .= '<a class="menulink" href="' . SITEBASEURL . '/viewStats/">Player Stats</a>&nbsp;|&nbsp;';
	  $MenuString .= '<a class="menulink"  href="' . SITEBASEURL . '/games/">Games Played</a>&nbsp;|&nbsp;';
	  $MenuString .= '<a class="menulink" href="' . SITEBASEURL . '/myAccount/index.php">My Account</a>';
   }
   else
   {
    $MenuString .= '<a class="menulink" href="' . SITEBASEURL . '/login/index.php">Login</a>&nbsp;|&nbsp;<a class="menulink" href="' . SITEBASEURL . '/register/index.php">Register</a>';           
   }
   
   if (IsAdmin())
	{

		$MenuString .= '&nbsp;|&nbsp;<a class="menulink" href="' . SITEBASEURL . '/admin/index.php">Admin</a>';
	}
   

	

   $MenuString .= '</p>';
   
  
   echo $MenuString;

}

?>