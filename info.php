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
        echo "<a class='active' href='info.php'>Info</a>";
        echo "<a href='blog.php'>Blog</a>";
        echo "<a href='user_logout.php'>Logout</a>";
    } else {
        echo "<a href='user_login.php'>Login</a>";
    }
    ?>
</div>

<h1>Info</h1>

<?php

if ($pass) { echo $users->display_all();
} else {
    echo "ACCESS DENIED";
    exit;
}

?>

</body>
</html> 