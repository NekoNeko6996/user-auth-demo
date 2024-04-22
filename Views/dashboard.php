<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/homePage.css">
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
]


  ?>

<body>
  <nav class="top-nav">
    <button type="button"><a href="../Server/api/logoutController.php">Logout</a></button>
  </nav>
  <div class="container">
    <aside class="aside-left"></aside>
    <section class="middle-section">
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
    <aside class="aside-right"></aside>
  </div>
</body>

</html>