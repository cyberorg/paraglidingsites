<?php
	$country_data = file_get_contents('https://restcountries.com/v3.1/all');
	$country_data = json_decode($country_data, true);
	usort($country_data, function($a, $b) {
		return strcmp($a['name']['common'], $b['name']['common']);
	});

	$selected_country = isset($_GET['country']) ? $_GET['country'] : '';

	echo '<form action="sites.php" method="GET">';
	echo '<label for="country">Select a country:</label>';
	echo '<select name="country" id="country">';
	foreach ($country_data as $country) {
		$country_data = $country['name']['common'];
		$iso_code = strtolower($country['cca2']);
		$selected = ($selected_country == $iso_code) ? 'selected' : '';
		echo "<option value=\"$iso_code\" $selected>$country_data</option>";
	}
	echo '</select>';
	echo '<button class=button type="submit">Submit</button>';
	echo '</form>';
?>

