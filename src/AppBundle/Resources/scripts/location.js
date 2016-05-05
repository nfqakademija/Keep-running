// var currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
var attr  = document.getElementById('map');
var map = null;

function showRoute() {
   getWayPoints();
}

function findPoint(data) {
    return {
        'lat': parseFloat(data["lat"]),
        'lon': parseFloat(data["lon"])
    };
}
function setFitBound(map,data){
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < data.length; i++) {
        var myLatLng = new google.maps.LatLng(data[i]['lat'], data[i]['lon']);
        bounds.extend(myLatLng);
    }
    map.fitBounds(bounds);
}

function findPoints(data) {
    var pointLength = data.length - 1;
    var loopStep = Math.floor(pointLength/15);
    var i = loopStep;
    var points = [];

    points.push(findPoint(data[0]));

    while(i<pointLength-loopStep){
        points.push(findPoint(data[i]));
        i=i+loopStep;
    }

    points.push(findPoint(data[data.length - 1]));

    return points;
}

function groupPoints(wayPoints) {
    var i = 0;
    var groups = {
        'groupA': [],
        'groupB': []
    };

    while (i<wayPoints.length){
        if(i>=0 && i<10){
            groups.groupA.push(wayPoints[i]);
            if(i==9){
                groups.groupB.push(wayPoints[9]);
            }
        }else if(i<19){
            groups.groupB.push(wayPoints[i]);
        }
        i++;
    }

    return groups;
}

function getWayPoints() {
    var wayPointsFromAttribute= JSON.parse(attr.getAttribute('data-points'));
    wayPointsFromAttribute = wayPointsFromAttribute.points;
    var wayPoints = [];
    var points = findPoints(wayPointsFromAttribute);
    var currentPosition = {lat: points[0]['lat'], lng: points[0]['lon']};
    var mapOptions ={
        zoom: 16,
        center:currentPosition/* {lat: 54.89692, lng: 23.93794}*/,
        mapTypeControl: false,
        scrollwheel: false,
        scaleControl: false,
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(attr, mapOptions );
    google.maps.event.addListener(map, 'click', function(event){
        this.setOptions({scrollwheel:true});
    });
    setFitBound(map,points);
    var marker=new google.maps.Marker({
        position:currentPosition,
        icon: 'images/start-marker.png',
        map: map,
        title: 'Startas'
    });

    for (var i = 0; i < points.length; i++) {
        wayPoints.push({
            location: new google.maps.LatLng(points[i]['lat'],points[i]['lon']),
            stopover: true
        });
    }

    var groupedPoints = groupPoints(wayPoints);
    plotTrack(groupedPoints.groupA,'#ff0000');
    plotTrack(groupedPoints.groupB,'#0066ff');
}

function plotTrack(wayPoints,lineColor) {
    var startPoint = wayPoints[0].location;
    var startPointLatitde = startPoint.lat();
    var startPointLongtitude = wayPoints[0].location.lng();
    var endPoint = wayPoints[wayPoints.length-1].location;
    var endPointLatitde = endPoint.lat();
    var endPointLongtitude = endPoint.lng();
    wayPoints.shift();
    wayPoints.pop();

    var request = {
        origin: new google.maps.LatLng(startPointLatitde,startPointLongtitude),
        destination: new google.maps.LatLng(endPointLatitde,endPointLongtitude),
        waypoints: wayPoints,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.WALKING
    };

    var directionsDisplay = [];
    var directionsService = [];



    directionsService.push(new google.maps.DirectionsService());
    directionsDisplay.push(new google.maps.DirectionsRenderer({
        preserveViewport: true,
        suppressMarkers: false,
        polylineOptions: { strokeColor: lineColor,strokeOpacity: 0.7,strokeWeight: 5 }
    }));

    var instance = directionsService.length - 1;
    directionsDisplay[instance].setMap(map);
    directionsService[instance].route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay[instance].setDirections(response);
        }else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}