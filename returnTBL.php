<?php

include "mysqldata.php"; // includes another php file that holds the data for connecting to the sql database

if (isset($_REQUEST["country_1"])){
	$country_1 = $_REQUEST["country_1"]; //gets the countryid from the view.php
	

	$conn = mysqli_connect($servername, $username, $password, $dbname); //connects to the server

	if (!$conn) {
		die("Connection NOT established" . mysqli_connect_error());
	}
	
	$tblArray_1 = array();
	$sql = "SELECT ISO_id, name FROM Cyclist WHERE ISO_id = '$country_1'"; //sql query to get the data

	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$tblArray_1[] = $row; // adds the rows of the result of the query to an array
		}
	}



	echo json_encode($tblArray_1); //json encodes the array and outputs it
}
mysqli_close($conn); //closes the connection to the php sql file

?>