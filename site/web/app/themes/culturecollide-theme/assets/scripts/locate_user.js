function success(position) {
  var latitude  = position.coords.latitude;
  var longitude = position.coords.longitude;
  var coords = {
    latitude: latitude,
    longitude: longitude
  };
  var sortedCities = _.sortBy(map_info.cities, function( city ) {
    var cityCoords = {
      latitude: city.location.lat,
      longitude: city.location.lng
    };
    return haversine(coords, cityCoords);
  });
  var closestCity = sortedCities[0];
  output = 'Latitude is ' + latitude + '° Longitude is ' + longitude + '° and closest city is ' + closestCity.title;

  console.log(output);
  window.location = closestCity.link;
}

function error() {
  console.warn("Unable to retrieve your location");
}

jQuery(function($){
	$('.travel__navigation__button').click(function (e) {
    e.preventDefault();
    console.dir('starting locate user');
    navigator.geolocation.getCurrentPosition(success, error);
		// $.post(ajax_object.ajaxurl, {
		// 	action: 'ajax_action',
		// 	post_id: $(this).find('input.post_id').attr('value')
		// }, function(data) {
		// 	alert(data); // alerts 'ajax submitted'
		// });
	});
});
