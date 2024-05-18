<?php
// if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
//   header("Location: login.php");
//   exit();
// }

$latitude = isset($_COOKIE['latitude']) ? $_COOKIE['latitude'] : 9.75;
$longitude = isset($_COOKIE['longitude']) ? $_COOKIE['longitude'] : 105.75;

// fetch weather data
$url = "https://api.open-meteo.com/v1/forecast?latitude=$latitude&longitude=$longitude&current=temperature_2m,relative_humidity_2m,wind_speed_10m,wind_direction_10m&hourly=temperature_2m,relative_humidity_2m,precipitation_probability,precipitation,rain,cloud_cover,evapotranspiration,wind_speed_10m,soil_temperature_0cm&daily=temperature_2m_max,temperature_2m_min,sunshine_duration,uv_index_max,precipitation_probability_max,wind_speed_10m_max,wind_direction_10m_dominant&timezone=Asia%2FBangkok";

if (!isset($data)) {
  $data = file_get_contents($url, true);
  $data = json_decode($data, true);
}

date_default_timezone_set("Asia/Bangkok");
$currentHour = date("H");

if ($currentHour < 10)
  $currentHour = str_replace("0", "", $currentHour);

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Content-Type: application/json');
  echo json_encode($data);
  exit();
}

// user position cookie
// $_COOKIE['latitude'] = 9.75;
// $_COOKIE['longitude'] = 105.75;
?>

<head>
  <link rel="stylesheet" href="css/weatherPage.css">
</head>

