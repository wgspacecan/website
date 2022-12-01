<?php
    include("backend_users.php");
    $users = new Users();
    $pass = $users->verify();
    
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div class="topnav">
    <a class='active' href='index.php'>Home</a>
    
    <?php
    if($pass) {
        echo "<a href='info.php'>Info</a>";
        echo "<a href='blog.php'>Blog</a>";
        echo "<a href='user_logout.php'>Logout</a>";
    } else {
        echo "<a href='user_login.php'>Login</a>";
    }
    ?>
</div> 

<h1>Home</h1>

<?php

    if($pass) {
        echo "Welcome " . $pass . ". Your secret for this session is " . $_COOKIE["spacepanda_login"];
    }
?>

</body>
</html> 
