<?php
include("backend/backend_users.php");
$users = new Users();
$users->logout();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

<div class="topnav">
    <a href='index.php'>Home</a>
    <a href='user_login.php'>Login</a>
</div> 

<p>Logged Out</p>

</body>
</html>