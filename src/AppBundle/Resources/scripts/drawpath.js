/**
 * Created by povilas on 16.4.13.
 */
    //map DOM pasirinkimas
var mapDiv = null;
    //masyvas
var path = null;

mapDiv = document.getElementById('map');
path = JSON.parse(document.getElementById('path'));
//esama vieta centruoti
var currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: currentPosition,
        mapTypeId: google.maps.MapTypeId.HYBRID
    });
    var line = new google.maps.Polyline({
        path: [{lat: 22.291, lng: 153.027}, {lat: 18.291, lng: 153.027}],
        strokeOpacity: 0,
        icons: [{
            icon: lineSymbol,
            offset: '0',
            repeat: '20px'
        }],
        map: map
    });
//galinis map kuri piesiam
    var generatedMap = new google.maps.Map(mapDiv, options);
}