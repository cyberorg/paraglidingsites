<!DOCTYPE html>
<html>
<head>
	<title>Paragliding Sites</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<?php include 'header.html'; ?>
</head>
<body>
	<div class="container">
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
			echo "<h1>Paragliding Sites in $country_name</h1>";
		?>
		<a href="generate_kml.php?country=<?php echo $iso_code; ?>" class="button">Download KML</a><br>
		<table>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Description</th>
				<th>Altitude</th>
				<th>Latitude</th>
				<th>Longitude</th>
				<th>Link</th>
			</tr>
			<?php
				$url = "http://www.paraglidingearth.com/api/geojson/getCountrySites.php?iso=$iso_code";
				$data = file_get_contents($url);
				$data = json_decode($data, true);
				$sites = $data['features'];
				usort($sites, function($a, $b) {
					return strcmp($a['properties']['name'], $b['properties']['name']);
				});
				$count = 1;
				foreach ($sites as $site) {
					$name = $site['properties']['name'];
					$description = $site['properties']['takeoff_description'];
					$altitude = $site['properties']['takeoff_altitude'];
					$latitude = $site['geometry']['coordinates'][1];
					$longitude = $site['geometry']['coordinates'][0];
					$link = $site['properties']['pge_link'];
					echo "<tr>";
					echo "<td>$count</td>";
					echo "<td>$name</td>";
					echo "<td>$description</td>";
					echo "<td>$altitude</td>";
					echo "<td>$latitude</td>";
					echo "<td>$longitude</td>";
					echo "<td><a href=\"$link\">Link</a></td>";
					echo "</tr>";
					$count++;
				}
			?>
		</table>
	</div>
</body>
</html>
<?php include 'footer.html'; ?>

