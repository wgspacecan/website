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
        echo "<a class='active' href='info.php'>Info</a>
                <a href='logout.php'>Logout</a>";
    } else {
        echo "<a href='login.php'>Login</a>";
    }
    ?>
</div>

<h1>Info</h1>

<?php

if ($pass) { echo $users->display_current_users();
} else {
    echo "ACESS DENIED";
}

?>

</body>
</html> 