<?php
	require_once "functions.inc.php";
	$all_ips = getAllIps();
	$countries = getCountries($all_ips);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset=utf-8>
		<title>Fail2Ban-Geo</title>
		<!--CSS-->
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<!--JavaScript-->
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript">
		// Loop through markers and add to map
		<?php
			foreach($countries as $country)
			{
		?>
			<?php echo $country["iso"]; ?> = new google.maps.LatLng(<?php echo $country["lat"]; ?>, <?php echo $country["lng"]; ?>);
			addMarker(<?php echo $country["iso"]; ?>);
		<?php
			}
		?>
		</script>
	</head>
	<body>
		<div id="map_canvas" style="width: 100%; height: 100%;"></div>
  </body>	
</html>