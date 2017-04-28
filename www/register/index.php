<?php
include_once ('../../code/select_boxes.inc');
include_once ('../cookie/cookies.inc');
include_once ('../../code/menu.inc');
include_once ('../../code/user.inc');
include_once ('../../code/constants.inc');
include_once ('../../code/games.inc');



function HTMLHeader()
{
   echo '<html><head><title>Register</title><link rel="stylesheet" type="text/css" href="../css/common.css"></head><body>';
}


$loggedIn = IsLoggedIn();


if ($loggedIn)
{
   HTMLHeader();
   include_once ('../../code/header.inc');
   createMenu($loggedIn);
   echo 'You are already logged in as ' . $_COOKIE['user'];
}
else
{

$FirstName = '';
$LastName = '';
$Username = '';
$Password = '';
$email = '';
$Team = '';
$inviteCode= '';
$season = GetCurrentSeason();
$UsernameMinChars = UsernameMinLength;
$UsernameMaxChars = UsernameMaxLength;

$ShowForm = TRUE;

$Error = FALSE;

//The form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   //Get the form data and put it into variables
   $FirstName = trim($_POST['firstname']);
   $LastName = trim($_POST['lastname']);   
   $Username = strtolower(trim($_POST['username']));
   $Password = md5(trim(strtoupper($_POST['password'])));
   $email = trim($_POST['email']);
   $Team = trim($_POST['teams']);
   $inviteCode = trim($_POST['inviteCode']);
   
   //Validate the form data
   if (empty($FirstName) || empty($LastName) || empty($Username) || empty($Password) || empty($Team) || empty($email))
   {
       HTMLHeader();
       include_once ('../../code/header.inc');
       createMenu($loggedIn);
	   
       echo 'Some data is missing. Please complete all fields.<br />';	   
       $Error = TRUE;
   }

   if (strlen($Username) < $UsernameMinChars || strlen($Username) > $UsernameMaxChars)
   {
       HTMLHeader();
       include_once ('../../code/header.inc');
       createMenu($loggedIn);
       
       echo  'Username must be between ' . UsernameMinLength . ' and ' . UsernameMaxLength . ' characters.<br />';
       $Error = TRUE;
   }	 

   if (!ctype_alnum($Username) )
   {
       HTMLHeader();
       include_once ('../../code/header.inc');
       createMenu($loggedIn);
       
       echo 'Username must be alphanumeric characters only.<br />';
       $Error = TRUE;
   }	   
  
   $AccountsPath = '../../accounts';
   $UsernameFile = $AccountsPath . '/' . $Username . '.txt';
      
   if (file_exists($UsernameFile) )
   {
       HTMLHeader();
       include_once ('../../code/header.inc');
       createMenu($loggedIn);   
    
       echo 'Sorry, that username already exists!<br />';
       $Error = TRUE;
   }
	
	
		
    if (!ValidCode($inviteCode))
    {
        HTMLHeader();
        include_once ('../../code/header.inc');
        createMenu($loggedIn);	
            
        echo 'You entered the wrong invite code.';
        echo $inviteCode;
        print_r($inviteCodes);
        $Error = true;
    }

   
   if (!$Error) //No errors happened
   {
	  $ShowForm = FALSE;  
	  
	  $AccountData = array('firstname'=>$FirstName,'lastname'=>$LastName, 'password'=>$Password, 'team'=>$Team, 'email'=>$email, 'teamseason'=>$season);
	  
	  
	  if (updateUserData ($Username, $AccountData) <=0)
	  {
             HTMLHeader();
             include_once ('../../code/header.inc');
             createMenu($loggedIn);	 
             
	     echo 'There was an error saving your account information. Please try again.<br />';
	     $ShowForm = TRUE;
	  }
	  else
	  {
  	      Login($Username);
  	      
              HTMLHeader();
              include_once ('../../code/header.inc');
              createMenu($loggedIn);	  
              
	      echo 'Thank You. Your account has been created.';
		  echo '<script>window.location="../myAccount/index.php"</script>';
		
	  }
   }
   
}
else
{
   HTMLHeader();
   include_once ('../../code/header.inc');
   createMenu($loggedIn);
}





   if ($ShowForm){
?>	   

<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<table border = "0" cellspacing = "4" >
<tr><td>First Name:</td><td width = "10"></td><td><input type = "text" name = "firstname" id = "firstname" value="<?= $FirstName ?>" onblur="if(this.value == ''){alert('First Name must not be empty.');}"></td></tr>
<tr><td>Last Name:</td><td width = "10"></td><td><input type = "text" name = "lastname" id = "lastname" value="<?= $LastName ?>"></td></tr>
<tr><td>User Name:</td><td width = "10"></td><td><input type = "text" name = "username" id = "username" value="<?= $Username ?>"></td></tr>
<tr><td>Password:</td><td width = "10"></td><td><input type = "password" name = "password" id = "password" value="<?= '' ?>"></td></tr>
<tr><td>Email:</td><td width = "10"></td><td><input type = "text" name = "email" id = "email" value="<?= $email ?>"></td></tr>
<tr><td>Team:</td><td width = "10"></td><td><?php echo createTeamsSelectBox($season, $Team) ?></td></tr>
<tr><td>Invite Code:</td><td width = "10"></td><td><input type = "text" name = "inviteCode" id = "inviteCode" value="<?= $inviteCode ?>"></td></tr>
<tr><td colspan = "2"></td><td align = "right"><input type= "submit" name = "submit" id = "submit"></td></tr>
</table> 
</form>

<?php
   }
}


function ValidCode($code)
{
	global $inviteCodes;
	
	if (array_search($code, $inviteCodes) == $code)
	{
		return true;
	}
	return false;
}

?>


</body>
</html>
