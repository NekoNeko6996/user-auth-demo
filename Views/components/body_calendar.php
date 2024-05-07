<?php
$dateEvent = [
  [
    "name" => "test",
    "body" => "test_01",
    "start" => "2024-05-01 12:30:00",
    "end" => "2024-05-01 13:30:00",
    "color" => "red"
  ]
]


  ?>

<head>
  <link rel="stylesheet" href="css/calendarPage.css">
</head>

<body>
  <h1 class="calendar-title">Calendar</h1>
  <div class="calendar-container">
    <div class="event-container"></div>
    <div class="calendar">
      <div class="calendar-header">
        <div class="change-month-container">
          <span>
            <button type="button" class="change-month-btn" id="prev-month">prev</button>
            <button type="button" class="change-month-btn" id="next-month">next</button>
          </span>
          <button type="button" class="current-day-btn" id="today-btn">today</button>
        </div>
        <div class="calendar-date">
          <p class="calendar-month-view">May</p>
          <p class="calendar-year-view">2024</p>
        </div>
        <div class="calendar-view-format">
          <button type="button" class="calendar-view-btn">month</button>
          <button type="button" class="calendar-view-btn">week</button>
          <button type="button" class="calendar-view-btn">day</button>
        </div>
      </div>
      <table>
        <thead>
          <tr class="calendar-week">
            <th class="calendar-day-week">Sun</th>
            <th class="calendar-day-week">Mon</th>
            <th class="calendar-day-week">Tue</th>
            <th class="calendar-day-week">Wed</th>
            <th class="calendar-day-week">Thu</th>
            <th class="calendar-day-week">Fri</th>
            <th class="calendar-day-week">Sat</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($row = 0; $row < 6; $row++): ?>
            <tr class="calendar-row">
              <?php for ($ceil = 0; $ceil < 7; $ceil++): ?>
                <td class="calendar-ceil">
                  <p class="calendar-day-num-p"></p>
                  <div class="calendar-day-event">
                    <div class="date-event">
                      this
                    </div>
                  </div>
                </td>
              <?php endfor; ?>
            </tr>
          <?php endfor; ?>
        </tbody>
      </table>
    </div>
  </div>


  <script>
    $(document).ready(() => {
      $(".loading-layer").addClass("loading-layer-hide");

    })

    var dateEvent = <?php echo json_encode($dateEvent) ?>;
    console.log(dateEvent);


    // load calendar
    function loadCalendar(month, year, type) {
      var monthName = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

      if (!month && !year) {
        var currentDay = new Date();
      }
      else {
        var currentDay = new Date(year, month, 1);
      }

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
      $(".calendar-day-num-p").each((index, element) => {
        $(element).text(calendarDateArray[index]);
        if (calendarDateArray[index] == 1) {
          countColor++
        }
        if (countColor == 1 && new Date(currentDay.getFullYear(), currentDay.getMonth(), calendarDateArray[index]).getTime() == new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate()).getTime()) {
          $(element).parent().css("backgroundColor", "rgba(154, 194, 255, 0.74)");
        }
        else $(element).parent().css("backgroundColor", "white");

        $(element).css("color", dateColor[countColor]);
      })

      $(".calendar-month-view").text(monthName[currentDay.getMonth()]);
      $(".calendar-year-view").text(currentDay.getFullYear());
    }

    loadCalendar(null, null)

    // change month
    var GL_current_month = new Date().getMonth();
    var GL_current_year = new Date().getFullYear();

    $(".change-month-btn").click((event) => {
      console.log(GL_current_month, GL_current_year);

      if (event.target.id == "prev-month") {
        if (GL_current_month <= 1) {
          GL_current_month = 12;
          GL_current_year--;
        }
        else GL_current_month--;
      }
      else if (event.target.id == "next-month") {
        if (GL_current_month >= 12) {
          GL_current_month = 1;
          GL_current_year++;
        }
        else GL_current_month++;
      }
      loadCalendar(GL_current_month, GL_current_year);
    })

    $("#today-btn").click(() => {
      GL_current_month = new Date().getMonth();
      GL_current_year = new Date().getFullYear();

      loadCalendar(null, null);
    })



  </script>
</body>