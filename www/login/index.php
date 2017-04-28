<?php
include_once ('../cookie/cookies.inc');
include_once ('../../code/menu.inc');
include_once ('../../code/user.inc');


function HTMLHeader()
{
   echo '<html><head><title>Login Form</title><link rel="stylesheet" type="text/css" href="../css/common.css"></head><body>';	
}


    
	$loggedIn = IsLoggedIn();

	

	if (isset ($_REQUEST['logout']))
	{
		Logout();	
		$loggedIn = false;
	}

	if ($loggedIn)
	{
	   HTMLHeader();
	   include_once ('../../code/header.inc');
	   createMenu(false);
	   
	   echo 'You are already logged in as ' . $_COOKIE['user']; 
	   echo "<br /><br />";
	   echo 'Do you want to <a href= "index.php?logout=1">Logout</a>';
	}
	else //Not logged in
	{
		$Username = "";
		$password = "";
		$showForm = true;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			   $SubmittedUserName = strtolower(trim($_POST['username']));
			   $SubmittedPassword = md5(trim(strtoupper($_POST['password'])));
			   
			   //echo 'Form was submitted<br /><br />';
			   //echo 'You entered username: ' . $SubmittedUserName . '<br />';
			   //echo 'You entered password: ' . $SubmittedPassword;

			   //echo '<br /><br />';
			   
			   //Open the login info file to compare username and password to what's stored.
			  $info = getUserData($SubmittedUserName);
			   
			   //Check if the file exists
			   if (is_array($info))
			   {
				  $StoredPassword = $info['password'];
				  
				  //Compare submitted values to stored values
				  if (CompareStrings($SubmittedPassword, $StoredPassword, true) ) 
				  {					 
					 Login($SubmittedUserName);
					 HTMLHeader();
					 include_once ('../../code/header.inc');
					 createMenu(false);
					 echo 'You are logged in';
					 $showForm = false;
				  }
				  else
				  {
					 HTMLHeader();
					 include_once ('../../code/header.inc');
					 createMenu(false); 
					 echo 'Incorrect username or password';
					 echo '<br /><br />';
				  }				  
			   }
			   else
			   {
				   HTMLHeader();
				   include_once ('../../code/header.inc');
				   createMenu(false);
				   echo 'Incorrect username or password';
			   }			   
		  }
		  else
		  {
			  HTMLHeader();
			  include_once ('../../code/header.inc');
			  createMenu(false); 
		  }
		  
		  if($showForm) //Form not submitted
		  {?>
			  <form name="Login" action="index.php" method="POST">
			  <table border = "0" cellspacing = "4" >
				<tr><td>Enter Username:</td><td><input type="text" name="username" value= "<?=$Username?>"></td></tr>
				<tr><td>Enter Password:</td><td><input type="password" name="password" value="<?=$password?>"></td></tr>
				<tr><td align="right" colspan="2"><input type="hidden" name="form" value="1"><input type="Submit" value="Login"></td></tr>				
				</table>
				</form>
				<?php
		  }
		  else
		  {
			  echo '<script>window.location="../myAccount/index.php"</script>';
		  }
	   
	   
	}



	function CompareStrings($string1, $string2, $CaseSensitive = TRUE)
	{
		if(!$CaseSensitive)
		{
		   if (strtoupper($string1) == strtoupper($string2))
		   {
			   return TRUE;
		   }
		
			return FALSE;
		}
		else
		{
		   if ($string1 == $string2)
		   {
			   return TRUE;
		   }
		
			return FALSE;
		}	
		
		
		
	}
?>




</body>
</html>




