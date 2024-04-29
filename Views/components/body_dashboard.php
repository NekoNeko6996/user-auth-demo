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
    "tradeAt" => date("Y-m-d H:i:s"),
  ],
  [
    "id" => 2,
    "name" => "Trading 2",
    "price" => 2000,
    "amount" => 20,
    "tradeAt" => date("Y-m-d H:i:s"),
  ],
  [
    "id" => 3,
    "name" => "Trading 3",
    "price" => 3000,
    "amount" => 30,
    "tradeAt" => date("Y-m-d H:i:s"),
  ],
  [
    "id" => 4,
    "name" => "Trading 4",
    "price" => 4000,
    "amount" => 40,
    "tradeAt" => date("Y-m-d H:i:s"),
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
            <p>Trade At: <?= $item["tradeAt"] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="map-container">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d251630.7434784939!2d105.44729142224281!3d9.788867042466181!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0f291eda269b3%3A0x79a372e92efed9e5!2zSOG6rXUgR2lhbmcsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1714351287770!5m2!1svi!2s"
        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        class="gg-map-iframe">
      </iframe>
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
</body>