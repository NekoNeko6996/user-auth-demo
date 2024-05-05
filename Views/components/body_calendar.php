<?php

?>

<head>
  <link rel="stylesheet" href="css/calendarPage.css">
</head>

<body>
  <h1 class="calendar-title">Calendar</h1>
  <div class="calendar-container">
    <div class="event-container"></div>
    <div class="calendar">
      <div class="calendar-header"></div>
      <div class="calendar-week">
        <div class="calendar-day-week">Sun</div>
        <div class="calendar-day-week">Mon</div>
        <div class="calendar-day-week">Tue</div>
        <div class="calendar-day-week">Wed</div>
        <div class="calendar-day-week">Thu</div>
        <div class="calendar-day-week">Fri</div>
        <div class="calendar-day-week">Sat</div>
      </div>
      <div class="calendar-body">
        <?php for ($ceil = 0; $ceil < 42; $ceil++): ?>
          <div class="calendar-ceil">
            <p class="calendar-day-num-p"></p>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>


  <script>
    $(document).ready(() => {
      $(".loading-layer").addClass("loading-layer-hide");

    })

    function loadCalendar() {
      var currentDay = new Date();

      var lastDayOfLastMonth = new Date(currentDay.getFullYear(), currentDay.getMonth(), 0);
      var firstDay = new Date(currentDay.getFullYear(), currentDay.getMonth(), 1);
      var lastDayOfCurrentMonth = new Date(currentDay.getFullYear(), currentDay.getMonth() + 1, 0);


      var day = firstDay.getDay() - 1;

      var calendarDateArray = new Array(42);
      for (let i = 0; i < 42; i++) {
        if (i <= day) {
          calendarDateArray[i] = lastDayOfLastMonth.getDate() - day + i;
        }
        if (i > day && i <= lastDayOfCurrentMonth.getDate() + day) {
          calendarDateArray[i] = i - day;
        }
        if (i > lastDayOfCurrentMonth.getDate() + day) {
          calendarDateArray[i] = i - lastDayOfCurrentMonth.getDate() - day;
        }
      }

      var dateColor = ["rgba(104, 104, 104, 0.274)", "black", "rgba(104, 104, 104, 0.5)"];
      var countColor = 0;
      console.log(calendarDateArray);
      $(".calendar-day-num-p").each((index, element) => {
        $(element).text(calendarDateArray[index]);
        if (calendarDateArray[index] == 1) {
          countColor++
        }
        if (countColor == 1 && calendarDateArray[index] == currentDay.getDate()) {
          $(element).parent().css("backgroundColor", "rgba(154, 194, 255, 0.74)");
        }
        else $(element).css("color", dateColor[countColor]);
      })
    }

    loadCalendar()


    // navigator.geolocation.getCurrentPosition(position => {
    //   console.log(position);
    // })

  </script>
</body>