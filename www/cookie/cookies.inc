<?php

function IsLoggedIn()
{
     if (isset($_COOKIE['user']) )
     {
          return true; //logged in
     }
     else
     {
         return false; //not logged in
     }
}

function Login($Username)
{
    setcookie('user', $Username, time()+32400, '/'); //expires in 9 hours   
}

function Logout()
{
    setcookie('user','',time()-3600, '/'); //delete the cookie
}

function GetLoggedInUser()
{
   if (IsLoggedIn() )
   {
      return ($_COOKIE['user']);
   }
   
   return '';
}

?>