<?php
	require_once "functions.inc.php";
	$all_ips = getAllIps();
	$countries = getCountries($all_ips);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<style>
			body, html { width: 100%; height: 100%; border: 0; margin: 0; }
		</style>
		<meta charset=utf-8>
		<title>Fail2Ban-Geo</title>
		
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			
				var myOptions = {
				center: new google.maps.LatLng(54, -2),
				zoom: 3,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
				
				var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
				
				
				
				// Function for adding a marker to the page.
				function addMarker(location) {
					marker = new google.maps.Marker({
						position: location,
						map: map
					});
				}
			
				// Loop through markers and add to map
				function AddMarkers() {
					<?php
						foreach($countries as $country)
						{
					?>
					<?php echo $country["iso"]; ?> = new google.maps.LatLng(<?php echo $country["lat"]; ?>, <?php echo $country["lng"]; ?>);
					addMarker(<?php echo $country["iso"]; ?>);
					<?php
						}
					?>
				}
				AddMarkers();
			});
		</script>
	</head>
	<body>
		<div id="map_canvas" style="width: 100%; height: 100%;"></div>
  </body>	
</html>