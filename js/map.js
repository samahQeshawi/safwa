var myLatLng = { lat: 12.9716, lng: 77.5946 };
var mapOptions, map, marker1, marker2, searchBox,directionsService,directionsDisplay
	infoWindow = '',
	start_address = document.querySelector( '#start_destination' ),
	start_lat = document.querySelector( '.start_latitude' ),
	start_long = document.querySelector( '.start_longitude' ),
	end_address = document.querySelector( '#end_destination' ),
	end_lat = document.querySelector( '.end_latitude' ),
	end_long = document.querySelector( '.end_longitude' ),		
	distance_field = document.querySelector( '#distance' ),		
	element = document.getElementById( 'map-canvas' );

 // Till this like of code it loads up the map.




function initialize() {
	mapOptions = {
		// How far the maps zooms in.
		zoom: 8,
		mapTypeControl: false,
		// Current Lat and Long position of the pin/
		center: new google.maps.LatLng( 24.774265, 46.738586 ),
		// center : {
		// 	lat: -34.397,
		// 	lng: 150.644
		// },
		disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
		scrollWheel: true, // If set to false disables the scrolling on the map.
		draggable: true, // If set to false , you cannot move the map around.
		// mapTypeId: google.maps.MapTypeId.HYBRID, // If set to HYBRID its between sat and ROADMAP, Can be set to SATELLITE as well.
		// maxZoom: 11, // Wont allow you to zoom more than this
		// minZoom: 9  // Wont allow you to go more up.

	};

	/**
	 * Creates the map using google function google.maps.Map() by passing the id of canvas and
	 * mapOptions object that we just created above as its parameters.
	 *
	 */
	// Create an object map with the constructor function Map()
	map = new google.maps.Map( element, mapOptions );
	/**
	 * Creates the marker on the map
	 *
	 */
	marker1 = new google.maps.Marker({
		position: mapOptions.center,
		map: map,
		// icon: 'http://pngimages.net/sites/default/files/google-maps-png-image-70164.png',
		draggable: true
	});
	marker2 = new google.maps.Marker({
		position: mapOptions.center,
		map: map,
		// icon: 'http://pngimages.net/sites/default/files/google-maps-png-image-70164.png',
		draggable: true
	});
	directionsService = new google.maps.DirectionsService();
	directionsDisplay = new google.maps.DirectionsRenderer({
								draggable: true,map : map,
								polylineOptions: {
									strokeWeight: 4,
									strokeOpacity: 0.4,
									strokeColor:  'green' 
								},
								//provideRouteAlternatives: true,
								//suppressMarkers: true
							  });	
	/**
	 * Creates a search box
	 */
	searchBox1 = new google.maps.places.SearchBox( start_address );
	searchBox2 = new google.maps.places.SearchBox( end_address );


	/**
	 * When the place is changed on search box, it takes the marker to the searched location.
	 */
	google.maps.event.addListener( searchBox1, 'places_changed', function () {
		var places = searchBox1.getPlaces(),
			bounds = new google.maps.LatLngBounds(),
			i, place, lat, long, resultArray,
			addresss = places[0].formatted_address;

		for( i = 0; place = places[i]; i++ ) {
			bounds.extend( place.geometry.location );
			marker1.setPosition( place.geometry.location );  // Set marker position new.
		}

		map.fitBounds( bounds );  // Fit to the bound
		map.setZoom( 15 ); // This function sets the zoom to 15, meaning zooms to level 15.
		// console.log( map.getZoom() );

		lat = marker1.getPosition().lat();
		long = marker1.getPosition().lng();
		start_lat.value = lat;
		start_long.value = long;

		resultArray =  places[0].address_components;


		// Closes the previous info window if it already exists
		if ( infoWindow ) {
			infoWindow.close();
		}
		/**
		 * Creates the info Window at the top of the marker
		 */
		infoWindow = new google.maps.InfoWindow({
			content: addresss
		});

		infoWindow.open( map, marker1 );
		calculate_route();
	} );

	google.maps.event.addListener( searchBox2, 'places_changed', function () {
		var places = searchBox2.getPlaces(),
			bounds = new google.maps.LatLngBounds(),
			i, place, lat, long, resultArray,
			addresss = places[0].formatted_address;

		for( i = 0; place = places[i]; i++ ) {
			bounds.extend( place.geometry.location );
			marker2.setPosition( place.geometry.location );  // Set marker position new.
		}

		map.fitBounds( bounds );  // Fit to the bound
		map.setZoom( 15 ); // This function sets the zoom to 15, meaning zooms to level 15.
		// console.log( map.getZoom() );

		lat = marker2.getPosition().lat();
		long = marker2.getPosition().lng();
		end_lat.value = lat;
		end_long.value = long;

		resultArray =  places[0].address_components;


		// Closes the previous info window if it already exists
		if ( infoWindow ) {
			infoWindow.close();
		}
		/**
		 * Creates the info Window at the top of the marker
		 */
		infoWindow = new google.maps.InfoWindow({
			content: addresss
		});

		infoWindow.open( map, marker2 );
		calculate_route();
	} );
	/**
	 * Finds the new position of the marker when the marker is dragged.
	 */
	google.maps.event.addListener( marker1, "dragend", function ( event ) {
		var lat, long, address, resultArray, citi;

		lat = marker1.getPosition().lat();
		long = marker1.getPosition().lng();

		var geocoder = new google.maps.Geocoder();
		clearRoute();
		geocoder.geocode( { latLng: marker1.getPosition() }, function ( result, status ) {
			if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
				address = result[0].formatted_address;
				resultArray =  result[0].address_components;

				start_address.value = address;
				start_lat.value = lat;
				start_long.value = long;

			} else {
				console.log( 'Geocode was not successful for the following reason: ' + status );
			}

			// Closes the previous info window if it already exists
			if ( infoWindow ) {
				infoWindow.close();
			}

			/**
			 * Creates the info Window at the top of the marker
			 */
			infoWindow = new google.maps.InfoWindow({
				content: address
			});

			infoWindow.open( map, marker1 );
			calculate_route();
		} );
	});

	google.maps.event.addListener( marker2, "dragend", function ( event ) {
		var lat, long, address, resultArray, citi;

		lat = marker2.getPosition().lat();
		long = marker2.getPosition().lng();

		var geocoder = new google.maps.Geocoder();
		clearRoute();
		geocoder.geocode( { latLng: marker2.getPosition() }, function ( result, status ) {
			if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
				address = result[0].formatted_address;
				resultArray =  result[0].address_components;

				end_address.value = address;
				end_lat.value = lat;
				end_long.value = long;

			} else {
				console.log( 'Geocode was not successful for the following reason: ' + status );
			}

			// Closes the previous info window if it already exists
			if ( infoWindow ) {
				infoWindow.close();
			}

			/**
			 * Creates the info Window at the top of the marker
			 */
			infoWindow = new google.maps.InfoWindow({
				content: address
			});

			infoWindow.open( map, marker2 );
			calculate_route();
		} );
	});
}

