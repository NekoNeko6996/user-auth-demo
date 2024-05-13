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
    "name" => "spending 1",
    "price" => 1000,
    "amount" => 10,
    "at" => "2024-01-01 00:00:00",
  ],
  [
    "id" => 2,
    "name" => "spending 2",
    "price" => 2000,
    "amount" => 20,
    "at" => "2024-01-02 00:00:00",
  ],
  [
    "id" => 3,
    "name" => "spending 3",
    "price" => 3000,
    "amount" => 30,
    "at" => "2024-01-05 00:00:00",
  ],
  [
    "id" => 4,
    "name" => "spending 4",
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


//
$payload = json_decode(JWT::decode($_COOKIE['JWT'])["payload"]);

// notes loader
$notesList = DBQuery("SELECT * FROM notes WHERE author = ? LIMIT 4", [$payload->userID], $connect)['result'];
?>

<body>
  <!-- scroll -->
  <div class="scroll-bar"></div>
  <h1 class="title">Notes</h1>
  <div class="note-show-container">
    <!--class: normal warn important danger -->
    <?php if (isset($notesList[0])): ?>
      <?php foreach ($notesList as $item): ?>
        <div class="note <?= $item["tab"] ?>">
          <div class="note-header">
            <input type="text" value="<?= $item["title"] ?>" class="note-title">
            <span>
              <button type="button" class="edit-note-button">✔</button>
              <button type="button" class="delete-note-button" onclick="deleteNote(<?= $item['id'] ?>)">✘</button>
            </span>
          </div>
          <div class="note-body">
            <textarea><?= $item["content"] ?></textarea>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <!-- crete new note -->
    <div class=" note-create-news" onclick="showAddNewNoteForm(true)">
      <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M12.75 9C12.75 8.58579 12.4142 8.25 12 8.25C11.5858 8.25 11.25 8.58579 11.25 9L11.25 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H11.25V15C11.25 15.4142 11.5858 15.75 12 15.75C12.4142 15.75 12.75 15.4142 12.75 15L12.75 12.75H15C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H12.75V9Z"
          fill="#3b4046ad" />
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M12 1.25C6.06294 1.25 1.25 6.06294 1.25 12C1.25 17.9371 6.06294 22.75 12 22.75C17.9371 22.75 22.75 17.9371 22.75 12C22.75 6.06294 17.9371 1.25 12 1.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75C17.1086 2.75 21.25 6.89137 21.25 12C21.25 17.1086 17.1086 21.25 12 21.25C6.89137 21.25 2.75 17.1086 2.75 12Z"
          fill="#3b4046ad" />
      </svg>
    </div>
  </div>

  <div class="balance-container">

  </div>

  <h1 class="title">Spending</h1>
  <div class="group">
    <div class="spending-card-container">
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

    <div class="add-spending-form-container">
      <div class="add-spending-form-header">
        <h2>Add New Spending</h2>
      </div>

      <form action="#" class="add-spending-form-body">
        <div class="lb-input-form-group">
          <input type="text" id="spending-name">
          <label for="spending-name">Name</label>
        </div>
        <div class="lb-input-form-group">
          <input type="number" id="spending-price">
          <label for="spending-price">Price</label>
        </div>
        <div class="lb-input-form-group">
          <input type="number" id="spending-amount">
          <label for="spending-amount">Amount</label>
        </div>
        <span>
          <div class="form-group">
            <label for="spending-category">Category</label>
            <select name="category" id="category">
              <option value="normal">Normal</option>
              <option value="important">Important</option>
              <option value="warn">Warn</option>
              <option value="danger">Danger</option>
            </select>
          </div>
          <div class="form-group">
            <label for="spending-at">Trade At</label>
            <input type="date" id="spending-at">
          </div>
        </span>
        <div class="form-group">
          <button type="submit">Add</button>
        </div>
      </form>
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

    // delete note
    function deleteNote(id) {
      if (!confirm("Are you sure?")) return;
      $.ajax({
        url: "../Server/api/deleteNoteController.php",
        type: "POST",
        data: {
          id
        },
        success: (response) => {
          try {
            var response = JSON.parse(response);
            if (response.status == "success") {
              loadBody("dashboard", $(".aside-pages").children().prevObject[0]);
            }
          }
          catch (error) {
            console.log(response);
          }
        },
        error: (error) => {
          console.log(error);
        }
      })
    }
  </script>
</body>