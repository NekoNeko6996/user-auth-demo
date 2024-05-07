<?php
include "../../Server/database/connect.php";
include "../../libraries/libraries.php";

if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
  header("Location: /../login.php");
  exit();
}


$data = [
  [
    "id" => 1,
    "name" => "Trading 1",
    "price" => 1000,
    "amount" => 10,
    "at" => "2024-01-01 00:00:00",
  ],
  [
    "id" => 2,
    "name" => "Trading 2",
    "price" => 2000,
    "amount" => 20,
    "at" => "2024-01-02 00:00:00",
  ],
  [
    "id" => 3,
    "name" => "Trading 3",
    "price" => 3000,
    "amount" => 30,
    "at" => "2024-01-05 00:00:00",
  ],
  [
    "id" => 4,
    "name" => "Trading 4",
    "price" => 4000,
    "amount" => 40,
    "at" => "2024-01-08 00:00:00",
  ]
];

$balance = [
  [
    "id" => 1,
    "accountBalance" => 100000,
    "at" => "2024-01-01 00:00:00",
  ],
  [
    "id" => 1,
    "accountBalance" => 150000,
    "at" => "2024-01-02 00:00:00",
  ],
  [
    "id" => 1,
    "accountBalance" => 120000,
    "at" => "2024-01-05 00:00:00",
  ],
  [
    "id" => 1,
    "accountBalance" => 305000,
    "at" => "2024-01-07 00:00:00",
  ]
];

// notes loader
$notesList = DBQuery("SELECT * FROM notes", [], $connect)['result'];
?>

<body>
  <h1 class="title">Notes</h1>
  <div class="note-show-container">
    <!--class: normal warn important danger -->
    <?php if (isset($notesList[0])): ?>
      <?php foreach ($notesList as $item): ?>
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
    <?php endif; ?>

  </div>

  <div class="balance-container">

  </div>

  <h1 class="title">Trading</h1>
  <div class="group">
    <div class="trading-card-container">
      <?php foreach ($data as $item): ?>
        <div class="card">
          <div class="card-header">
            <h2><?= $item["name"] ?></h2>
          </div>
          <div class="card-body">
            <p>Price: <?= number_format($item["price"], 0, "", ".") . " VND" ?></p>
            <p>Amount: <?= $item["amount"] ?></p>
            <p>Total: <?= number_format($item["price"] * $item["amount"], 0, "", ".") . " VND" ?></p>
            <p>Trade At: <?= $item["at"] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="group">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
  </div>


  <script>
    $(document).ready(() => {
      $(".loading-layer").addClass("loading-layer-hide");
    })
  </script>
</body>