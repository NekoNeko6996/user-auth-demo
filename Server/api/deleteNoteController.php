<?php
include "../../libraries/libraries.php";
include "../database/connect.php";

// 
if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
  header("Location: ../../Views/login.php");
  exit();
}

// delete note
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id'])) {
    // kiểm tra user có sỡ hữu note đó hay không



    // xóa note
    $sql = "DELETE FROM notes WHERE id = ?";
    $status = DBQuery($sql, [$_POST['id']], $connect)['status'];

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