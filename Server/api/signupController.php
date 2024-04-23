<?php
include "../../libraries/libraries.php";
include "../database/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['nickname']) && isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['nickname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $nickname = convertString($_POST['nickname']);
    $email = strtolower(convertString($_POST['email']));
    $password = $_POST['password'];

    //hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $status = DBQuery("INSERT INTO users (nickname, userEmail, hashString) VALUES (?, ?, ?)", [$nickname, $email, $hash], $connect)['status'];

    if ($status[0] === "00000") {
      $expiry = time() + 3600 * 24;
      $userID = DBQuery("SELECT userID FROM users WHERE userEmail = ?", [$email], $connect)['result'][0]['userID'];

      $JWT = JWT::create([
        "email" => $email,
        "nickname" => $nickname,
        "permissionID" => $GLOBALS['CONFIG']['default-permission'],
        "userID" => $userID,
        "expiry" => $expiry
      ]);

      if (setcookie("JWT", $JWT, $expiry, "/", $GLOBALS['CONFIG']['web-domain'])) {
        echo json_encode(["status" => "success"]);
        $_POST["nickname"] = "";
        $_POST["email"] = "";
        $_POST["password"] = "";
      } else {
        echo json_encode(["status" => false, 'message' => "Something went wrong!"]);
      }
    } else {
      echo json_encode(["status" => false, 'message' => "[SQL ERROR] Code: " . $status[0] . " Message: " . $status[1]]);
    }
  }
}