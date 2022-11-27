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

<h1>Create User</h1>
<p>Enter user information</p>

<form action="/login.php" method="post">
    <label for="fname">username:</label><br>
    <input type="text" id="usr" name="usr"><br>
    <label for="pass">password:</label><br>
    <input type="password" id="pswd" name="pswd"><br><br>
    <input type="submit" name="create" value="Create"><br>
</form>

</body>
</html> 