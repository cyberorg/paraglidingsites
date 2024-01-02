		<?php
			$iso_code = $_GET['country'];
			$country_names = file_get_contents('https://restcountries.com/v3.1/all');
			$country_names = json_decode($country_names, true);
			foreach ($country_names as $country) {
				if (strtolower($country['cca2']) == $iso_code) {
					$country_name = $country['name']['common'];
					break;
				}
			}
			if (empty($country_name)){
				$country_name = 'India';
			}

			echo "<h1>Paragliding Sites in $country_name</h1>";
		?>

<div id="map"></div>
