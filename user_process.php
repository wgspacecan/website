<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<?php
    include("users.php");
    $users = new Users();
    $pass = $users->verify();
    $result = $users->process();
?>

<div class="topnav">
    <a href='index.php'>Home</a>
    
    <?php
    if($pass) {
        echo "<a href='info.php'>Info</a>";
        echo "<a href='user_logout.php'>Logout</a>";
    } else {
        echo "<a class='active' href='user_login.php'>Login</a>";
    }
    ?>

</div> 

<?php

echo $result;

?>

</body>
</html> 