<body>
  <?php if (!isset($_COOKIE['latitude']) || !isset($_COOKIE['longitude'])): ?>
    <div class="alert-message-container">
      You haven't set your location yet, we need your location to provide weather data, go to settings and set it!
    </div>
  <?php endif; ?>

  <h1 class="weather-title">In The Next Seven Hours</h1>
  <div class="temperature-container">
    <?php
    if ($currentHour > 17)
      $currentHour = 17;

    for ($hour = $currentHour; $hour < $currentHour + 7; $hour++):
      ?>
      <div class="temperature-hour-container <?php if ($hour == date("H"))
        echo "current-hour" ?>">
          <p class="hour-temperature-text"><?= $hour . ":00" ?></p>
        <div class="weather-svg-container">
          <svg height="50px" width="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="5" stroke="#1C274C" stroke-width="1.5" />
            <path d="M12 2V4" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
            <path d="M12 20V22" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
            <path d="M4 12L2 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 12L20 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
            <path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="#1C274C" stroke-width="1.5"
              stroke-linecap="round" />
            <path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="#1C274C" stroke-width="1.5"
              stroke-linecap="round" />
            <path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="#1C274C" stroke-width="1.5"
              stroke-linecap="round" />
            <path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="#1C274C" stroke-width="1.5"
              stroke-linecap="round" />
          </svg>
        </div>
        <div>
          <p><?= $data['hourly']['temperature_2m'][$hour] . "°C" ?></p>
          <p><?= $data['hourly']['relative_humidity_2m'][$hour] . "%" ?></p>
          <p class="precipitation_probability-hour-info">
            <svg width="25px" height="25px" viewBox="0 0 1024 1024" class="icon" version="1.1"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M700.6 188.2c-58.4 0-110.4 31.3-144.2 80.1-21.4-32.7-55.3-53.9-93.6-53.9-58 0-106.1 48.5-115.4 112h-44.9c-68.5 0-123.9 63.7-123.9 142.3 0 78.6 55.5 142.3 123.9 142.3h398.1c101.7 0 184.1-94.6 184.1-211.3 0-116.9-82.4-211.5-184.1-211.5z"
                fill="#FFFFFF" />
              <path
                d="M700.6 164.7c-54.6 0-106 24.6-144.2 68.2-25.3-27-58.3-42-93.6-42-61.6 0-114.6 46.1-131.9 112h-28.4c-79.8 0-144.7 74.4-144.7 165.8s64.9 165.7 144.7 165.7h398.1c113 0 204.9-105.3 204.9-234.8 0-129.6-91.9-234.9-204.9-234.9z m0 422.7H302.5c-56.9 0-103.2-53.3-103.2-118.8s46.3-118.8 103.2-118.8h44.9c10.2 0 18.8-8.3 20.5-19.6 7.8-53.5 47.8-92.4 94.9-92.4 30.5 0 58.5 16.2 76.9 44.4 3.9 5.9 9.9 9.4 16.4 9.5 6.1 0 12.6-3.2 16.6-9 31.3-45.2 77.8-71.1 127.8-71.1 90.1 0 163.4 84.3 163.4 187.9 0.1 103.6-73.2 187.9-163.3 187.9zM286.9 688.4L163.8 829.3c-8.1 9.2-8 24.1 0.2 33.2 4 4.5 9.3 6.8 14.6 6.8 5.4 0 10.7-2.3 14.8-7l123.1-140.9c8.1-9.2 8-24.1-0.2-33.2-8.2-9.2-21.4-9.1-29.4 0.2zM478.2 688.2c-8.2-9.1-21.3-9-29.4 0.2l-61.5 70.4c-8.1 9.2-8 24.1 0.2 33.2 4 4.5 9.3 6.8 14.6 6.8 5.4 0 10.7-2.3 14.8-7l61.5-70.4c8.1-9.3 8-24.1-0.2-33.2zM775.3 688.4l-61.5 70.4c-8.1 9.2-8 24.1 0.2 33.2 4 4.5 9.3 6.8 14.6 6.8 5.4 0 10.7-2.3 14.8-7l61.5-70.4c8.1-9.2 8-24.1-0.2-33.2-8.2-9.2-21.3-9.1-29.4 0.2zM613.5 688.4L490.4 829.3c-8.1 9.2-8 24.1 0.2 33.2 4 4.5 9.3 6.8 14.6 6.8 5.4 0 10.7-2.3 14.8-7l123-140.9c8.1-9.2 8-24.1-0.2-33.2-8.1-9.2-21.3-9.1-29.3 0.2z"
                fill="#211F1E" />
            </svg>
            <?= $data['hourly']['precipitation_probability'][$hour] ?> %
          </p>
        </div>
      </div>
      <?php
    endfor;
    ?>
  </div>

  <h1 class="weather-title">Current Weather</h1>
  <div class="current-weather-container">
    <div class="current-weather">
      <div class="current-weather-svg">
        <svg fill="#000000" width="80px" height="80px" viewBox="0 0 32 32" version="1.1"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M20.75 6.008c0-6.246-9.501-6.248-9.5 0v13.238c-1.235 1.224-2 2.921-2 4.796 0 3.728 3.022 6.75 6.75 6.75s6.75-3.022 6.75-6.75c0-1.875-0.765-3.572-2-4.796l-0.001-0zM16 29.25c-2.9-0-5.25-2.351-5.25-5.251 0-1.553 0.674-2.948 1.745-3.909l0.005-0.004 0.006-0.012c0.13-0.122 0.215-0.29 0.231-0.477l0-0.003c0.001-0.014 0.007-0.024 0.008-0.038l0.006-0.029v-13.52c-0.003-0.053-0.005-0.115-0.005-0.178 0-1.704 1.381-3.085 3.085-3.085 0.060 0 0.12 0.002 0.179 0.005l-0.008-0c0.051-0.003 0.11-0.005 0.17-0.005 1.704 0 3.085 1.381 3.085 3.085 0 0.063-0.002 0.125-0.006 0.186l0-0.008v13.52l0.006 0.029 0.007 0.036c0.015 0.191 0.101 0.36 0.231 0.482l0 0 0.006 0.012c1.076 0.966 1.75 2.361 1.75 3.913 0 2.9-2.35 5.25-5.25 5.251h-0zM16.75 21.367v-3.765c0-0.414-0.336-0.75-0.75-0.75s-0.75 0.336-0.75 0.75v0 3.765c-1.164 0.338-2 1.394-2 2.646 0 1.519 1.231 2.75 2.75 2.75s2.75-1.231 2.75-2.75c0-1.252-0.836-2.308-1.981-2.641l-0.019-0.005zM26.5 2.25c-1.795 0-3.25 1.455-3.25 3.25s1.455 3.25 3.25 3.25c1.795 0 3.25-1.455 3.25-3.25v0c-0.002-1.794-1.456-3.248-3.25-3.25h-0zM26.5 7.25c-0.966 0-1.75-0.784-1.75-1.75s0.784-1.75 1.75-1.75c0.966 0 1.75 0.784 1.75 1.75v0c-0.001 0.966-0.784 1.749-1.75 1.75h-0z">
          </path>
        </svg>
      </div>
      <div class="current-weather-info">
        <p>Current Temperature</p>
        <p class="current-weather-text"><?= $data['current']['temperature_2m'] ?><span class="unit">°C</span></p>
        <span>
          <p>UV</p>
          <p><?= $data['daily']['uv_index_max'][0] ?></p>
        </span>
      </div>
    </div>

    <div class="current-weather">
      <div class="current-weather-svg">
        <svg fill="#000000" height="75px" width="75px" version="1.1" xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 330 330" xml:space="preserve">
          <g>
            <path
              d="M209.306,50.798c-2.452-3.337-7.147-4.055-10.485-1.602c-3.338,2.453-4.055,7.147-1.603,10.485
    c54.576,74.266,66.032,123.541,66.032,151.8c0,27.691-8.272,52.794-23.293,70.685c-17.519,20.866-42.972,31.446-75.651,31.446
    c-73.031,0-98.944-55.018-98.944-102.131c0-52.227,28.103-103.234,51.679-136.829c25.858-36.847,52.11-61.415,52.37-61.657
    c3.035-2.819,3.209-7.565,0.39-10.6c-2.819-3.034-7.565-3.209-10.599-0.39c-1.11,1.031-27.497,25.698-54.254,63.765
    c-24.901,35.428-54.586,89.465-54.586,145.71c0,31.062,9.673,59.599,27.236,80.353c20.361,24.061,50.345,36.779,86.708,36.779
    c36.794,0,66.926-12.726,87.139-36.801c17.286-20.588,26.806-49.117,26.806-80.33C278.25,156.216,240.758,93.597,209.306,50.798z" />
            <path
              d="M198.43,148.146l-95.162,95.162c-2.929,2.929-2.929,7.678,0,10.606c1.465,1.464,3.385,2.197,5.304,2.197
    s3.839-0.732,5.304-2.197l95.162-95.162c2.929-2.929,2.929-7.678,0-10.606C206.107,145.217,201.359,145.217,198.43,148.146z" />
            <path d="M191.965,207.899c-13.292,0-24.106,10.814-24.106,24.106s10.814,24.106,24.106,24.106s24.106-10.814,24.106-24.106
    S205.257,207.899,191.965,207.899z M191.965,241.111c-5.021,0-9.106-4.085-9.106-9.106s4.085-9.106,9.106-9.106
    s9.106,4.085,9.106,9.106S196.986,241.111,191.965,241.111z" />
            <path d="M125.178,194.162c13.292,0,24.106-10.814,24.106-24.106s-10.814-24.106-24.106-24.106s-24.106,10.814-24.106,24.106
    S111.886,194.162,125.178,194.162z M125.178,160.949c5.021,0,9.106,4.085,9.106,9.106s-4.085,9.106-9.106,9.106
    c-5.021,0-9.106-4.085-9.106-9.106S120.156,160.949,125.178,160.949z" />
          </g>
        </svg>
      </div>
      <div class="current-weather-info">
        <p>Current Humidity</p>
        <p class="current-weather-text"><?= $data['current']['relative_humidity_2m'] ?><span class="unit">%</span></p>
        <span>
          <p>Chance Of Rain</p>
          <p><?= $data['hourly']['precipitation_probability'][$currentHour] ?>%</p>
        </span>
      </div>
    </div>

    <div class="current-weather">
      <div class="current-weather-svg">
        <svg width="75px" height="75px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M6.25 5.5C6.25 3.70508 7.70507 2.25 9.5 2.25C11.2949 2.25 12.75 3.70507 12.75 5.5C12.75 7.29493 11.2949 8.75 9.5 8.75H3C2.58579 8.75 2.25 8.41421 2.25 8C2.25 7.58579 2.58579 7.25 3 7.25H9.5C10.4665 7.25 11.25 6.4665 11.25 5.5C11.25 4.5335 10.4665 3.75 9.5 3.75C8.5335 3.75 7.75 4.5335 7.75 5.5V5.85714C7.75 6.27136 7.41421 6.60714 7 6.60714C6.58579 6.60714 6.25 6.27136 6.25 5.85714V5.5ZM14.25 7.5C14.25 5.15279 16.1528 3.25 18.5 3.25C20.8472 3.25 22.75 5.15279 22.75 7.5C22.75 9.84721 20.8472 11.75 18.5 11.75H2C1.58579 11.75 1.25 11.4142 1.25 11C1.25 10.5858 1.58579 10.25 2 10.25H18.5C20.0188 10.25 21.25 9.01878 21.25 7.5C21.25 5.98122 20.0188 4.75 18.5 4.75C16.9812 4.75 15.75 5.98122 15.75 7.5V8C15.75 8.41421 15.4142 8.75 15 8.75C14.5858 8.75 14.25 8.41421 14.25 8V7.5ZM3.25 14C3.25 13.5858 3.58579 13.25 4 13.25H18.5C20.8472 13.25 22.75 15.1528 22.75 17.5C22.75 19.8472 20.8472 21.75 18.5 21.75C16.1528 21.75 14.25 19.8472 14.25 17.5V17C14.25 16.5858 14.5858 16.25 15 16.25C15.4142 16.25 15.75 16.5858 15.75 17V17.5C15.75 19.0188 16.9812 20.25 18.5 20.25C20.0188 20.25 21.25 19.0188 21.25 17.5C21.25 15.9812 20.0188 14.75 18.5 14.75H4C3.58579 14.75 3.25 14.4142 3.25 14Z"
            fill="#1C274C" />
        </svg>
      </div>
      <div class="current-weather-info">
        <p>Wind Speed</p>
        <p class="current-weather-text"><?= $data['current']['wind_speed_10m'] ?><span class="unit">km/h</span></p>
        <span>
          <p>Wind Direction</p>
          <p><?= $data['current']['wind_direction_10m'] . "°" ?></p>
        </span>
      </div>
    </div>
  </div>

  <h1 class="weather-title">Weather Chart</h1>
  <div class="weather-chart-container">
    <div>
      <canvas id="precipitation-chart"></canvas>
    </div>
    <div>
      <canvas id="temperature-chart"></canvas>
    </div>
  </div>


  <script>
    $(document).ready(() => {
      $(".loading-layer").addClass("loading-layer-hide");
    });

    var weatherData = JSON.parse(`<?= json_encode($data) ?>`);
    var date = new Date();

    console.log(weatherData)

    var precipitationChartCtx = $("#precipitation-chart");
    var precipitationChart = new Chart(precipitationChartCtx, {
      type: 'line',
      data: {
        labels: weatherData.hourly.time.slice(date.getHours(), date.getHours() + 15).map(time => time.slice(11, 16)),
        datasets: [
          {
            label: 'Amount Of Rain (mm)',
            data: weatherData.hourly.precipitation.slice(date.getHours(), date.getHours() + 15),
            yAxisID: 'y',
            borderWidth: 1
          },
          {
            label: 'Precipitation Probability (%)',
            data: weatherData.hourly.precipitation_probability.slice(date.getHours(), date.getHours() + 15),
            yAxisID: 'y1',
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            ticks: {
              color: "rgba(54, 162, 235, 1)"
            },
            beginAtZero: true
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            ticks: {
              color: "rgba(255, 99, 132, 1)"
            },
            beginAtZero: true
          }
        }
      }
    });

    // 
    var temperatureChartCtx = $("#temperature-chart");
    var temperatureChart = new Chart(temperatureChartCtx, {
      type: 'line',
      data: {
        labels: weatherData.hourly.time.slice(date.getHours(), date.getHours() + 15).map(time => time.slice(11, 16)),
        datasets: [
          {
            label: 'Humidity (%)',
            data: weatherData.hourly.relative_humidity_2m.slice(date.getHours(), date.getHours() + 15),
            yAxisID: 'y1',
            borderWidth: 1
          },
          {
            label: 'Max Temperature (°C)',
            data: weatherData.hourly.temperature_2m.slice(date.getHours(), date.getHours() + 15),
            yAxisID: 'y',
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            ticks: {
              color: "rgba(255, 99, 132, 1)"
            }
          },
          y1: {
            type: 'linear',
            position: 'right',
            display: true,
            ticks: {
              color: "rgba(54, 162, 235, 1)"
            }
          }
        }
      }
    });
  </script>
</body>