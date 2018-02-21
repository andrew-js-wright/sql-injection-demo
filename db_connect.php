<?php

	$connection = mysqli_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));

	if (mysqli_connect_errno($connection))
	{
		die ("Failed to connect to MySQL: <strong>" . mysqli_connect_error() . "</strong>");
	}
?>
