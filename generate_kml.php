<?php
  $country_iso = $_GET['country'];
  $url = "http://www.paraglidingearth.com/api/geojson/getCountrySites.php?iso=" . strtolower($country_iso);
  $json = file_get_contents($url);
  $data = json_decode($json, true);

  // Create a new KML document
  $kml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://earth.google.com/kml/2.1"></kml>');
  $document = $kml->addChild('Document');

  // Add placemarks for each site
  foreach ($data['features'] as $index => $site) {
    $placemark = $document->addChild('Placemark');
    $name = $placemark->addChild('name', $site['properties']['name']);
    $description = $placemark->addChild('description', $site['properties']['takeoff_description'] . ' Altitude: ' . $site['properties']['takeoff_altitude']);
    $point = $placemark->addChild('Point');
    $point->addChild('coordinates', $site['geometry']['coordinates'][0] . ',' . $site['geometry']['coordinates'][1] . ',0');
  }

  // Set headers to download KML file
  header('Content-type: application/vnd.google-earth.kml+xml');
  header('Content-Disposition: attachment; filename="' . $country_iso . '.kml"');

  // Output the KML document
  echo $kml->asXML();
?>

