<?php
include_once ('../../code/menu.inc');
include_once ('../../code/admin.inc');
include_once ('../cookie/cookies.inc');
?>

<html>
<head><title>Admin Page</title>
<link rel="stylesheet" type="text/css" href="../css/common.css"></link>
</head>
<body>

<?php
$loggedIn = IsLoggedIn();
include_once ('../../code/header.inc');
createMenu($loggedIn);
?>

<a href="../admin/enter_stats/index.php">Enter Stats</a><br /><br />
<a href="../admin/edit_stats/index.php">Edit Stats</a><br /><br />
<a href="../admin/perform_trade/index.php">Perform Trade</a><br /><br />
<a href="../admin/view_user_info/index.php">View User Info</a><br /><br />
</body>
</html>