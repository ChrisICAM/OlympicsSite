<?php

include "mysqldata.php";



	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection NOT established" . mysqli_connect_error());
	}
	
	
	$sql = "SELECT Country.ISO_id, Country.country_name, COUNT(Cyclist.ISO_id) FROM `Country` INNER JOIN `Cyclist` ON Country.ISO_id = Cyclist.ISO_id GROUP BY Cyclist.ISO_id ORDER BY COUNT(Cyclist.ISO_id) DESC";
	// This gets the count of the cyclists that come from each country, since it is ranking which is biggest to smallest it is in descending order
	// a join is used as the two tables need to be connected since both data is needed, since the ISO is in both tables it was easy to connect them
	
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