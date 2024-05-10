<?php
include "../../libraries/libraries.php";
include "../database/connect.php";

// 
if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
  header("Location: ../../Views/login.php");
  exit();
}

// payload
$payload = json_decode(JWT::decode($_COOKIE['JWT'])["payload"]);

// delete note
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id']) && !empty($_POST['id'])) {
    // xóa note
    $sql = "DELETE FROM notes WHERE id = ? AND author = ?";
    $status = DBQuery($sql, [$_POST['id'], $payload->userID], $connect)['status'];

    if ($status[0] === "00000") {
      $status = "success";
      $message = "Note deleted successfully!";
    } else {
      $status = "fail";
      $message = $status[2];
    }

    echo json_encode(["status" => $status, "message" => $message]);
  }
}