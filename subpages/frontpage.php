<!DOCTYPE html>
<html lang="fr">
 	<head>
    <meta charset="utf-8">
    	<link rel="stylesheet" href="../styles.css">
  	</head>
  	<body>
		<div class="justified">
			<h1>
			<?php
				$host= gethostname();
				$ip = gethostbyname($host);
				echo "Server adress is " . $ip;
			?>
			</h1>
		</div>
		<div class="justified">
			<h2>
				Cycling will begin in 20 seconds.
				If you wish to change the cycling sequence, please go to /index.php?p=admin
			</h2>
		</div>
	</body>
</html>
