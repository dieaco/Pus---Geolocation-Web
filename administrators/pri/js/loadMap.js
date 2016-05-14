/*Mapa de SensorSafe*/

var map;

function iniciarMapa(){

	var myLatlng = new google.maps.LatLng(19.5447313,-99.1682599);

	var mapOptions = {
		center: myLatlng,
		zoom: 10,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById('map'),mapOptions);

	//Marcador de la Ubicación
	var marker = new google.maps.Marker({
		position: myLatlng,
		title:'SensorSafe | Servicio a Cajeros Automáticos y más...'
	});
	marker.setMap(map);

	// Ampliación al presionar en el marcador de la ubicación
	google.maps.event.addListener(marker,'click',function() {
		map.setZoom(17);
	    map.setCenter(marker.getPosition());
	  });
  

  	//google.maps.event.addDomListener(window, 'load', iniciarMapa);
}

google.maps.event.addDomListener(window, 'load', iniciarMapa);