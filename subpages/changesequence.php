<h1>
    Manage link sequence
</h1>
<?php
    include_once("ressources/config.php");
    include_once("ressources/functions.php");
    if(!admin_check())
    {
        echo "<div class=\"justified\"\n>";
        echo "Please authentificate yourself <a href = \"/index.php?p=admin\">&nbsp;here </a>";
        echo "</div>";
        exit();
    }
    $conn = new mysqli($config[servername], $config[username], $config[password], $config[basename]);
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    if($_GET[validate])
    {
        if($_POST["link_1"] && $_POST["delay_1"]) // because you dont want to supress everything.
        {
            $sql = "DELETE from links";
            $conn->query($sql);
            for($id=1;!empty($_POST["link_$id"]);$id++)
            {
                $link = mysqli_real_escape_string($conn, $_POST["link_$id"]);
                $delay = mysqli_real_escape_string($conn, $_POST["delay_$id"]);
                $sql = "INSERT INTO links VALUES($id, '$link', $delay)";
                $result = $conn->query($sql);
            }
            $_SESSION[working] = null;
        }
    }
?>
<?php
    if($_GET[reset])
    {
        $_SESSION[working] = null;
    }
?>
<?php
    if($_GET[deleteall])
    {
        $_SESSION[working] = null;
        $sql = "DELETE from links";
        $conn->query($sql);
    }
?>
<?php
    $conn = new mysqli($config[servername], $config[username], $config[password], $config[basename]);
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    if(empty($_SESSION[working]))
    {
        $_SESSION[working] = true;
        $_SESSION[edit] = array();
        $sql = "SELECT * FROM links";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc())
        {
            $_SESSION[edit][] = $row;
        }
    }
    $id = 1;
    echo "<div id=\"link_list\">";
    foreach( array_values($_SESSION[edit]) as $value )
    {
        echo "<div class=\"link_container\" id=page_$id>\n";
        echo "<div class=\"link_wrapper\">";
        echo "<textarea id=\"link_$id\" cols=\"80\" rows=\"1\" placeholder=\"http://your-adress-here\">" . htmlspecialchars($value[link]) ."</textarea>\n";
        echo "<input type = \"text\" id = \"delay_$id\" placeholder=\"delay(s)\" value = \"" . htmlspecialchars($value[delay]) . "\">\n";
        echo "<button class=\"removebutton\" onclick=\"remove_link($id)\" id=\"remove_$id\">delete</button>\n";
        echo "<br>\n";
        echo "</div>";
        echo "</div>";
        $id++;
    }
    echo "</div>\n";
    echo "<div class=\"justified\"\n>";
    echo "<button class=\"addbutton\" onclick=\"append_link()\">+</button>\n";
    echo "</div>\n";
    echo "<div class=\"justified\">\n";
    echo "<button class=\"submit\" onclick=\"post_changes()\">Validate changes.</button>\n";
    echo "</div>\n";
    echo "<form method = \"POST\" action = \"index.php?p=changesequence&reset=1\">\n";
    echo "<div class=\"justified\">\n";
    echo "<input type=\"submit\" value=\"Reset changes\" ID=\"reset\">\n";
    echo "</div>\n";
    echo "</form>\n";
    echo "<form method = \"POST\" action = \"index.php?p=changesequence&deleteall=1\">\n";
    echo "<div class=\"justified\">\n";
    echo "<input class=\"removebutton\" type=\"submit\" value=\"Delete all links\" ID=\"deleteall\">\n";
    echo "</div>\n";
    echo "</form>\n";
    echo "<footer>SlightlyLessShittySoftware by ShittyCorp™</footer>\n";
    echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"ressources/changesequence.js\"></script>";
?>
<?php
    if($_GET[validate])
    {
        echo "<h3>Your changes have been validated!<h3>";
    }
?>
