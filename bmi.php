<!DOCTYPE html>
<html>
<head>
<title>BMI Table</title>

<style>
<!-- The is the CSS for the tables -->
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
table td:first-child {
	background-color: #D3D3D3;
}

</style>

</head>

<body>


<?php
if (isset($_GET['submit'])){
	if (is_numeric($_GET["max_height"]) && is_numeric($_GET["min_height"]) && is_numeric($_GET["max_weight"]) && is_numeric($_GET["min_weight"])){
    // is_numeric checks that the string entered has numeric value
		
		$outputTBL = '';
		$h_max = $_GET["max_height"];
		$w_max = $_GET["max_weight"];
        // gets the data from the html file

        
        $outputTBL .= '<table>';
		$outputTBL .= '<th>Weight↓/Height→</th>';
        for ($h_min = $_GET["min_height"];$h_min <= $h_max; $h_min += 5) {
			$outputTBL .= '<th>' . $h_min . '</th>';
            //uses the min input and increments it in 5s to get the headers
        }
		for ($w_min = $_GET["min_weight"];$w_min <= $w_max; $w_min += 5) {
			$outputTBL .='<tr>';
			$outputTBL .= '<td>' . $w_min . '</td>';
			for ($h_min = $_GET["min_height"];$h_min <= $h_max; $h_min += 5) {
				$bmi = ($w_min/(($h_min/100)*($h_min/100)));
				$outputTBL .= '<td>' . round($bmi, 3) . '</td>';
				//this outputs the bmi for each weight and height for each row
			}
			$outputTBL .= '</tr>';
            
        }
        $outputTBL .= '</table>';
		

        
        echo $outputTBL;
    
	}else{
		echo "Must be an integer"; // this is the validation for the inputs if they aren't numeric it will not be accepted
	}	
}
?>

</body>
