<?php
include "../../libraries/libraries.php";
include "../database/connect.php";

// 
if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
  header("Location: ../../Views/login.php");
  exit();
}

// check password
function checkPassword($password)
{
  return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

//
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['new-password']) && !empty($_POST['new-password']) && isset($_POST['old-password']) && !empty($_POST['old-password'])) {
    if (!checkPassword($_POST['new-password'])) {
      echo json_encode(["status" => "fail", "message" => "Password is not valid!"]);
      exit();
    }

    // check user
    $payload = json_decode(JWT::decode($_COOKIE['JWT'])["payload"]);

    $sql = "SELECT * FROM users WHERE userEmail = ?";
    $user = DBQuery($sql, [$payload->email], $connect)['result'];
    if (empty($user)) {
      echo json_encode(["status" => "fail", "message" => "Wrong token!"]);
      exit();
    }
    if (!password_verify($_POST['old-password'], $user[0]['hashString'])) {
      echo json_encode(["status" => "fail", "message" => "Wrong old password!"]);
      exit();
    }

    // hash new password
    $hashedPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
    $sql = "UPDATE users SET hashString = ? WHERE userID = ?";
    DBQuery($sql, [$hashedPassword, $payload->userID], $connect);

    // update cookie
    $expiry = time() + 3600 * 24;
    $JWT = JWT::create([
      "email" => $user[0]['userEmail'],
      "permissionID" => $user[0]['permissionID'],
      "userID" => $user[0]['userID'],
      "expiry" => $expiry
    ]);

    setcookie("JWT", $JWT, $expiry, "/", $GLOBALS['CONFIG']['web-domain']);

    echo json_encode(["status" => "success", "message" => "Password changed successfully!"]);
  } else {
    echo json_encode(["status" => "fail", "message" => "Something went wrong!"]);
  }
}