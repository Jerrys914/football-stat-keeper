<?php
include_once ('./cookie/cookies.inc');
include_once ('../code/menu.inc');
?>

<html>
<head><title>HomePage</title>
<link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
<?php
include_once ('../code/header.inc');
?>
<?php

  $IsLoggedIn = IsLoggedIn();
  createMenu($IsLoggedIn, TRUE);

?>
</body>
</html>
