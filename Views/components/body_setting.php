<?php



?>

<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="../libraries/leaflet.js"></script>
  <link rel="stylesheet" href="css/settingPage.css">
</head>

<body>
  <div class="weather-setting-container">
    <h3 class="setting-title">Weather Setting</h3>
    <div class="weather-setting-body">
      <div class="form-container">
        <form action="#" class="weather-search-form">
          <div class="form-group weather-location-search-form">
            <label for="input-city">Search where you live</label>
            <input type="text" id="input-city" placeholder="Type here...">
          </div>
          <div class="form-group">
            <button type="submit" onclick="searchLocation(event)">Search</button>
          </div>
        </form>
        <form action="#" onsubmit="userPositionSubmit(event)" id="user-position-form">
          <div>
            <div class="form-group">
              <label for="input-latitude">Latitude</label>
              <input type="text" id="input-latitude" placeholder="latitude">
            </div>
            <div class="form-group">
              <label for="input-longitude">Longitude</label>
              <input type="text" id="input-longitude" placeholder="longitude">
            </div>
          </div>
          <div class="form-group submit-button">
            <button id="get-user-position" onclick="getPosition(event)">Get Position</button>
            <button type="submit" id="user-position-submit">Confirm</button>
          </div>
        </form>
      </div>

      <div id="map"></div>
    </div>
  </div>





  <script>
    var latitude = '<?= isset($_COOKIE['latitude']) ? $_COOKIE['latitude'] : 9.75 ?>';
    var longitude = '<?= isset($_COOKIE['longitude']) ? $_COOKIE['longitude'] : 105.75 ?>';
    var cityName = '<?= isset($_COOKIE['cityName']) ? $_COOKIE['cityName'] : 'Hậu Giang' ?>';

    $(document).ready(() => {
      $(".loading-layer").addClass("loading-layer-hide");
    })

    // set location cookie
    function setLocationCookie(latitude, longitude, cityName) {
      var d = new Date();

      // 365 days
      var expirationDays = 365;
      d.setTime(d.getTime() + (expirationDays * 24 * 60 * 60 * 1000));
      var expires = "expires=" + d.toUTCString();

      document.cookie = `latitude=${latitude};${expires};path=/`;
      document.cookie = `longitude=${longitude};${expires};path=/`;
      document.cookie = `cityName=${cityName};${expires};path=/`;
    }

    console.log(document.cookie)

    // map
    var map = L.map('map').setView([latitude, longitude], 10);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


    function reloadMap(latitude, longitude) {
      map.setView([latitude, longitude], 13);
      map.invalidateSize();
    }


    function getPosition(event) {
      event.preventDefault();

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
          $("#input-latitude").val(position.coords.latitude.toFixed(6));
          $("#input-longitude").val(position.coords.longitude.toFixed(6));

          reloadMap(position.coords.latitude, position.coords.longitude);
        });
      }
    }



    function userPositionSubmit(event) {
      event.preventDefault();
      var latitude = $("#input-latitude").val();
      var longitude = $("#input-longitude").val();

      reloadMap(latitude, longitude);
    }


    // find location
    function searchLocation(event) {
      event.preventDefault();

      var city = $("#input-city").val();

      var url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(city)}`;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          var latitude = (Number(data[0].boundingbox[0]) + Number(data[0].boundingbox[1])) / 2;
          var longitude = (Number(data[0].boundingbox[2]) + Number(data[0].boundingbox[3])) / 2;

          reloadMap(latitude, longitude);

          $("#input-latitude").val(latitude.toFixed(6));
          $("#input-longitude").val(longitude.toFixed(6));
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

    function userPositionSubmit(event) {
      event.preventDefault();

      var latitude = $("#input-latitude").val();
      var longitude = $("#input-longitude").val();
      var city = $("#input-city").val();

      setLocationCookie(latitude, longitude, city);
    }

  </script>

</body>