// var currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
var currentPosition = {lat: 54.89692, lng: 23.93794};
var attr  = document.getElementById('map');

function showRoute() {
    var directionsDisplay = initMap();
    var wayPoints = getWayPoints();
    plotTrack(directionsDisplay, wayPoints);
}

function initMap() {
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center:currentPosition/* {lat: 54.89692, lng: 23.93794}*/,
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.SATELITE
    });
    directionsDisplay.setMap(map);

    return directionsDisplay;
}

function getWayPoints() {
    var waypts = [];
    var waypoints = JSON.parse(attr.getAttribute('data-points'));
    waypoints = waypoints.points;

   /* var waypoints =    [
        {"lat": "54.89592", "lon": "23.93767"},
        {"lat": "54.89909", "lon": "23.93947"},
        {"lat": "54.89932", "lon": "23.93998"},
        {"lat": "54.89587", "lon": "23.94828"},
        {"lat": "54.89721", "lon": "23.94579"},
        {"lat": "54.90215", "lon": "23.94608"},
        {"lat": "54.90008", "lon": "23.9423"},
        {"lat": "54.9019", "lon": "23.9388"}
    ];*/

    for (var i = 0; i <7 /*waypoints.length*/; i++) {
        var lat = parseFloat(waypoints[i]["lat"]);
        var lon = parseFloat(waypoints[i]["lon"]);
        waypts.push({
            location: new google.maps.LatLng(lat,lon),
            stopover: true
        });
    }

    return waypts;
}

function plotTrack(directionsDisplay, wayPoints) {
    var directionsService = new google.maps.DirectionsService;

    directionsService.route({
        origin: new google.maps.LatLng(54.89692,23.93794),
        destination: new google.maps.LatLng(54.89859,23.93921),
        waypoints: wayPoints,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.WALKING
    }, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}