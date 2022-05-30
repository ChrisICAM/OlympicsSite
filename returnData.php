<?php
include "mysqldata.php"; // includes the data from another php file

if (isset($_REQUEST["country_1"])){
	$country_1 = $_REQUEST["country_1"];
	

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection NOT established" . mysqli_connect_error());
	}
	
	
	$sql = "SELECT country_name, ISO_id, total FROM Country WHERE ISO_id = '$country_1'";
	//sql query that outputs the name, iso and total medals from the able country where the country is the same as the one inputted

	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			echo $row["country_name"]."(" . $row["ISO_id"] . "): ".$row["total"]." Total Medals <br>"; //outputs a string that shows the total medals from the sql query
		}
	}else{
		echo $country_1 ." has 0 results <br>";
	}
}
mysqli_close($conn);

?>