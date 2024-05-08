<?php
include "../../Server/database/connect.php";
include "../../libraries/libraries.php";

if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
  header("Location: ../../Views/login.php");
  exit();
}

// add new note
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['note-title']) && !empty($_POST['note-title']) && isset($_POST['note-content']) && !empty($_POST['note-content']) && isset($_POST['note-tab']) && !empty($_POST['note-tab'])) {
    $title = convertString($_POST['note-title']);
    $content = convertString($_POST['note-content']);
    $tab = convertString($_POST['note-tab']);

    $sql = "INSERT INTO notes (title, content, tab) VALUES (?, ?, ?)";
    $status = DBQuery($sql, [$title, $content, $tab], $connect)['status'];

    if ($status[0] === "00000") {
      $status = "success";
      $message = "Note added successfully!";
    } else {
      $status = "fail";
      $message = $status[2];
    }

    echo json_encode(["tile" => $title, "content" => $content, "tab" => $tab, "status" => $status, "message" => $message]);
  }
}