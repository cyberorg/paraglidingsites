<!-- map.php -->
<!DOCTYPE html>
   <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places" type="text/javascript"></script>

<?php
$country = $_GET['country'] ?? 'in';

$data = file_get_contents("http://www.paraglidingearth.com/api/geojson/getCountrySites.php?iso=$country");
$json = json_decode($data);

$markers = [];

foreach ($json->features as $feature) {
    $coords = $feature->geometry->coordinates;
    $name = $feature->properties->name;
    $desc = $feature->properties->takeoff_description;
    $link = $feature->properties->pge_link;

    $markers[] = [
        "name" => $name,
        "desc" => $desc,
        "link" => $link,
        "lat" => $coords[1],
        "lng" => $coords[0]
    ];
}

// Get the center coordinates for the selected country
$centerCoords = isset($markers[0]) ? $markers[0] : ['lat' => 22.9734, 'lng' => 78.6569];
?>

<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: <?= $centerCoords['lat'] ?>, lng: <?= $centerCoords['lng'] ?> },
            zoom: 4 
        });

        <?php foreach ($markers as $marker): ?>
            addMarker(<?= json_encode(htmlspecialchars($marker['lat'])); ?>, <?= json_encode(htmlspecialchars($marker['lng'])); ?>, <?= json_encode(htmlspecialchars($marker['name'])); ?>, <?= json_encode(nl2br(htmlspecialchars($marker['desc']))); ?>, <?= json_encode(htmlspecialchars($marker['link'])); ?>);
        <?php endforeach; ?>
    }

    function addMarker(lat, lng, name, desc, link) {
        var marker = new google.maps.Marker({
            position: { lat: parseFloat(lat), lng: parseFloat(lng) },
            map: map,
            title: name
        });

        var contentString = '<h3>' + name + '</h3>' +
            '<p>' + desc + '</p>' +
            '<p><a href="' + link + '" target="_blank">More Info</a></p>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        marker.addListener('click', function () {
            infowindow.open(map, marker);
        });
    }

    google.maps.event.addDomListener(window, 'load', initMap);
</script>
   <div class="container">
        <?php include 'map-render.php'; ?>
    </div>
