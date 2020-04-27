<!-- CSC 315 - NJSus Database Final Project
Matthew Izzo, Joseph Candiano, Sam Hajnassrollahi, Babette Chao -->
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
			<li>Enter column(s) to retrieve:</li><li><input type="text" name="columnSelect" /></li>
			<li>From which table?:</li><li><select id="table" name="table">
				<option value="town">Towns</option>
				<option value="restaurant">Restaurants</option>
				<option value="vegan_options">Vegan Options</option>
				<option value="sustainability">Sustainability</option>
			</select></li>
			<li>What column to check?:</li><li><input type="text" name="columnWhere" /></li>
			<li>What value to compare column to?:</li><li><input type="text" name="value" /></li>
			<li>Enter your own query below:</li><li><input type="text" name="qry" /></li>
			<li><input type="submit" name="submit" value="submit" /></li>
		</form>
	</ul>
	<h4 style="text-align:center">Instructions</h4>
	<p style="text-align:center;">
		You can select from the following columns, in combination if desired (seperate by commas): <br>
		- Towns: tcode (town code), tname (town name), county, sustain_rating (sustainability rating) <br>
		- Restaurants: rname (restaurant name), tcode (town code), vegan_friendly (vegan friendly?), rest_sustain_rating (restaurant sustainability rating), address <br>
		- Vegan Options: rname (restaurant name), options (list of vegan options) <br>
		- Sustainability: tcode (town code), co2_emissions, energy_per_acre, sustain_rating (sustainability rating), perc_renew_energy (percent renewable energy) <br>
		Make sure to surround Values in quotes. E.g. 'Blairstown'
	</p>
	<?php
		// Connect to database
		$db = pg_connect("host=localhost port=5432 dbname=njsus user=osc password=osc");
		// If user entered their own query, run it
		if($_POST[qry]){
			$result2 = pg_query($db, $_POST[qry]);
	?>
			<table align="center" border="1px" style="width:600px; line-height:40px; background-color: green;">
				<tr>
					<th colspan="4"><h2>Advanced Query Results</h2></th>
				</tr>
				<?php
					// Go through each resulting row and format/print results
					while($row = pg_fetch_row($result2))
					{
				?>
						<tr>
							<td><?php
							// Get name of each field and print in one row
							$j = pg_num_fields($result2);
							for ($i=0; $i<$j; $i++){
								echo(pg_field_name($result2, $i));
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
		//Check if a where is included
		}elseif($_POST[columnWhere] && !($_POST[qry])){
			$result = pg_query($db, "SELECT $_POST[columnSelect] FROM $_POST[table] WHERE $_POST[columnWhere] = $_POST[value];");
		// If just a select from query
		}elseif($_POST[table] && !($_POST[qry])){
			$result = pg_query($db, "SELECT $_POST[columnSelect] FROM $_POST[table];");
		}
		// If submit is clicked then we start making tables
		if (isset($_POST['submit'])){
	?>

	<table align="center" border="1px" style="width:600px; line-height:40px; background-color: green;">
		<?php
			// If town is the table
			if($_POST[table]=="town" && !($_POST[qry])){
		?>
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
				while($row = pg_fetch_assoc($result))
				{
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
			// If restaurant is the table
			}elseif($_POST[table]=="restaurant"){
		?>
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
				?>
			<?php
				// If vegan options is the table
				}elseif($_POST[table]=="vegan_options"){
			?>
				<tr>
					<th colspan="2"><h2>Vegan Options</h2></th>
				</tr>
				<t>
						<th> Restaurant Name </th>
						<th> Options </th>
				</t>
				<?php
					// Go through each row and print results
					while($row = pg_fetch_assoc($result))
					{
				?>
					<tr>
						<td><?php echo $row['rname']; ?></td>
						<td><?php echo $row['options']; ?></td>
					</tr>
				<?php
					}
				?>
			<?php
				// If sustainability is the table
				}elseif($_POST[table]=="sustainability"){
			?>
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
				?>
		<?php
			}
		}
		?>
	</table>
</body>
</html>