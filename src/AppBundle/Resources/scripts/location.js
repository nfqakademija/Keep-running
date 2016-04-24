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
    var pointLength=waypoints.length-1;
    var firstRoutePoints = waypoints[0];
    var lastRoutePoints = waypoints[pointLength];

    var firstRoutePointLatitude = parseFloat(firstRoutePoints["lat"]);
    var firstRoutePointLongtitude = parseFloat(firstRoutePoints["lon"]);

    waypts.push({
        location: new google.maps.LatLng(firstRoutePointLatitude,firstRoutePointLongtitude),
        stopover: true
    });

    var loopStep = Math.floor(pointLength/8);

    var i = loopStep;
    var needPointsLenght = pointLength - loopStep;
    while(i<pointLength){
        var routeLatitude = parseFloat(waypoints[i]["lat"]);
        var routeLongtitude = parseFloat(waypoints[i]["lon"]);
        waypts.push({
            location: new google.maps.LatLng(routeLatitude,routeLongtitude),
            stopover: true
        });
        i=i+loopStep;
    }
    var lastRoutePointLatitude = parseFloat(lastRoutePoints["lat"]);
    var lastRoutePointLongtitude = parseFloat(lastRoutePoints["lon"]);

    waypts.push({
        location: new google.maps.LatLng(lastRoutePointLatitude,lastRoutePointLongtitude),
        stopover: true
    });

    return waypts;
}

function plotTrack(directionsDisplay, wayPoints) {
    var directionsService = new google.maps.DirectionsService;
    var startPoint = wayPoints[0].location
    var startPointLatitde = startPoint.lat();
    var startPointLongtitude = wayPoints[0].location.lng();
    var endPoint = wayPoints[wayPoints.length-1].location;
    var endPointLatitde = endPoint.lat();
    var endPointLongtitude = endPoint.lng();
    wayPoints.shift();
    wayPoints.pop();
    directionsService.route({
        origin: new google.maps.LatLng(startPointLatitde,startPointLongtitude),
        destination: new google.maps.LatLng(endPointLatitde,endPointLongtitude),
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