<?php
include "mysqldata.php";



	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection NOT established" . mysqli_connect_error());
	}
	//this is used for whenever i is unable to connect to the SQL server it will have a failsafe
	
	$sql = "SELECT ISO_id, country_name FROM Country ORDER BY gold DESC";
	// A very simple query that just gets the countries in the order of highest gold medals to lowest for easy ranking

	$result = mysqli_query($conn, $sql);
	$ranking = array();
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$ranking[] = $row;
		}
	}
	echo json_encode ($ranking);



mysqli_close($conn);

?>