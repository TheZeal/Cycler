<!DOCTYPE html>
<html lang="fr">
 	<head>
    <meta charset="utf-8">
    	<link rel="stylesheet" href="styles/index.css">
  	</head>
  	<body>
		<script language="JavaScript" type="text/javascript" src="scripts/index.js">
		</script>
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
			setCurrent(0);
		</script>
		<div id="over">
		</div>
	</body>
</html>
