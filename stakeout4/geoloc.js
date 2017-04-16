$(document).ready(function(){
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(displayLocation);
	} else { 
		$('#location').html('Geolocation is not supported by this browser.');
	}
});

function displayLocation(position) {
	var lat = position.coords.latitude;
	var lng = position.coords.longitude;
	document.getElementById('txtlat').value = lat;
	document.getElementById('txtlng').value = lng;
    }