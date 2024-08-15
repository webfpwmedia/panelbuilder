var mapCanvas = document.getElementById( 'map-canvas' );

function initMap() {
	
	if ( ! mapCanvas ) {
		return false;
	}
	var map;
	var marker;
				
	var mapOptions = {
	    center: { lat: parseFloat( fq_map.gmap_lat ), lng: parseFloat( fq_map.gmap_lng ) },
	    zoom: 15,
		scrollwheel: false	
	}
	
	map = new google.maps.Map( mapCanvas, mapOptions );

	var contentString =
	'<div class="map-pin-content">'+
	'<p>' + fq_map.gmap_content + '</p>'+
	'</div>';

	infowindow = new google.maps.InfoWindow({
		content: contentString,
		maxWidth: 800
	}),
 	marker = new google.maps.Marker({
		map: map,
		animation: google.maps.Animation.DROP,
		position: { lat: parseFloat( fq_map.gmap_lat ), lng: parseFloat( fq_map.gmap_lng ) },
        title: fq_map.gmap_marker_title,
 	});

	marker.setMap(map);

    marker.addListener('click', function() {
      infowindow.open( map, marker );
    });
}
