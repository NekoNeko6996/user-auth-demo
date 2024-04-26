<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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


$data = [
  [
    "id" => 1,
    "name" => "Trading 1",
    "price" => 1000,
    "amount" => 10,
    "tradeAt" => date("Y-m-d H:i:s"),
  ],
  [
    "id" => 2,
    "name" => "Trading 2",
    "price" => 2000,
    "amount" => 20,
    "tradeAt" => date("Y-m-d H:i:s"),
  ]
];

$note = [
  [
    "id" => 1,
    "tab" => "normal",
    "title" => "Note 1",
    "content" => "This is note 1",
    "createdAt" => date("Y-m-d H:i:s"),
    "updatedAt" => date("Y-m-d H:i:s"),
    "completed" => false,
    "completedAt" => null,
    "deletedAt" => null,
  ],
  [
    "id" => 2,
    "tab" => "important",
    "title" => "Note 2",
    "content" => "This is note 2",
    "createdAt" => date("Y-m-d H:i:s"),
    "updatedAt" => date("Y-m-d H:i:s"),
    "completed" => false,
    "completedAt" => null,
    "deletedAt" => null,
  ],
  [
    "id" => 3,
    "tab" => "warn",
    "title" => "Note 3",
    "content" => "This is note 3",
    "createdAt" => date("Y-m-d H:i:s"),
    "updatedAt" => date("Y-m-d H:i:s"),
    "completed" => false,
    "completedAt" => null,
    "deletedAt" => null,
  ],
  [
    "id" => 4,
    "tab" => "danger",
    "title" => "Note 4",
    "content" => "This is note 4",
    "createdAt" => date("Y-m-d H:i:s"),
    "updatedAt" => date("Y-m-d H:i:s"),
    "completed" => false,
    "completedAt" => null,
    "deletedAt" => null,
  ],
  [
    "id" => 5,
    "tab" => "important",
    "title" => "Note 5",
    "content" => "This is note 5",
    "createdAt" => date("Y-m-d H:i:s"),
    "updatedAt" => date("Y-m-d H:i:s"),
    "completed" => false,
    "completedAt" => null,
    "deletedAt" => null,
  ],
  [
    "id" => 5,
    "tab" => "important",
    "title" => "Note 5",
    "content" => "This is note 5",
    "createdAt" => date("Y-m-d H:i:s"),
    "updatedAt" => date("Y-m-d H:i:s"),
    "completed" => false,
    "completedAt" => null,
    "deletedAt" => null,
  ]
];

?>

<body>
  <aside class="aside-left">
    <div class="logo"></div>

    <!-- create new btn -->
    <button type="button" class="create-new-trade-button">Create New +</button>

    <!-- timeline -->
    <div class="aside-option-container">
      <div class="dropdown-menu">
        <div class="title" onclick="toggleMenu()">
          Select year
        </div>
        <div class="menu">
          <p>2019</p>
          <p>2020</p>
          <p>2021</p>
          <p>2022</p>
          <p>2023</p>
          <p>2024</p>
        </div>
      </div>
    </div>
  </aside>
  <div class="container">
    <nav class="top-nav">
      <button type="button"><a href="../Server/api/logoutController.php">Logout</a></button>
    </nav>
    <section class="middle-section">
      <div class="note-show-container">
        <!--class: normal warn important danger -->
        <?php foreach ($note as $item): ?>
          <div class="note <?= $item["tab"] ?>">
            <div class="note-header">
              <h3><?= $item["title"] ?></h3>
              <span>
                <button type="button" class="edit-note-button">✔</button>
                <button type="button" class="delete-note-button">✘</button>
              </span>
            </div>
            <div class="note-body">
              <p><?= $item["content"] ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <?php foreach ($data as $item): ?>
        <div class="card">
          <div class="card-header">
            <h2><?= $item["name"] ?></h2>
          </div>
          <div class="card-body">
            <p>Price: <?= number_format($item["price"], 0, "", ".") . " VND" ?></p>
            <p>Amount: <?= $item["amount"] ?></p>
            <p>Total: <?= number_format($item["price"] * $item["amount"], 0, "", ".") . " VND" ?></p>
            <p>Trade At: <?= $item["tradeAt"] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
  </div>


  <script>
    function toggleMenu() {
      const menu = $(".menu");
      if (menu.hasClass("active")) {
        menu.removeClass("active");
      }
      else {
        menu.addClass("active");
      }
      console.log(menu.hasClass("active"));
    }
  </script>
</body>

</html>