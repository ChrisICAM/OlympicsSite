<?php
include "mysqldata.php";



	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection NOT established" . mysqli_connect_error());
	}
	
	
	$sql = "SELECT ISO_id, country_name FROM Country ORDER BY total DESC";
	// A query that just gets the countries in the order of highest total medals to lowest for the ranking order
	//The order of countries that have the same amount depend on the order it gets outputted in the SQL result
	
	$result = mysqli_query($conn, $sql);
	$ranking = array();
	if (mysqli_num_rows($result) > 0) { //this checks that if there is actually a result to the query since if there was invalid data inputted it would cause an error without this
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$ranking[] = $row;
		}
	}
	echo json_encode ($ranking);



mysqli_close($conn);


?>