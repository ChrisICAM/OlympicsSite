




<?php

include "mysqldata.php";

if (isset($_GET['submit'])){
	$test_1 = explode('/', $_GET["date_1"]);
	$test_2 = explode('/', $_GET["date_2"]);
	if (count($test_1) == 3 && count($test_2) == 3) {
		if (checkdate($test_1[1], $test_1[0], $test_1[2]) && checkdate($test_2[1], $test_2[0], $test_2[2])){
			$date_1 = DateTime::createFromFormat('d/m/Y', $_GET["date_1"]) ->format('Y-m-d');
			$date_2 = DateTime::createFromFormat('d/m/Y', $_GET["date_2"]) ->format('Y-m-d');
			
			
			//Connection
			$conn = mysqli_connect($servername, $username, $password, $dbname);

			//Validate Connection
			if (!$conn) {
				die("Connection NOT established" . mysqli_connect_error());
			}

			$sql = "SELECT Cyclist.name, Country.country_name, Country.gdp, Country.population FROM Cyclist INNER JOIN Country ON Cyclist.ISO_id = Country.ISO_id WHERE Cyclist.dob BETWEEN '$date_1' AND '$date_2'";

			$result = mysqli_query($conn, $sql);

			$dataArray = array();
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$dataArray[] = $row;
			}

			echo json_encode($dataArray);
		} else {
			echo "Invalid Date";
		}
	} else {
		echo "Invalid Date";
	}
}

?>