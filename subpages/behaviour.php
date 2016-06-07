<?php
	include_once("../ressources/config.php");
	$conn = new mysqli($config[servername], $config[username], $config[password], $config[basename]);
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT SUM(delay) AS delay_sum FROM links";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$sum = $row[delay_sum];
	if($sum==0)
	{
		echo "subpages/empty_list.php";
		exit();
	}
	$curr_cycle_time = (time() % 86400) % $sum;
	$sql = "SELECT * FROM links";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc())
	{
		if($row[delay]<$curr_cycle_time)
		{
			$curr_cycle_time-=$row[delay];
		}
		else
		{
			echo $row[link];
			exit();
		}
	}
?>
