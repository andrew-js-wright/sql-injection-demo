<?php

	$connection = mysqli_connect(getenv('CLEARDB_DATABASE_URL'););

	if (mysqli_connect_errno($connection))
	{
		die ("Failed to connect to MySQL: <strong>" . mysqli_connect_error() . "</strong>");
	}
?>
