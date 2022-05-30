<!DOCTYPE html>
<html>
<head>
<title>Comparison</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

$(document).ready(function(){
	$('#myButton').click(function(){
		var selected = $("#options").val(); //this gets the value of the selection box
		var c_1 = $("#country_1").val(); // this gets the values of the inputs for the ISOs
		var c_2 = $("#country_2").val();
		if (selected === "Basic") { //A way to get different results for the selections
			var full = "";
			var text = "";
			
			$.get("returnData.php", {country_1 : c_1}, function(responseData){
				text +=responseData; // This gets the result from the sql in the php files and adds it to the text variable
				$('#countryInfo').html(text); // then it gets put into the div for the Info
			});
			$.get("returnData.php", {country_1 : c_2}, function(responseData){
				text +=responseData; // These are done consecutively as you cannot get multiple outputs
				$('#countryInfo').html(text);
				
			});
			
			$.get("returnTBL.php", {country_1 : c_1}, function(responseData){				
				var tb1_len = responseData.length; // this returns a json so to get the data from it you have to get the length
				if (tb1_len > 0){ // this is validation for it as if an incorrect ISO is enetered the SQL won't have any results so it will skip it and not create the table at all if the ISO is incorrect
					var tblHTML = "<table><th>Country ID</th><th>Cyclist</th>"; //This creates the table and the headers
					for (var i = 0; i<tb1_len; i++){ // It will loop for each element in the json and get the data
						
						var countryID = responseData[i].ISO_id; //assigns the ISO id and the name to a variable that gets reset each iteration
						var cyclist = responseData[i].name;
						tblHTML += "<tr>" +
								"<td>" + countryID + "</td>" + // then they are added to the table using a styring for html manipulation
								"<td>" + cyclist + "</td>" +
								"</tr>";
						};
					tblHTML += "</table>"; //this is the closing tag for the table so it creates the full table
					full += tblHTML; // this is added to another variable to hold this full table, so that it can create 2 tables in one go
					
				}
				$('#countryTBL').html(full); // however making 2 tables at once came with some errors as it would take too long to load them at once
			}, "json"); // to make sure it will recieve a json type
			
			$.get("returnTBL.php", {country_1 : c_2}, function(responseData){ // this is the same function just with the second iso since you can't get 2 json arrays in one sql query
				var tb1_len = responseData.length;
				if (tb1_len > 0){
					var tblHTML = "<table><th>Country ID</th><th>Cyclist</th>";
					for (var i = 0; i<tb1_len; i++){
						
						var countryID = responseData[i].ISO_id;
						var cyclist = responseData[i].name;
						tblHTML += "<tr>" +
								"<td>" + countryID + "</td>" +
								"<td>" + cyclist + "</td>" +
								"</tr>";
						};
					tblHTML += "</table>";
					full += tblHTML;
					
				}
				$('#countryTBL').html(full);
			}, "json");	
		}
		
		if (selected === "Total") {
			var text = "";
			$.get("rankTotal.php", function(responseData){
				var len = responseData.length;
				var found1 = false; // these are used for validation 1 & 2 are used to see if you have found the 1st enetered ISO
				var found2 = false;
				for (var i = 0; i<len; i++){
					
					var countryID = responseData[i].ISO_id;
					var countryname = responseData[i].country_name;
					
					if (c_1.toUpperCase() == countryID){ // this compares the entered id to the id in the sql json, the entered has to be made uppercase so that it will match with the ones in the sql
						text += countryname + "("+countryID+") is ranked at: Rank "+(i+1)+" in Total Medals<br>";
						found1 = true; //this checks if the first ISO id has been found and sets it to true
					}
					if (c_2.toUpperCase() == countryID){
						text += countryname + "("+countryID+") is ranked at: Rank "+(i+1)+" in Total Medals<br>";
						found2 = true; // checks the second iso has been found
					}
				}
				if (found1 == false){ // this is if there is no data for what you enetered or if it was invalid there is an outcome
					text +=  c_1.toUpperCase() + " has 0 medals<br>"; // even if invalid it will say 0 medals
				}
				if (found2 == false){
					text +=  c_2.toUpperCase() + " has 0 medals<br>";
				}
				$('#countryInfo').html(text); // overwrites whatevers in the countryinfo id and put the text variable in it
			}, "json");
			
		}
		
		if (selected === "Gold") { // essentially the same as Total but it checks the Gold instaed of total
			var text = "";
			$.get("rankGold.php", function(responseData){
				var len = responseData.length;
				var found1 = false;
				var found2 = false;
				for (var i = 0; i<len; i++){
					
					var countryID = responseData[i].ISO_id;
					var countryname = responseData[i].country_name;
					
					if (c_1.toUpperCase() == countryID){
						text += countryname + "("+countryID+") is ranked at: Rank "+(i+1)+" in Gold Medals<br>";
						found1 = true;
					}
					if (c_2.toUpperCase() == countryID){
						text += countryname + "("+countryID+") is ranked at: Rank "+(i+1)+" in Gold Medals<br>";
						found2 = true;
					}
				}
				if (found1 == false){
					text +=  c_1.toUpperCase() + " has 0 medals<br>";
				}
				if (found2 == false){
					text +=  c_2.toUpperCase() + " has 0 medals<br>";
				}
				$('#countryInfo').html(text);
			}, "json");
			
		}
		
		if (selected === "Cyclist") {
			var text = "";
			var found1 = false;
			var found2 = false;
			
			$.get("rankCyclists.php", function(responseData){
				var len = responseData.length;
				
				for (var i = 0; i<len; i++){
					
					var countryID = responseData[i].ISO_id;
					var countryname = responseData[i].country_name;
					
					if (c_1.toUpperCase() == countryID){
						text += countryname + "("+countryID+") is ranked at: Rank "+(i+1)+" in Number Of Cyclists<br>";
						found1 = true;
					}
					if (c_2.toUpperCase() == countryID){
						text += countryname + "("+countryID+") is ranked at: Rank "+(i+1)+" in Number Of Cyclists<br>";
						found2 = true;
					}
				}
				if (found1 == false) {
					text+= c_1.toUpperCase() + " has 0 cyclists<br>"; // since some of the data is placeholder so it won't have data so it will be set to 0.
				}
				if (found2 == false) {
					text+= c_2.toUpperCase() + " has 0 cyclists<br>";
				}
				$('#countryInfo').html(text);
			}, "json");
			
		}
		
		if (selected === "Age") {
			var text = "";
			var found1 = false;
			var found2 = false;
			
			$.get("rankAge.php", function(responseData){
				var len = responseData.length;
				
				for (var i = 0; i<len; i++){
					
					var countryID = responseData[i].ISO_id;
					var countryname = responseData[i].country_name;
					
					if (c_1.toUpperCase() == countryID){
						text += countryname + "("+countryID+") is ranked at: Rank "+(i+1)+" in Lowest Average Age of Cyclists<br>";
						found1 = true;
					}
					if (c_2.toUpperCase() == countryID){
						text += countryname + "("+countryID+") is ranked at: Rank "+(i+1)+" in Lowest Average Age of Cyclists<br>";
						found2 = true;
					}
				}
				if (found1 == false) {
					text+= c_1.toUpperCase() + " has no cyclists, therefore no Average Age<br>"; // this will only happen if there is no cyclist
				}
				if (found2 == false) {
					text+= c_2.toUpperCase() + " has no cyclists, therefore no Average Age<br>";
				}
				$('#countryInfo').html(text);
			}, "json");
			
		}
	});
});

