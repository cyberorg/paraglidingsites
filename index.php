<!DOCTYPE html>
<html lang="en">

<head>
    <title>Paragliding Sites</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Include the Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        #map {
            height: 500px;
            width: 100%;
        }

        @media screen and (max-width: 768px) {
            /* Adjust styles for smaller screens */
            #map {
                height: 300px;
            }

            form {
                display: block;
            }

            select, button {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
	<?php 
	include 'header.html';?>

</head>

<body>
    <div class="container">
        <?php include 'map.php'; ?>
    </div>
<?php include 'footer.html'; ?>

</body>

</html>

