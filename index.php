<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">
 	<head>
    <meta charset="utf-8">
    	<link rel="stylesheet" href="styles.css">
  	</head>
  	<body>
		<?php
			if(file_exists("subpages/" . $_GET[p] . ".php"))
			{
				include_once("subpages/" . $_GET[p] . ".php");
			}
			else
			{
				include_once("subpages/index.php");
			}
		?>
	</body>
</html>
