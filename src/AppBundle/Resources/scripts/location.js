// var currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
var attr  = document.getElementById('map');
var directionsDisplay = [];
var directionsService = [];
var map = null;
function showRoute() {
   getWayPoints();
}

function initMap() {
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center:currentPosition/* {lat: 54.89692, lng: 23.93794}*/,
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    directionsDisplay.setMap(map);

    return directionsDisplay;
}

function getWayPoints() {

    //var directionsDisplay = new google.maps.DirectionsRenderer;
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var wayPoints = [];
    var wayPointsFromAttribute= JSON.parse(attr.getAttribute('data-points'));
    wayPointsFromAttribute = wayPointsFromAttribute.points;
    var pointLength=wayPointsFromAttribute.length-1;
    //First rout point
    var firstRoutePoints = wayPointsFromAttribute[0];
    //Last rout point
    var lastRoutePoints = wayPointsFromAttribute[pointLength];
    //First rout point Latitude and longtitude
    var firstRoutePointLatitude = parseFloat(firstRoutePoints["lat"]);
    var firstRoutePointLongtitude = parseFloat(firstRoutePoints["lon"]);

    wayPoints.push({
        location: new google.maps.LatLng(firstRoutePointLatitude,firstRoutePointLongtitude),
        stopover: true
    });
    var loopStep = Math.floor(pointLength/15);

    var i = loopStep;
    while(i<pointLength){
        var routeLatitude = parseFloat(wayPointsFromAttribute[i]["lat"]);
        var routeLongtitude = parseFloat(wayPointsFromAttribute[i]["lon"]);
        wayPoints.push({
            location: new google.maps.LatLng(routeLatitude,routeLongtitude),
            stopover: true
        });
        i=i+loopStep;
    }
    //Last rout point Latitude and longtitude
    var lastRoutePointLatitude = parseFloat(lastRoutePoints["lat"]);
    var lastRoutePointLongtitude = parseFloat(lastRoutePoints["lon"]);

    wayPoints.push({
        location: new google.maps.LatLng(lastRoutePointLatitude,lastRoutePointLongtitude),
        stopover: true
    });

    var i = 0;
    var tmpWayPointsArray1=[];
    var tmpWayPointsArray2=[];
    while (i<wayPoints.length){
        if(i>=0 && i<10){
            tmpWayPointsArray1.push(wayPoints[i]);
             if(i==9){
                    tmpWayPointsArray2.push(wayPoints[9]);
             }
        }else{
            tmpWayPointsArray2.push(wayPoints[i]);
        }
        i++;
    }
    plotTrack(tmpWayPointsArray1);
    //plotTrack(tmpWayPointsArray2);
}

function plotTrack(wayPoints) {
    var startPoint = wayPoints[0].location
    var startPointLatitde = startPoint.lat();
    var startPointLongtitude = wayPoints[0].location.lng();
    var endPoint = wayPoints[wayPoints.length-1].location;
    var endPointLatitde = endPoint.lat();
    var endPointLongtitude = endPoint.lng();
    wayPoints.shift();
    wayPoints.pop();

    var request ={
        origin: new google.maps.LatLng(startPointLatitde,startPointLongtitude),
        destination: new google.maps.LatLng(endPointLatitde,endPointLongtitude),
        waypoints: wayPoints,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.WALKING
    };
    directionsService.push(new google.maps.DirectionsService());
    var instance = directionsService.length - 1;
    directionsDisplay.push(new google.maps.DirectionsRenderer({
        preserveViewport: true
    }));
    directionsDisplay[instance].setMap(map);
    directionsService[instance].route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            console.log(status);
            directionsDisplay[instance].setDirections(response);
        }else {
            window.alert('Directions request failed due to ' + status);
        }
    });

}