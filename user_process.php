<?php
    include("users.php");
    $users = new Users();
    $result = $users->process();
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
        echo "<a href='user_logout.php'>Logout</a>";
    } else {
        echo "<a href='user_login.php'>Login</a>";
    }
    ?>

</div> 

<?php

echo $result;

?>

</body>
</html> 