<!DOCTYPE html>
<html>
<head>
<title>Athlete Table</title>
<style>

table {
	width: 50%;
	border: 5px solid black;
}
table th, td{
	border: 2px solid black;
	text-align: center;
}
table th {
	background-color: #D3D3D3;
}

</style>

</head>


<body>

<?php

include "mysqldata.php";

$outputTBL = '';
$country = $_GET["country_id"];
$p_name = $_GET["part_name"];

//Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Validate Connection
if (!$conn) {
	die("Connection NOT established" . mysqli_connect_error());
}

$sql = "SELECT name, gender, height, weight FROM Cyclist WHERE ISO_id = '$country' AND name LIKE '%$p_name%'";

$result = mysqli_query($conn, $sql);

//since a table is necessary for this the table tag will be used to create the table in this file and the string will be outputted to the page
// so when it gets echoed onto the the html page it will use html to form the table
$outputTBL .= '<table>';
$outputTBL .= '<th>Name</th><th>Gender</th><th>BMI</th>';
//these are the table headers so that it will tell you what is under each column

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_array($result)){
		$outputTBL .= '<tr>'; //for each row in the sql result it will make each selected item and put them into a table row
		$bmi = ($row["weight"]/(($row["height"]/100)*($row["height"]/100))); // this is just the formula for the bmi
		$outputTBL.= '<td>' . $row["name"] . '</td>';
		$outputTBL.= '<td>' . $row["gender"] . '</td>';
		$outputTBL.= '<td>' . round($bmi, 3) . '</td>'; // this rounds the bmi 3dp
		$outputTBL .= '</tr>';
	}
	$outputTBL .= '</table>';
	
	echo $outputTBL; //echos the string so that it forms the table 
	
}else {
	echo "0 results"; //this is the validation so that if any incorrect data is entered
}

mysqli_close($conn);

?>

</body>