function calculate_route(){
						  
	var start = new google.maps.LatLng(start_lat.value, start_long.value);
	var end = new google.maps.LatLng(end_lat.value, end_long.value);	
	var request = {
	  origin:start, 
	  destination:end,
	  travelMode: google.maps.TravelMode.DRIVING,
	  unitSystem: google.maps.UnitSystem.METRIC
	};		
	directionsService.route(request, function (result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			distance_field.value = result.routes[0].legs[0].distance.text;
			directionsDisplay.setDirections(result);
			marker1.setMap(null);
			marker2.setMap(null);			
			google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
				directions = directionsDisplay.getDirections();
				marker1.setPosition( directions.routes[0].legs[0].start_location );
				marker2.setPosition( directions.routes[0].legs[0].end_location );
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode( { latLng: marker1.getPosition() }, function ( result, status ) {
					if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
						var address = result[0].formatted_address;
						start_address.value = address;
					} else {
						console.log( 'Geocode was not successful for the following reason: ' + status );
					}
				});
				geocoder.geocode( { latLng: marker2.getPosition() }, function ( result, status ) {
					if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
						var address = result[0].formatted_address;
						end_address.value = address;
					} else {
						console.log( 'Geocode was not successful for the following reason: ' + status );
					}
				});					
				distance_meter = directions.routes[0].legs[0].distance.value;
				distance_field.value = (distance_meter / 1000) + " km";
				start_lat.value = directions.routes[0].legs[0].start_location.lat();
				start_long.value = directions.routes[0].legs[0].start_location.lng();
				end_lat.value = directions.routes[0].legs[0].end_location.lat();
				end_long.value = directions.routes[0].legs[0].end_location.lng();
			});
		} else {
            directionsDisplay.setDirections({ routes: [] });
            map.setCenter(myLatLng);
            alert("Can't find road! Please try again!");
        }
	});
}

function clearRoute(){
    document.getElementById("distance").value = "";
    document.getElementById("amount").value = "";
    directionsDisplay.setDirections({ routes: [] });
    
}