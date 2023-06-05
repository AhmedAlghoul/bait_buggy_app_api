// focusable markers.
// function initMap() {
//     const map = new google.maps.Map(document.getElementById("map"), {
//         zoom: 10.1,
//         center: { lat: 31.357896523412904, lng: 34.30916933057565 },

//     });

//     // Create an info window to share between markers.
//     const infoWindow = new google.maps.InfoWindow();

//     var marker = new google.maps.Marker({
//         position: { lat: 31.357896523412904, lng: 34.30916933057565 },
//         map: map,
//         draggable: true,
//         title: "Drag me!"
//     });

// }
// ///////////////

// // Add an event listener to the marker's "dragend" event
// marker.addListener('dragend', function (event) {
//     // Get the updated position of the marker
//     var latitude = event.latLng.lat();
//     var longitude = event.latLng.lng();

//     // Set the latitude and longitude values in input fields
//     document.getElementById('latitude').value = latitude;
//     document.getElementById('longitude').value = longitude;

//     // Retrieve the address based on the latitude and longitude
//     var geocoder = new google.maps.Geocoder();
//     geocoder.geocode({ 'location': event.latLng }, function (results, status) {
//         if (status === 'OK') {
//             if (results[0]) {
//                 // Set the address value in the input field
//                 document.getElementById('address').value = results[0].formatted_address;
//             }
//         }
//     });
// });


// /////////////////////
// window.initMap = initMap;



//new
function initMap() {
    // Create a map object
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10.1,
        center: { lat: 31.357896523412904, lng: 34.30916933057565 }
    });

    // Create a marker variable
    var marker = new google.maps.Marker({
        position: { lat: 31.357896523412904, lng: 34.30916933057565 },
        map: map,
        draggable: true,
        title: "Drag me!"
    });

    // Add an event listener to the marker's "dragend" event
    marker.addListener('dragend', function (event) {
        // Get the updated position of the marker
        var latitude = event.latLng.lat();
        var longitude = event.latLng.lng();

        // Set the latitude and longitude values in input fields
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;

        // Retrieve the address based on the latitude and longitude
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'location': event.latLng }, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    // Set the address value in the input field as a string
                    var address = results[0].formatted_address;
                    document.getElementById('address').value = address;
                }
            }
        });
    });
}
