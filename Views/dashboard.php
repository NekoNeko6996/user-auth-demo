<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../libraries/jquery.min.js"></script>
  <script src="js/dashboardPage.js"></script>
  <link rel="stylesheet" href="css/dashboard.css">
  <title>Dashboard</title>
</head>

<?php
include "../Server/database/connect.php";
include "../libraries/libraries.php";

if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
  header("Location: login.php");
  exit();
}

$payload = json_decode(JWT::decode($_COOKIE['JWT'])["payload"]);

?>

<body>
  <aside class="aside-left">
    <div class="logo"></div>

    <!-- create new btn -->
    <button type="button" class="create-new-button">Create New +</button>

    <!-- timeline -->
    <div class="aside-option-container">
      <div class="aside-pages" onclick="loadBody('dashboard', this)">
        <svg width="28px" height="28px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M12 12C12 11.4477 12.4477 11 13 11H19C19.5523 11 20 11.4477 20 12V19C20 19.5523 19.5523 20 19 20H13C12.4477 20 12 19.5523 12 19V12Z"
            stroke="white" stroke-width="2" stroke-linecap="round" />
          <path
            d="M4 5C4 4.44772 4.44772 4 5 4H8C8.55228 4 9 4.44772 9 5V19C9 19.5523 8.55228 20 8 20H5C4.44772 20 4 19.5523 4 19V5Z"
            stroke="white" stroke-width="2" stroke-linecap="round" />
          <path
            d="M12 5C12 4.44772 12.4477 4 13 4H19C19.5523 4 20 4.44772 20 5V7C20 7.55228 19.5523 8 19 8H13C12.4477 8 12 7.55228 12 7V5Z"
            stroke="white" stroke-width="2" stroke-linecap="round" />
        </svg>
        <p>Dashboard</p>
      </div>
      <div class="aside-pages" onclick="loadBody('notes', this)">
        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M10 12H14M12 10V14M19.9592 15H16.6C16.0399 15 15.7599 15 15.546 15.109C15.3578 15.2049 15.2049 15.3578 15.109 15.546C15 15.7599 15 16.0399 15 16.6V19.9592M20 14.1031V7.2C20 6.07989 20 5.51984 19.782 5.09202C19.5903 4.71569 19.2843 4.40973 18.908 4.21799C18.4802 4 17.9201 4 16.8 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40973 4.40973 4.71569 4.21799 5.09202C4 5.51984 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H14.1031C14.5923 20 14.8369 20 15.067 19.9447C15.2711 19.8957 15.4662 19.8149 15.6451 19.7053C15.847 19.5816 16.0199 19.4086 16.3658 19.0627L19.0627 16.3658C19.4086 16.0199 19.5816 15.847 19.7053 15.6451C19.8149 15.4662 19.8957 15.2711 19.9447 15.067C20 14.8369 20 14.5923 20 14.1031Z"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p>Notes</p>
      </div>
      <div class="aside-pages" onclick="loadBody('chart', this)">
        <svg width="28px" height="28px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M3 14.6C3 14.0399 3 13.7599 3.10899 13.546C3.20487 13.3578 3.35785 13.2049 3.54601 13.109C3.75992 13 4.03995 13 4.6 13H5.4C5.96005 13 6.24008 13 6.45399 13.109C6.64215 13.2049 6.79513 13.3578 6.89101 13.546C7 13.7599 7 14.0399 7 14.6V19.4C7 19.9601 7 20.2401 6.89101 20.454C6.79513 20.6422 6.64215 20.7951 6.45399 20.891C6.24008 21 5.96005 21 5.4 21H4.6C4.03995 21 3.75992 21 3.54601 20.891C3.35785 20.7951 3.20487 20.6422 3.10899 20.454C3 20.2401 3 19.9601 3 19.4V14.6Z"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path
            d="M10 4.6C10 4.03995 10 3.75992 10.109 3.54601C10.2049 3.35785 10.3578 3.20487 10.546 3.10899C10.7599 3 11.0399 3 11.6 3H12.4C12.9601 3 13.2401 3 13.454 3.10899C13.6422 3.20487 13.7951 3.35785 13.891 3.54601C14 3.75992 14 4.03995 14 4.6V19.4C14 19.9601 14 20.2401 13.891 20.454C13.7951 20.6422 13.6422 20.7951 13.454 20.891C13.2401 21 12.9601 21 12.4 21H11.6C11.0399 21 10.7599 21 10.546 20.891C10.3578 20.7951 10.2049 20.6422 10.109 20.454C10 20.2401 10 19.9601 10 19.4V4.6Z"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path
            d="M17 10.6C17 10.0399 17 9.75992 17.109 9.54601C17.2049 9.35785 17.3578 9.20487 17.546 9.10899C17.7599 9 18.0399 9 18.6 9H19.4C19.9601 9 20.2401 9 20.454 9.10899C20.6422 9.20487 20.7951 9.35785 20.891 9.54601C21 9.75992 21 10.0399 21 10.6V19.4C21 19.9601 21 20.2401 20.891 20.454C20.7951 20.6422 20.6422 20.7951 20.454 20.891C20.2401 21 19.9601 21 19.4 21H18.6C18.0399 21 17.7599 21 17.546 20.891C17.3578 20.7951 17.2049 20.6422 17.109 20.454C17 20.2401 17 19.9601 17 19.4V10.6Z"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p>Chart</p>
      </div>
      <div class="aside-pages" onclick="loadBody('calendar', this)">
        <svg width="28px" height="28px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M10 21H6.2C5.0799 21 4.51984 21 4.09202 20.782C3.71569 20.5903 3.40973 20.2843 3.21799 19.908C3 19.4802 3 18.9201 3 17.8V8.2C3 7.0799 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H17.8C18.9201 5 19.4802 5 19.908 5.21799C20.2843 5.40973 20.5903 5.71569 20.782 6.09202C21 6.51984 21 7.0799 21 8.2V10M7 3V5M17 3V5M3 9H21M13.5 13.0001L7 13M10 17.0001L7 17M14 21L16.025 20.595C16.2015 20.5597 16.2898 20.542 16.3721 20.5097C16.4452 20.4811 16.5147 20.4439 16.579 20.399C16.6516 20.3484 16.7152 20.2848 16.8426 20.1574L21 16C21.5523 15.4477 21.5523 14.5523 21 14C20.4477 13.4477 19.5523 13.4477 19 14L14.8426 18.1574C14.7152 18.2848 14.6516 18.3484 14.601 18.421C14.5561 18.4853 14.5189 18.5548 14.4903 18.6279C14.458 18.7102 14.4403 18.7985 14.405 18.975L14 21Z"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p>Calendar</p>
      </div>
      <div class="aside-pages" onclick="loadBody('weather', this)">
        <svg width="29px" height="29px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
          <path
            d="m 7.5 0.5 c -0.277344 0 -0.5 0.222656 -0.5 0.5 v 1.53125 l -1.253906 -0.714844 c -0.238282 -0.136718 -0.542969 -0.054687 -0.679688 0.183594 c -0.136718 0.242188 -0.054687 0.546875 0.183594 0.683594 l 1.75 1 v 3.449218 l -2.988281 -1.726562 l 0.007812 -2.011719 c 0 -0.273437 -0.222656 -0.5 -0.496093 -0.5 c -0.277344 0 -0.5 0.222657 -0.5 0.496094 l -0.007813 1.441406 l -1.328125 -0.765625 c -0.113281 -0.066406 -0.25 -0.085937 -0.378906 -0.050781 s -0.238282 0.121094 -0.304688 0.234375 s -0.085937 0.25 -0.050781 0.378906 s 0.121094 0.238282 0.234375 0.304688 l 1.328125 0.765625 l -1.246094 0.726562 c -0.238281 0.136719 -0.320312 0.445313 -0.179687 0.683594 c 0.136718 0.238281 0.441406 0.320313 0.683594 0.179687 l 1.738281 -1.015624 l 2.988281 1.726562 l -2.988281 1.726562 l -1.738281 -1.015624 c -0.242188 -0.140626 -0.546876 -0.058594 -0.683594 0.183593 c -0.140625 0.238281 -0.058594 0.542969 0.179687 0.679688 l 1.246094 0.726562 l -1.328125 0.765625 c -0.113281 0.066406 -0.199219 0.175782 -0.234375 0.304688 s -0.015625 0.265625 0.050781 0.378906 h 0.003906 c 0.136719 0.238281 0.441407 0.320312 0.679688 0.183594 l 1.328125 -0.765625 l 0.007813 1.441406 c 0 0.273437 0.222656 0.5 0.5 0.496094 c 0.273437 0 0.496093 -0.222657 0.496093 -0.5 l -0.007812 -2.011719 l 2.988281 -1.726562 v 3.5 l -1.746094 0.988281 c -0.117187 0.0625 -0.199218 0.171875 -0.234375 0.300781 c -0.039062 0.125 -0.019531 0.261719 0.046875 0.378906 c 0.0625 0.117188 0.171875 0.199219 0.300782 0.234375 c 0.125 0.039063 0.261718 0.019531 0.378906 -0.042969 l 1.253906 -0.710937 v 1.484375 c 0 0.277344 0.222656 0.5 0.5 0.5 s 0.5 -0.222656 0.5 -0.5 v -1.484375 l 1.253906 0.710937 c 0.117188 0.0625 0.253906 0.082032 0.378906 0.042969 c 0.128907 -0.035156 0.238282 -0.117187 0.304688 -0.234375 c 0.0625 -0.117187 0.082031 -0.253906 0.042969 -0.378906 c -0.035157 -0.128906 -0.117188 -0.238281 -0.234375 -0.300781 l -1.746094 -0.988281 v -3.5 l 3.03125 1.75 l -0.015625 2.007812 c -0.003906 0.273438 0.21875 0.5 0.492187 0.5 c 0.132813 0.003906 0.261719 -0.046875 0.355469 -0.140625 s 0.148438 -0.21875 0.152344 -0.351563 l 0.011719 -1.441406 l 1.285156 0.742188 c 0.238281 0.136718 0.542969 0.054687 0.683594 -0.183594 c 0.136718 -0.238281 0.054687 -0.546875 -0.183594 -0.683594 l -1.285156 -0.742187 l 1.242187 -0.730469 c 0.113281 -0.066406 0.195313 -0.175781 0.226563 -0.304688 c 0.035156 -0.128906 0.015625 -0.265624 -0.050782 -0.382812 c -0.140624 -0.234375 -0.449218 -0.3125 -0.683593 -0.175781 l -1.730469 1.019531 l -3.03125 -1.75 l 3.03125 -1.75 l 1.730469 1.019531 c 0.234375 0.140625 0.542969 0.058594 0.683593 -0.175781 c 0.066407 -0.117188 0.085938 -0.253906 0.050782 -0.382812 c -0.03125 -0.128907 -0.113282 -0.238282 -0.226563 -0.304688 l -1.242187 -0.730469 l 1.285156 -0.742187 c 0.238281 -0.136719 0.320312 -0.445313 0.183594 -0.683594 c -0.140625 -0.238281 -0.445313 -0.320312 -0.683594 -0.183594 l -1.285156 0.742188 l -0.011719 -1.441406 c -0.003906 -0.132813 -0.058594 -0.257813 -0.152344 -0.351563 s -0.222656 -0.144531 -0.355469 -0.140625 c -0.277343 0 -0.496093 0.226562 -0.492187 0.503906 l 0.015625 2.003906 l -3.03125 1.75 v -3.449218 l 1.75 -1 c 0.238281 -0.136719 0.320312 -0.441406 0.183594 -0.683594 c -0.136719 -0.238281 -0.441406 -0.320312 -0.679688 -0.183594 l -1.253906 0.714844 v -1.53125 c 0 -0.277344 -0.222656 -0.5 -0.5 -0.5 z m 0 0"
            fill="white" />
        </svg>
        <p>Weather</p>
      </div>
      <div class="aside-pages" onclick="loadBody('setting', this)">
        <svg width="28px" height="28px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
            stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
          <path
            d="M2 12.8799V11.1199C2 10.0799 2.85 9.21994 3.9 9.21994C5.71 9.21994 6.45 7.93994 5.54 6.36994C5.02 5.46994 5.33 4.29994 6.24 3.77994L7.97 2.78994C8.76 2.31994 9.78 2.59994 10.25 3.38994L10.36 3.57994C11.26 5.14994 12.74 5.14994 13.65 3.57994L13.76 3.38994C14.23 2.59994 15.25 2.31994 16.04 2.78994L17.77 3.77994C18.68 4.29994 18.99 5.46994 18.47 6.36994C17.56 7.93994 18.3 9.21994 20.11 9.21994C21.15 9.21994 22.01 10.0699 22.01 11.1199V12.8799C22.01 13.9199 21.16 14.7799 20.11 14.7799C18.3 14.7799 17.56 16.0599 18.47 17.6299C18.99 18.5399 18.68 19.6999 17.77 20.2199L16.04 21.2099C15.25 21.6799 14.23 21.3999 13.76 20.6099L13.65 20.4199C12.75 18.8499 11.27 18.8499 10.36 20.4199L10.25 20.6099C9.78 21.3999 8.76 21.6799 7.97 21.2099L6.24 20.2199C5.33 19.6999 5.02 18.5299 5.54 17.6299C6.45 16.0599 5.71 14.7799 3.9 14.7799C2.85 14.7799 2 13.9199 2 12.8799Z"
            stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p>Setting</p>
      </div>
      <hr>
      <div class="aside-pages" onclick="loadBody('games', this)">
        <svg width="28px" height="28px" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" fill="none">
          <circle cx="53.5" cy="53.5" r="31.5" stroke="white" stroke-width="12" />
          <circle cx="53.5" cy="138.5" r="31.5" stroke="white" stroke-width="12" />
          <circle cx="138.5" cy="138.5" r="31.5" stroke="white" stroke-width="12" />
          <path stroke="white" stroke-linecap="round" stroke-width="12"
            d="m113 28 25.5 25.5M164 79l-25.5-25.5m0 0L164 28m-25.5 25.5L113 79" />
        </svg>
        <p>Games</p>
      </div>
    </div>
  </aside>
  <div class="container">
    <!-- top nav -->
    <nav class="top-nav">
      <button type="button"><a href="../Server/api/logoutController.php">Logout</a></button>
    </nav>
    <section class="middle-section">
      <!-- body load here -->
    </section>
  </div>


  <!-- add new note layer -->
  <div class="add-new-note-floating-layer">
    <div class="add-new-note-container">
      <div class="add-new-note-header">
        <h2>Add New Note</h2>
      </div>
      <div class="add-new-note-body">
        <form action="#" id="add-new-note-form" onsubmit="addNewNote(event)">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="note-title" placeholder="title note..." required>
          </div>
          <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="note-content" placeholder="do something..."></textarea>
          </div>
          <div class="form-group">
            <span>
              <input type="radio" name="note-tab" id="normal-radio" value="normal" required checked>
              <label for="normal-radio">Normal</label>
              <div class="note-tab-color" style="background-color: var(--note-normal-background-color)"></div>
            </span>

            <span>
              <input type="radio" name="note-tab" id="warn-radio" value="warn">
              <label for="warn-radio">Warn</label>
              <div class="note-tab-color" style="background-color: var(--note-warn-background-color)"></div>
            </span>

            <span>
              <input type="radio" name="note-tab" id="important-radio" value="important">
              <label for="important-radio">Important</label>
              <div class="note-tab-color" style="background-color: var(--note-important-background-color)"></div>
            </span>

            <span>
              <input type="radio" name="note-tab" id="danger-radio" value="danger">
              <label for="danger-radio">Danger</label>
              <div class="note-tab-color" style="background-color: var(--note-danger-background-color)"></div>
            </span>
          </div>
          <div class="form-group">
            <button type="button" class="add-button" onclick="addNewNote(event)">Add</button>
            <button type="button" class="cancel-button" onclick="showAddNewNoteForm(false)">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- loading layer -->
  <div class="loading-layer">
    <div class="lds-ellipsis">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
    <h2>Now loading...</h2>
  </div>

  <!-- small message box -->
  <div class="small-message-box">
    <p>...</p>
  </div>


</body>

</html>