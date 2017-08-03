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
  window.location = closestCity.link;
}

function error() {
  console.warn("Unable to retrieve your location");
}

jQuery(function($){
	$('.travel__navigation__button').click(function (e) {
    e.preventDefault();
    navigator.geolocation.getCurrentPosition(success, error);
	});
});
