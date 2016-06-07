<?php 
    include_once("ressources/functions.php");
    include_once("ressources/config.php");
    $conn = new mysqli($config[servername], $config[username], $config[password], $config[basename]);
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    if($_GET[setpassword])
    {
        if($_POST[password])
        {
            $sql = "SELECT * from adminpassword LIMIT 1";
            $result = $conn->query($sql);
            if(mysqli_num_rows($result))
            {
                echo "<div class=\"justified\">";
                echo "Admin password is already set.";
                echo "</h1>";
                exit();
            }
            $crypted_password = crypt_password($_POST[password]);
            $sql = "INSERT into adminpassword values('$crypted_password')";
            $result = $conn->query($sql);
        }
    }
?>

<?php
    if($_GET[logoff])
    {
        $_SESSION = array();
        session_destroy();
    }
?>

<?php
    if(admin_check())
    {
        echo "<div class=\"justified\">";
        echo "Already connected as admin.";
        echo "</div>";
        echo "<br>";
        echo "<div class=\"justified\">";
        echo "<form method = \"POST\" action = \"index.php?p=admin&logoff=1\">";
        echo "<input type = \"submit\" value = \"Logoff ?\"/>";
        echo "</div>";

        exit();
    }
    $sql = "SELECT * from adminpassword LIMIT 1";
    $result = $conn->query($sql);
    if(!mysqli_num_rows($result))
    {
        echo "<div class=\"justified\">";
        echo "<h1>";
        echo "Chose an admin password";
        echo "</h1>";
        echo "</div>";
        echo "<br>";
        echo "<div class=\"justified\">";
        echo "<form method = \"POST\" action = \"index.php?p=admin&setpassword=1\">";
        echo "Password : <input type = \"password\" name = \"password\"/>";
        echo "<input type = \"submit\" value = \"Set password\"/>";
        echo "</div>";
        exit();
    }
?>

<?php
    if($_GET[login])
    {
        if($_POST[password])
        {
            $sql = "SELECT * from adminpassword LIMIT 1";
            $result = $conn->query($sql);
            $actual_crypted_password = $result->fetch_assoc()[password];
            $crypted_password = crypt_password($_POST[password]);
            if($actual_crypted_password == $crypted_password)
            {
                echo "<div class=\"justified\">";
                echo "You are now connected as admin!";
                echo "<meta http-equiv=\"refresh\" content=\"1;url=index.php?p=changesequence\"/>";
                echo "</div>";
                $_SESSION[admin] = true;
                exit();
            }
            echo "Wrong password!";
        }
    }
?>


<h1>
    Admin login pannel
</h1>
<div class="justified">
<form method = "POST" action = "index.php?p=admin&login=1">
Password : <input type = "password" name = "password"/>
<input type = "submit" value = "Connect"/>
</div>
