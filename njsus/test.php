<!-- CSC 315 - NJSus Database Final Project
Matthew Izzo, Joseph Candiano, Sam Hajnassrollahi, Babette Chao -->
<?php
session_start();
?>
<!DOCTYPE html>
<head>
	<title>Search the NJSus Database</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		li {
			list-style: none;
		}
		body {
			background-image: url("https://www.toptal.com/designers/subtlepatterns/patterns/more-leaves-on-green.png");
			background-repeat: repeat;
			font-family: "Trebuchet MS", Helvetica, sans-serif;
		}
	</style>
</head>
<body>
	<h1 style="text-align:center">NJ Sustainability Stats Database</h1>
	<ul style="text-align:center">
		<form name="display" action="test.php" method="POST">
			<li>What kind of data are you looking for?:</li>
			<li><input style="border-radius: 5px; padding: 5px; font-size: 15px; transition: all 0.3s;" type="submit" name="town" value="Towns" /></li><br>
			<li><input style="border-radius: 5px; padding: 5px; font-size: 15px; transition: all 0.3s;" type="submit" name="restaurant" value="Restaurants" /></li><br>
			<li><input style="border-radius: 5px; padding: 5px; font-size: 15px; transition: all 0.3s;" type="submit" name="vegan_options" value="Vegan Options" /></li><br>
			<li><input style="border-radius: 5px; padding: 5px; font-size: 15px; transition: all 0.3s;" type="submit" name="sustainability" value="Sustainability" /></li><br>
			<li><input style="border-radius: 5px; padding: 5px; font-size: 15px; transition: all 0.3s;" type="submit" name="query" value="I'd like to enter my own PSQL query." /></li>
		</form>
	</ul>
	<?php
		// Connect to database
		$db = pg_connect("host=localhost port=5432 dbname=njsus user=osc password=osc");
		//Check for what option was chosen from the initial dropdown
		if(isset($_POST['town'])){
			$_SESSION["chosenTable"] = "town";
		} elseif(isset($_POST['restaurant'])){
			$_SESSION["chosenTable"] = "restaurant";
		} elseif(isset($_POST['vegan_options'])){
			$_SESSION["chosenTable"] = "vegan_options";
		} elseif(isset($_POST['sustainability'])){
			$_SESSION["chosenTable"] = "sustainability";
		} elseif(isset($_POST['query'])){
			$_SESSION["chosenTable"] = "query";
		}

		// If town is chosen display the following options
		if($_SESSION["chosenTable"] == 'town'){
	?>
			<ul style="text-align:center">
				<form name="display" action="test.php" method="POST">
					<li>Check all the data you'd like to get:</li>
					<li><input type="checkbox" name="check_list[]" value="tcode"/><label> Town Code </label></li>
					<li><input type="checkbox" name="check_list[]" value="tname"/><label> Town Name </label></li>
					<li><input type="checkbox" name="check_list[]" value="county"/><label> County </label></li>
					<li><input type="checkbox" name="check_list[]" value="sustain_rating"/><label> Sustainability </label></li><br>

					<li>If you'd like, select a datapoint to compare against a value:</li>
					<li><select id="whereTown" name="where">
						<option value="tcode">Town Code</option>
						<option value="tname">Town Name</option>
						<option value="county">County</option>
						<option value="sustain_rating">Sustainability Rating</option>
					</select></li><br>

					<li>How would you like to check that value?:</li>
					<li><select id="checkTown" name="check">
						<option value="=">Is/Is equal to</option>
						<option value="<">Is less than</option>
						<option value=">">Is greater than</option>
					</select></li><br>

					<li>And that value is?</li>
					<li><input type ="text" name="value"></li>
					<li><input type="submit" name="submit" value="Submit" /></li>
				</form>
			</ul>
	<?php
		// Make selected into a comma seperated list
		$selectList = implode(", ", $_POST['check_list']);
		//Format compare value with basic security measures and proper layout
		$compareValue = "'".strip_tags(trim($_POST[value]))."'";
		//Check if a value is included
		if($_POST[value]){
			$result = pg_query($db, "SELECT $selectList FROM TOWN WHERE $_POST[where] $_POST[check] $compareValue;");
		// If just a select from query
		}elseif($selectList){
			$result = pg_query($db, "SELECT $selectList FROM TOWN;");
		}
		// If submit is clicked then we start making tables
		if (isset($_POST['submit'])){

		//Now move onto building the table
	?>

	<table align="center" border="1px" style="width:600px; line-height:40px; background-color: green;">
			<tr>
				<th colspan="4"><h2>Towns</h2></th>
			</tr>
			<t>
					<th> Town Code </th>
					<th> Town Name </th>
					<th> County </th>
					<th> Sustainability Rating </th>
			</t>
			<?php
				// Go through each row and print results
				while($row = pg_fetch_assoc($result)) {
			?>
					<tr>
						<td><?php echo $row['tcode']; ?></td>
						<td><?php echo $row['tname']; ?></td>
						<td><?php echo $row['county']; ?></td>
						<td><?php echo $row['sustain_rating']; ?></td>
					</tr>
				<?php
					}
				?>

		<?php
			}
		// If restaurant was the initial chosen option
		}elseif($_SESSION["chosenTable"] == 'restaurant'){
	?>
			<ul style="text-align:center">
				<form name="display" action="test.php" method="POST">
					<li>Check all the data you'd like to get:</li>
					<li><input type="checkbox" name="check_list[]" value="rname"/><label> Restaurant Name </label></li>
					<li><input type="checkbox" name="check_list[]" value="tcode"/><label> Town Code </label></li>
					<li><input type="checkbox" name="check_list[]" value="vegan_friendly"/><label> Vegan Friendly </label></li>
					<li><input type="checkbox" name="check_list[]" value="rest_sustain_rating"/><label> Restaurant Sustainability Rating </label></li>
					<li><input type="checkbox" name="check_list[]" value="address"/><label> Address </label></li><br>

					<li>If you'd like, select a datapoint to compare against a value:</li>
					<li><select id="whereTown" name="where">
						<option value="rname">Restaurant Name</option>
						<option value="tcode">Town Code</option>
						<option value="vegan_friendly">Vegan Friendly</option>
						<option value="rest_sustain_rating">Restaurant Sustainability Rating</option>
						<option value="address">Address</option>
					</select></li><br>

					<li>How would you like to check that value?:</li>
					<li><select id="checkTown" name="check">
						<option value="=">Is/Is equal to</option>
						<option value="<">Is less than</option>
						<option value=">">Is greater than</option>
					</select></li><br>

					<li>And that value is?</li>
					<li><input type ="text" name="value"></li>
					<li><input type="submit" name="submit" value="Submit" /></li>
				</form>
			</ul>
	<?php
		// Make selected into a comma seperated list
		$selectList = implode(", ", $_POST['check_list']);
		//Format compare value with basic security measures and proper layout
		$compareValue = "'".strip_tags(trim($_POST[value]))."'";
		//Check if a value is included
		if($_POST[value]){
			$result = pg_query($db, "SELECT $selectList FROM RESTAURANT WHERE $_POST[where] $_POST[check] $compareValue;");
		// If just a select from query
		}elseif($selectList){
			$result = pg_query($db, "SELECT $selectList FROM RESTAURANT;");
		}
		// If submit is clicked then we start making tables
		if (isset($_POST['submit'])){
	?>
	<table align="center" border="1px" style="width:600px; line-height:40px; background-color: green;">
			<tr>
				<th colspan="5"><h2>Restaurants</h2></th>
			</tr>
			<t>
					<th> Restaurant Name </th>
					<th> Town Code </th>
					<th> Vegan Friendly </th>
					<th> Restaurant Sustainability Rating </th>
					<th> Address </th>
			</t>
			<?php
				// Go through each row and print results
				while($row = pg_fetch_assoc($result))
				{
			?>
					<tr>
						<td><?php echo $row['rname']; ?></td>
						<td><?php echo $row['tcode']; ?></td>
						<td><?php echo $row['vegan_friendly']; ?></td>
						<td><?php echo $row['rest_sustain_rating']; ?></td>
						<td><?php echo $row['address']; ?></td>
					</tr>
			<?php
				}
		}
	//If vegan options is the initially chosen option
	}elseif($_SESSION["chosenTable"] == 'vegan_options'){
	?>
		<ul style="text-align:center">
			<form name="display" action="test.php" method="POST">
				<li>Check all the data you'd like to get:</li>
				<li><input type="checkbox" name="check_list[]" value="rname"/><label> Restaurant Name </label></li>
				<li><input type="checkbox" name="check_list[]" value="options"/><label> Options </label></li><br>

				<li>If you'd like, select a datapoint to compare against a value:</li>
				<li><select id="whereTown" name="where">
					<option value="rname">Restaurant Name</option>
					<option value="options">Options</option>
				</select></li><br>

				<li>How would you like to check that value?:</li>
				<li><select id="checkTown" name="check">
					<option value="=">Is/Is equal to</option>
					<option value="<">Is less than</option>
					<option value=">">Is greater than</option>
				</select></li><br>

				<li>And that value is?</li>
				<li><input type ="text" name="value"></li>
				<li><input type="submit" name="submit" value="Submit" /></li>
			</form>
		</ul>
	<?php
		// Make selected into a comma seperated list
		$selectList = implode(", ", $_POST['check_list']);
		//Format compare value with basic security measures and proper layout
		$compareValue = "'".strip_tags(trim($_POST[value]))."'";
		//Check if a value is included
		if($_POST[value]){
			$result = pg_query($db, "SELECT $selectList FROM VEGAN_OPTIONS WHERE $_POST[where] $_POST[check] $compareValue;");
		// If just a select from query
		}elseif($selectList){
			$result = pg_query($db, "SELECT $selectList FROM VEGAN_OPTIONS;");
		}
		// If submit is clicked then we start making tables
		if (isset($_POST['submit'])){
	?>

	<table align="center" border="1px" style="width:600px; line-height:40px; background-color: green;">
			<tr>
					<th colspan="2"><h2>Vegan Options</h2></th>
				</tr>
				<t>
						<th> Restaurant Name </th>
						<th> Options </th>
				</t>
				<?php
					// Go through each row and print results
					while($row = pg_fetch_assoc($result)) {
				?>
					<tr>
						<td><?php echo $row['rname']; ?></td>
						<td><?php echo $row['options']; ?></td>
					</tr>
				<?php
				}
			}
		// If sustainability is chosen intially
		}elseif($_SESSION["chosenTable"] == 'sustainability'){
	?>
		<ul style="text-align:center">
			<form name="display" action="test.php" method="POST">
				<li>Check all the data you'd like to get:</li>
				<li><input type="checkbox" name="check_list[]" value="tcode"/><label> Town Code </label></li>
				<li><input type="checkbox" name="check_list[]" value="co2_emissions"/><label> CO2 Emissions </label></li>
				<li><input type="checkbox" name="check_list[]" value="energy_per_acre"/><label> Energy Per Acre </label></li>
				<li><input type="checkbox" name="check_list[]" value="sustain_rating"/><label> Sustainability Rating </label></li>
				<li><input type="checkbox" name="check_list[]" value="perc_renew_energy"/><label> Percent Renewable Energy </label></li><br>

				<li>If you'd like, select a datapoint to compare against a value:</li>
				<li><select id="whereTown" name="where">
					<option value="tcode">Town Code</option>
					<option value="co2_emissions">CO2 Emissions</option>
					<option value="energy_per_acre">Energy Per Acre</option>
					<option value="sustain_rating">Sustainability Rating</option>
					<option value="perc_renew_energy">Percent Renewable Energy</option>
				</select></li><br>

				<li>How would you like to check that value?:</li>
				<li><select id="checkTown" name="check">
					<option value="=">Is/Is equal to</option>
					<option value="<">Is less than</option>
					<option value=">">Is greater than</option>
				</select></li><br>

				<li>And that value is?</li>
				<li><input type ="text" name="value"></li>
				<li><input type="submit" name="submit" value="Submit" /></li>
			</form>
		</ul>

	<?php
		// Make selected into a comma seperated list
		$selectList = implode(", ", $_POST['check_list']);
		//Format compare value with basic security measures and proper layout
		$compareValue = "'".strip_tags(trim($_POST[value]))."'";
		//Check if a value is included
		if($_POST[value]){
			$result = pg_query($db, "SELECT $selectList FROM SUSTAINABILITY WHERE $_POST[where] $_POST[check] $compareValue;");
		// If just a select from query
		}elseif($selectList){
			$result = pg_query($db, "SELECT $selectList FROM SUSTAINABILITY;");
		}
		// If submit is clicked then we start making tables
		if (isset($_POST['submit'])){
	?>

	<table align="center" border="1px" style="width:600px; line-height:40px; background-color: green;">
			<tr>
					<th colspan="5"><h2>Sustainability</h2></th>
				</tr>
				<t>
						<th> Town Code </th>
						<th> CO2 Emissions </th>
						<th> Energy Per Acre </th>
						<th> Sustainability Rating </th>
						<th> Percent Renewable Energy </th>
				</t>
				<?php
					// Go through each row and print results
					while($row = pg_fetch_assoc($result))
					{
				?>
					<tr>
						<td><?php echo $row['tcode']; ?></td>
						<td><?php echo $row['co2_emissions']; ?></td>
						<td><?php echo $row['energy_per_acre']; ?></td>
						<td><?php echo $row['sustain_rating']; ?></td>
						<td><?php echo $row['perc_renew_energy']; ?></td>
					</tr>
				<?php
					}
				}
			//If the advanced query option is selected.
			}elseif($_SESSION["chosenTable"] == 'query'){
				?>
				<ul style="text-align:center">
					<form name="display" action="test.php" method="POST" >
						<li>Enter the query below</li>
						<li><input type ="text" name="qry"></li>
						<li><input type="submit" name="submit" value="Submit" /></li>
					</form>
				</ul>
				<?php
				//Once submitted
				if (isset($_POST['submit'])){
					// Some basic validation security formatting
					$result = pg_query($db,strip_tags(trim($_POST[qry])))
				?>
				<table align="center" border="1px" style="width:600px; line-height:40px; background-color: green;">
					<tr>
						<th colspan="4"><h2>Advanced Query Results</h2></th>
					</tr>
					<?php
						// Go through each resulting row and format/print results
						while($row = pg_fetch_row($result))
						{
					?>
							<tr>
								<td><?php
								// Get name of each field and print in one row
								$j = pg_num_fields($result);
								for ($i=0; $i<$j; $i++){
									echo(pg_field_name($result, $i));
									echo "<br>";
								}
								?></td>
								<td><?php 
								// Print values in other row
								echo '<pre>';
								print_r($row);
								echo '</pre>'; 
								?></td>
							</tr>
						<?php
							}
						?>
				</table>
			<?php
			}
		}
		?>
	</table>
	<h4 style="text-align:center">Instructions</h4>
	<p style="text-align:center;">
		First select the category of data you'd like to retrieve from the database by clicking a button. <br>
		Then proceed to choose what types of data you'd like from that dataset. <br>
		You can then press submit or you can further complexify the results by comparing data. <br>
		- Choose which datapoint you'd like to compare against a value. <br>
		- Then select from the dropdown how you'd like to compare it. <br>
		- Lastly, enter the value which you'd like to compare the datapoint against (Remember to use correct capatlization so a match can be found in the database!). <br>
		If desired, you can enter your own PSQL query and submit it for results.
	</p>
</body>
</html>