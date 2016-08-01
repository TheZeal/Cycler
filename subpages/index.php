<script language="JavaScript" type="text/javascript" src="ressources/behaviour.js"></script>
<script>
<?php
	include_once("ressources/config.php");
	$conn = new mysqli($config[servername], $config[username], $config[password], $config[basename]);
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM links";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc())
	{
		echo "append(\"$row[link]\",$row[delay]);\n";
	}
?>
swap(0)
</script>