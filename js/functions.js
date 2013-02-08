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
});