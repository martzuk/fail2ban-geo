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
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<!--JavaScript-->
		<script type="text/javascript" src="js/jquery-1.9.0.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			
				var myOptions = {
				center: new google.maps.LatLng(26, -2),
				zoom: 2,
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
				function addMarkers() {
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
				addMarkers();
			});
		</script>
	</head>
	<body>
		<h2><a href="https://github.com/martzuk/fail2ban-geo">Fail2Ban-Geo</a></h2>
		<div id="map_canvas"></div>
		<div id="bottom_menu">
			<div class="stat">
				<p><strong>Stats:</p>
				<ul>
					<li><strong>IPs blocked:</strong> <?php echo amountOfBlocks(); ?></li>
					<li><strong>Unique IPs blocked:</strong> <?php echo amountOfIPs(); ?></li>
					<li><strong>Countries blocked:</strong> <?php echo amountOfCountries(); ?></li>
				</ul>
			</div>
			<div class="stat">
				<p><strong>Latest 5 Blocked Countries:</strong></p>
				<ol>
					<?php
						$latest_countries = latestXCountries(5);
						foreach($latest_countries as $country)
						{
							$iso_details = getCoords($country);
					?>
					<li><img src="images/flags/<?php echo $country; ?>.png" alt="<?php echo $iso_details["name"]; ?>" title="<?php echo $iso_details["name"]; ?>" /> <?php echo $iso_details["name"]; ?></li>
					<?php } ?>
				</ol>
			</div>
			<div class="stat">
				<p><strong>Top 5 Blocked Countries:</strong></p>
				<ol>
					<?php
						$top_countries = topXCountries(5);
						foreach($top_countries as $country => $count)
						{
							$iso_details = getCoords($country);
					?>
						<li><img src="images/flags/<?php echo $country; ?>.png" alt="<?php echo $iso_details["name"]; ?>" title="<?php echo $iso_details["name"]; ?>" /> : <?php echo $iso_details["name"] . " (" . $count . ")" ; ?></li>
						
					<?php } ?>
				</ol>
			</div>
		</div>
	</body>	
</html>