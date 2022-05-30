<?php

include "mysqldata.php";



	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection NOT established" . mysqli_connect_error());
	}
	
	
	$sql = "SELECT Cyclist.ISO_id, Country.country_name, AVG(YEAR('2012-07-27')-YEAR(Cyclist.dob)) AS Age FROM `Cyclist` INNER JOIN `Country` ON Cyclist.ISO_id = Country.ISO_id GROUP BY Cyclist.ISO_id ORDER BY Age ASC";
	//this gets the average age of the cyclists from a specific country by comparing their D.O.B to the date that the olymics started
	// since this is ranking it has to be in ascending order to go from smallest to biggest as smallest is rank 1 etc
	
	$result = mysqli_query($conn, $sql);
	$ranking = array();
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$ranking[] = $row; // every row of data is needed in this as it is a ranking out of all the countries in the table 
		}
	}
	echo json_encode ($ranking); //this json encodes all the countries then the comparison will be done in the main file



mysqli_close($conn);


?>