</script>
<style>
body {   <! -- This is the CSS used for the page, these gives the colour to body of the page -->
	font-family: monaco, monospace;
	background-color: #ff99c2;
}
#blue {
	background-color: #0085c7;
	margin-top:-5px; <! -- This gets rid of the whitespace between the divs so the colours actually look good -->
	margin-bottom:-10px;
}
#yellow {
	background-color: #f4c300;
}
#green {
	background-color: #009f3d;
}
#black {
	background-color: #09070e;
	margin-top:-5px;
	margin-bottom:-10px;
}
#white {
	background-color: #ffffff;
}
#red {
	background-color: #df0024;
	margin-top:0px;
	margin-bottom:0px;
}
table {
	width: 45%;
	border: 5px solid black;
	float: left; <! -- This allows multiple tables to be inline with each other so this allows the 2 tables for the countries to be next to each other -->
	margin: 30px; 
}
table th, td{
	border: 2px solid black;
	text-align: center;
}
table th {
	background-color: #D3D3D3;
}
.center {
	text-align: center;
    
}
.column {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 15%;
  padding: 5px;
}
#right {
	float: right;
}
#left {
	float: left;
}

</style>
</head>

<body>
<div id = "black">
	<img id = "left" src="logo.png" style="width:10%">
	<img id = "right" src="olympicLogo.png" style="width:10%">
	<h3 class="center">COA123 - Web Programming</h3>
	<h2 class="center">Olympic Cyclists</h2>
	<h1 class="center">Country Comparison</h1>
</div>
<div> <! -- This is to have the olympics 5 colour scheme on the screen for aesthetic purposes --> 
	<div id = "white">&nbsp;</div>
	<div id = "red">&nbsp;</div>
	<div id = "black" >&nbsp;</div>
</div>
<div class="column"><img src="cycling.png" style="width:100%"></div>
<div class = "center"> <! -- These are the inputs for the country ISO used in the SQL queries -->
<label for="country_1">Enter the first Country ID (ISO_id) :</label>
<input name="country_1" type="text" class="larger" id='country_1' size="18" value = "gbr"/></div>
<div class = "center">
<label for="country_2">Enter the second Country ID (ISO_id): </label>
<input name="country_2" type="text" class="larger" id='country_2' size="18" value = "rus" /></div>
<div  class = "center">
<label for="options">Change for Filter Type:</label>
<select id = 'options' name = "options"> <! -- AS a way of choosing the different searching options a select box is used -->
	<option value="Basic">Basic</option> <! -- This is is regular basic way of searching which shows the cyclists, and the total medals -->
	<optgroup label = "Medals"> <! -- The optgroup is a way to know what genre you are searching before you click the option -->
	<option value="Total">Total</option>
	<option value="Gold">Gold</option>
	</optgroup>
	<optgroup label = "Cyclists">
	<option value="Cyclist">Number</option>
	</optgroup>
	<optgroup label = "Age">
	<option value="Age">Average Age</option>
	</optgroup>
</select>
</div>

<div class = "center">
<button id = "myButton" type="button" class="btn btn-info">Search</button>
</div>

<div id = "countryInfo" class = "center"></div> <! -- This is empty but when the AJAX and JQuery are performed the div will be filled with info dynamically -->
<div id = "countryTBL" class = "center"></div> <! -- This is the div for the table that shows the basic search, since it will be shown as a table, better to look at -->
</body>
</html>

