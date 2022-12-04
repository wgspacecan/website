<?php
include("backend_users.php");
$users = new Users();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div class="topnav">
    <a href='index.php'>Home</a>
    
    <?php
    $pass = $users->verify();
    if($pass) {
        echo "<a href='info.php'>Info</a>";
        echo "<a href='blog.php'>Blog</a>";
        echo "<a href='user_logout.php'>Logout</a>";
    } else {
        echo "<a class='active' href='user_login.php'>Login</a>";
    }
    ?>

</div> 

<h1>Login </h1>
<p>Enter user information</p>

<form action="/user_process.php" method="post">
    <label for="fname">username:</label><br>
    <input type="text" id="usr" name="usr"><br>
    <label for="pass">password:</label><br>
    <input type="password" id="pswd" name="pswd"><br><br>
    <input type="submit" name="login" value="Login">
</form>

<br>
<a href='user_create.php'>Click here to create a user account</a>

</body>
</html> 