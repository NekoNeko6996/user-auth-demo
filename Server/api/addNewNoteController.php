<?php
include "../../Server/database/connect.php";
include "../../libraries/libraries.php";

if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
  header("Location: ../../Views/login.php");
  exit();
}
// payload
$payload = json_decode(JWT::decode($_COOKIE['JWT'])["payload"]);

// add new note
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['note-title']) && !empty($_POST['note-title']) && isset($_POST['note-content']) && !empty($_POST['note-content']) && isset($_POST['note-tab']) && !empty($_POST['note-tab'])) {
    $title = convertString($_POST['note-title']);
    $content = convertString($_POST['note-content']);
    $tab = convertString($_POST['note-tab']);

    $sql = "INSERT INTO notes (title, content, userID, tab) VALUES (?, ?, ?, ?)";
    $status = DBQuery($sql, [$title, $content, $payload->userID, $tab], $connect)['status'];

    if ($status[0] === "00000") {
      $status = "success";
      $message = "Note added successfully!";
      $newNoteArray = DBQuery("SELECT * FROM notes WHERE userID = ?", [$payload->userID], $connect)['result'];
    } else {
      $status = "fail";
      $message = $status[2];
      $newNoteArray = null;
    }

    echo json_encode(["status" => $status, "message" => $message, "newNoteArray" => $newNoteArray]);
  }
}