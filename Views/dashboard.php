<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <div class="aside-pages" onclick="loadBody('dashboard', this)">Dashboard</div>
      <div class="aside-pages" onclick="loadBody('notes', this)">Notes</div>
      <div class="aside-pages" onclick="loadBody('chart', this)">Chart</div>
      <div class="aside-pages" onclick="loadBody('calendar', this)">Calendar</div>
      <div class="aside-pages" onclick="loadBody('weather', this)">Weather</div>
      <div class="aside-pages" onclick="loadBody('setting', this)">Setting</div>
    </div>
  </aside>
  <div class="container">
    <nav class="top-nav">
      <button type="button"><a href="../Server/api/logoutController.php">Logout</a></button>
    </nav>
    <section class="middle-section">
      <!-- body load here -->
    </section>
  </div>
</body>

</html>