
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(initMap);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function initMap(position) {

  const API_KEY = "AIzaSyDCoz_XLjdVs9EX8VHBxO3YEPiiWMznKi8";

  // The location of Uluru
  const currentLocation = {
    lat: position.coords.latitude,
    lng: position.coords.longitude,
  };
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: currentLocation,
  });
  // The marker, positioned at Uluru
  const marker = new google.maps.Marker({
    position: currentLocation,
    map: map,
  });
}

