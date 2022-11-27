<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div class="topnav">
    <a href='index.php'>Home</a>
    
    <?php
    if(isset($_COOKIE["wg_login"])) {
        echo "<a href='info.php'>Info</a>
                <a class='active' href='logout.php'>Logout</a>";
    } else {
        echo "<a href='login.php'>Login</a>";
    }
    ?>

    <?php
    if(isset($_COOKIE["wg_login"])) {
        echo "Welcome " . $_COOKIE["wg_login"];
    }
    ?>
</div> 

<?php

include("users.php");

$users = new Users();
if ($users->logout()) {
    echo "Logged out";
} else { echo "Not logged in"; }

?>

</body>
</html> 