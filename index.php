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
    <a class='active' href='index.php'>Home</a>
    
    <?php
    if($pass) {
        echo "<a href='info.php'>Info</a>
                <a href='logout.php'>Logout</a>";
    } else {
        echo "<a href='login.php'>Login</a>";
    }
    ?>
</div> 

<h1>Home</h1>

<?php
    if($pass) {
        echo "Welcome " . $pass;
    }
?>

</body>
</html> 
