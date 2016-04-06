/**
 * Created by vaidotas on 16.4.6.
 */
/**
 * Created by vaidotas on 16.4.4.
 */

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPositionInMap,showError);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

var mapDiv = null;
function showPositionInMap(position) {
    //var x = document.getElementById("demo");

    var currentPosition;

    mapDiv = document.getElementById('map');

    var currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    var options = {
        zoom: 15,
        center: currentPosition,
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var generatedMap = new google.maps.Map(mapDiv, options);

    var marker = new google.maps.Marker({
        position: currentPosition,
        map: generatedMap,
        draggable: true,
        navigationControlOptions: {
            style: google.maps.NavigationControlStyle.SMALL
        },
        title:"Pradinė jūsų vieta!"
    });

   // currentPosition=showPositionCoordinates(position);

   // x.innerHTML = "Latitude: " + currentPosition.latitude +
     //   "<br>Longitude: " + currentPosition.longitude;
}

function showPositionCoordinates(position) {
    var currentPosition = new Object();
    currentPosition.latitude=position.coords.latitude;
    currentPosition.longitude=position.coords.longitude;
    return currentPosition;
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}