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
                <a href='logout.php'>Logout</a>";
    } else {
        echo "<a class='active' href='login.php'>Login</a>";
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

echo $users->process();

?>

<h1>Login </h1>
<p>Enter user information</p>

<form action="/login.php" method="post">
    <label for="fname">username:</label><br>
    <input type="text" id="usr" name="usr"><br>
    <label for="pass">password:</label><br>
    <input type="password" id="pswd" name="pswd"><br><br>
    <input type="submit" name="login" value="Login">
    <input type="submit" name="create" value="Create"><br>
</form>

</body>
</html> 