<?php
    include("backend_users.php");
    include("backend_blog.php");

    $users = new Users();
    $blog = new Blog();
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
        echo "<a class='active' href='blog.php'>Blog</a>";
        echo "<a href='user_logout.php'>Logout</a>";
    } else {
        echo "<a href='user_login.php'>Login</a>";
    }
    ?>
</div>

<h1>Info</h1>

<?php

if ($pass) { 
    $blog->return_entry(1);

} else {
    echo "ACCESS DENIED";
}

?>

</body>
</html> 