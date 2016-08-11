<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="utf-8">
        <link rel="stylesheet" href="styles/manage.css">
    </head>
    <body>
        <?php 
            include_once("ressources/config.php");

            function crypt_password($password)
            {
                return sha1($password . $config[salt]);
            }

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
            if($_SESSION[admin] != null)
            {
                echo "<div class=\"justified\">";
                echo "Already connected as admin.";
                echo "</div>";
                echo "<br>";
                echo "<div class=\"justified\">";
                echo "<form method = \"POST\" action = \"login.php?logoff=1\">";
                echo "<button class='logoff' type = 'submit' value = 'Logoff?'/>Logoff</button>";
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
                echo "<form method = \"POST\" action = \"login.php?setpassword=1\">";
                echo "Password : <input type = \"password\" name = \"password\"/>";
                echo "<button class='createpassword' type = 'submit' value = 'Set password?'/>Set password?</button>";
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
                        echo "<meta http-equiv=\"refresh\" content=\"1;url=manage.php\"/>";
                        echo "</div>";
                        $_SESSION[admin] = true;
                        exit();
                    }
                }
            }
        ?>
        <h1>
            Admin login pannel
        </h1>
        <div class="justified">
        <form method = "POST" action = "login.php?login=1">
        Password : <input type = "password" name = "password"/>
        <button class="login" type = "submit" value = "Connect"/>Connect</button>
        </div> 
        <?php
            if($_GET[login])
            {
                if($_POST[password])
                {
                    $sql = "SELECT * from adminpassword LIMIT 1";
                    $result = $conn->query($sql);
                    $actual_crypted_password = $result->fetch_assoc()[password];
                    $crypted_password = crypt_password($_POST[password]);
                    if($actual_crypted_password != $crypted_password)
                    {
                        
                        echo "<div class=\"justified\">";
                        echo "<h3>Wrong password!</h3>";
                        echo "</div>";
                        exit();
                    }
                }
            }
        ?>
    </body>
</html>
