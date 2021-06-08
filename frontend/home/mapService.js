var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(initMap);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

let map;

function updateCoordinates(position) {
    fetch('../../backend/endpoints/updateUserCoordinates.php', {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify(position),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error updating coordinates.');
            }
            return response.json();
        })
        .then((data) => {
            if (data.success === true) {
                console.log("The coordinates are updated successfully.");
            } else {
                console.log('The coordinates are NOT updated successfully.');
            }
        })
        .catch(error => {
            const message = 'Error when updating coordinates.';
            console.log(error);
            console.error(message);
        });
}

function initMap(position) {
  const API_KEY = "AIzaSyDCoz_XLjdVs9EX8VHBxO3YEPiiWMznKi8";

  const currentLocation = {
    lat: position.coords.latitude,
    lng: position.coords.longitude,
  };

  const updateCoords = {
    latitude: position.coords.latitude,
    longitude: position.coords.longitude,
  };
 
    updateCoordinates(updateCoords);

    map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
    center: currentLocation,
  });

  const marker = new google.maps.Marker({
    position: currentLocation,
    map: map,
  });
}

var loc = document.getElementById("location");

loc.addEventListener('keyup', () => {
    searchPlace(loc.value);
})

let infowindow = new google.maps.InfoWindow();

function searchPlace(place){
    // The map, centered at Uluru
    // const map = new google.maps.Map(document.getElementById("map"), {
    //     zoom: 4,
    //     center: currentLocation,
    // });

    const request = {
        query: place,
        fields: ["name", "geometry"],
      };
      let service = new google.maps.places.PlacesService(map);
      service.findPlaceFromQuery(request, (results, status) => {
        if (status === google.maps.places.PlacesServiceStatus.OK && results) {
          for (let i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
          map.setCenter(results[0].geometry.location);
        }
      });
}

// function initMap() {
//   const sydney = new google.maps.LatLng(-33.867, 151.195);
//   infowindow = new google.maps.InfoWindow();
//   map = new google.maps.Map(document.getElementById("map"), {
//     center: sydney,
//     zoom: 15,
//   });
//   const request = {
//     query: "Museum of Contemporary Art Australia",
//     fields: ["name", "geometry"],
//   };
//   service = new google.maps.places.PlacesService(map);
//   service.findPlaceFromQuery(request, (results, status) => {
//     if (status === google.maps.places.PlacesServiceStatus.OK && results) {
//       for (let i = 0; i < results.length; i++) {
//         createMarker(results[i]);
//       }
//       map.setCenter(results[0].geometry.location);
//     }
//   });
// }

function createMarker(place) {
  if (!place.geometry || !place.geometry.location) return;
  const marker = new google.maps.Marker({
    map,
    position: place.geometry.location,
  });
  google.maps.event.addListener(marker, "click", () => {
    infowindow.setContent(place.name || "");
    infowindow.open(map);
  });
}